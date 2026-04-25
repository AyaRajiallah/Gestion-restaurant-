"""Modeles de donnees pour les utilisateurs et leur espace."""

from django.contrib.auth.base_user import BaseUserManager
from django.contrib.auth.models import AbstractUser
from django.db import models


class EmailUserManager(BaseUserManager):
    """Manager personnalise pour utiliser l'email a la place du username."""

    use_in_migrations = True

    # Cette methode centralise la creation de tous les utilisateurs.
    def _create_user(self, email: str, password: str, **extra_fields):
        if not email:
            raise ValueError("L'adresse email est obligatoire.")

        email = self.normalize_email(email)
        user = self.model(email=email, **extra_fields)
        user.set_password(password)
        user.save(using=self._db)
        return user

    # Cette methode cree un utilisateur standard.
    def create_user(self, email: str, password: str | None = None, **extra_fields):
        extra_fields.setdefault("is_staff", False)
        extra_fields.setdefault("is_superuser", False)
        extra_fields.setdefault("role", "user")
        return self._create_user(email, password, **extra_fields)

    # Cette methode cree un super-utilisateur compatible avec l'admin Django.
    def create_superuser(self, email: str, password: str, **extra_fields):
        extra_fields.setdefault("is_staff", True)
        extra_fields.setdefault("is_superuser", True)
        extra_fields.setdefault("role", "admin")
        extra_fields.setdefault("account_type", "company")

        if extra_fields.get("is_staff") is not True:
            raise ValueError("Le super-utilisateur doit avoir is_staff=True.")
        if extra_fields.get("is_superuser") is not True:
            raise ValueError("Le super-utilisateur doit avoir is_superuser=True.")

        return self._create_user(email, password, **extra_fields)


class User(AbstractUser):
    """Utilisateur principal du projet avec distinction candidat, entreprise et admin."""

    ACCOUNT_TYPE_CHOICES = (
        ("candidate", "Candidat"),
        ("company", "Entreprise"),
    )

    ROLE_CHOICES = (
        ("user", "Utilisateur"),
        ("admin", "Administrateur"),
    )

    STAGE_CHOICES = (
        ("profile_created", "Profil cree"),
        ("application_submitted", "Candidature envoyee"),
        ("under_review", "Etude du dossier"),
        ("interview", "Entretien"),
        ("decision", "Decision finale"),
        ("needs_defined", "Besoin defini"),
    )

    # Ce champ est retire pour utiliser l'email comme identifiant principal.
    username = None
    # Ces informations gardent le profil civil du compte.
    email = models.EmailField(unique=True)
    first_name = models.CharField(max_length=150)
    last_name = models.CharField(max_length=150)
    # Ces champs structurent le type de compte et le niveau d'acces.
    account_type = models.CharField(max_length=20, choices=ACCOUNT_TYPE_CHOICES, default="candidate")
    role = models.CharField(max_length=20, choices=ROLE_CHOICES, default="user")
    # Ces champs couvrent le profil candidat.
    phone = models.CharField(max_length=30, blank=True)
    attachment_label = models.CharField(max_length=255, blank=True)
    birth_date = models.DateField(null=True, blank=True)
    diploma = models.CharField(max_length=255, blank=True)
    graduation_year = models.CharField(max_length=20, blank=True)
    field_of_study = models.CharField(max_length=255, blank=True)
    graduation_city = models.CharField(max_length=255, blank=True)
    # Ces champs restent utiles aux comptes entreprise.
    organization_name = models.CharField(max_length=255, blank=True)
    sector = models.CharField(max_length=255, blank=True)
    company_city = models.CharField(max_length=255, blank=True)
    company_size = models.CharField(max_length=50, blank=True)
    website = models.URLField(blank=True)
    target_profiles = models.TextField(blank=True)
    # Ces champs couvrent l'objectif et le suivi du processus.
    goal = models.TextField(blank=True)
    application_stage = models.CharField(max_length=30, choices=STAGE_CHOICES, default="profile_created")
    terms_accepted = models.BooleanField(default=False)
    # Ces chemins gardent la trace des pieces jointes du candidat.
    cv_path = models.CharField(max_length=255, blank=True)
    motivation_letter_path = models.CharField(max_length=255, blank=True)

    # Ce manager applique la connexion par email dans tout le projet.
    objects = EmailUserManager()

    # Ces options remplacent totalement le username Django.
    USERNAME_FIELD = "email"
    REQUIRED_FIELDS: list[str] = []

    class Meta:
        verbose_name = "Utilisateur"
        verbose_name_plural = "Utilisateurs"
        ordering = ["-date_joined"]

    # Cette methode affiche le nom complet si disponible.
    def __str__(self) -> str:
        full_name = self.get_full_name().strip()
        return full_name or self.email

    # Cette methode simplifie les verifications d'administration.
    def is_admin(self) -> bool:
        return self.role == "admin" or self.is_superuser

    # Cette sauvegarde maintient la coherence des roles et du stage.
    def save(self, *args, **kwargs):
        self.email = self.__class__.objects.normalize_email(self.email)

        if self.email == "ayarajiallah@gmail.com":
            self.role = "admin"
            self.is_staff = True

        if self.role == "admin":
            self.is_staff = True

        if self.account_type == "company" and self.application_stage == "profile_created":
            self.application_stage = "needs_defined"

        super().save(*args, **kwargs)
