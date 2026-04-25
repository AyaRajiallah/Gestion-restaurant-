import accounts.models
import django.utils.timezone
from django.db import migrations, models


class Migration(migrations.Migration):
    initial = True

    dependencies = [
        ("auth", "0012_alter_user_first_name_max_length"),
    ]

    operations = [
        migrations.CreateModel(
            name="User",
            fields=[
                ("id", models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name="ID")),
                ("password", models.CharField(max_length=128, verbose_name="password")),
                ("last_login", models.DateTimeField(blank=True, null=True, verbose_name="last login")),
                ("is_superuser", models.BooleanField(default=False, help_text="Designates that this user has all permissions without explicitly assigning them.", verbose_name="superuser status")),
                ("date_joined", models.DateTimeField(default=django.utils.timezone.now, verbose_name="date joined")),
                ("is_staff", models.BooleanField(default=False)),
                ("is_active", models.BooleanField(default=True)),
                ("email", models.EmailField(max_length=254, unique=True)),
                ("first_name", models.CharField(max_length=150)),
                ("last_name", models.CharField(max_length=150)),
                ("account_type", models.CharField(choices=[("candidate", "Candidat"), ("company", "Entreprise")], default="candidate", max_length=20)),
                ("role", models.CharField(choices=[("user", "Utilisateur"), ("admin", "Administrateur")], default="user", max_length=20)),
                ("phone", models.CharField(blank=True, max_length=30)),
                ("attachment_label", models.CharField(blank=True, max_length=255)),
                ("birth_date", models.DateField(blank=True, null=True)),
                ("diploma", models.CharField(blank=True, max_length=255)),
                ("graduation_year", models.CharField(blank=True, max_length=20)),
                ("field_of_study", models.CharField(blank=True, max_length=255)),
                ("graduation_city", models.CharField(blank=True, max_length=255)),
                ("organization_name", models.CharField(blank=True, max_length=255)),
                ("sector", models.CharField(blank=True, max_length=255)),
                ("company_city", models.CharField(blank=True, max_length=255)),
                ("company_size", models.CharField(blank=True, max_length=50)),
                ("website", models.URLField(blank=True)),
                ("target_profiles", models.TextField(blank=True)),
                ("goal", models.TextField(blank=True)),
                ("application_stage", models.CharField(choices=[("profile_created", "Profil cree"), ("application_submitted", "Candidature envoyee"), ("under_review", "Etude du dossier"), ("interview", "Entretien"), ("decision", "Decision finale"), ("needs_defined", "Besoin defini")], default="profile_created", max_length=30)),
                ("terms_accepted", models.BooleanField(default=False)),
                ("cv_path", models.CharField(blank=True, max_length=255)),
                ("motivation_letter_path", models.CharField(blank=True, max_length=255)),
                ("groups", models.ManyToManyField(blank=True, help_text="The groups this user belongs to.", related_name="user_set", related_query_name="user", to="auth.group", verbose_name="groups")),
                ("user_permissions", models.ManyToManyField(blank=True, help_text="Specific permissions for this user.", related_name="user_set", related_query_name="user", to="auth.permission", verbose_name="user permissions")),
            ],
            options={
                "verbose_name": "Utilisateur",
                "verbose_name_plural": "Utilisateurs",
                "ordering": ["-date_joined"],
            },
            managers=[
                ("objects", accounts.models.EmailUserManager()),
            ],
        ),
    ]
