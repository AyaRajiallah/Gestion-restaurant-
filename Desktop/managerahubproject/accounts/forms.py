"""Formulaires Django pour l'inscription, le profil et l'administration."""

from django import forms
from django.contrib.auth.forms import AuthenticationForm, UserChangeForm, UserCreationForm

from .models import User


class CandidateSignupForm(UserCreationForm):
    """Formulaire public reserve aux candidats."""

    birth_date = forms.DateField(widget=forms.DateInput(attrs={"type": "date"}))
    terms_accepted = forms.BooleanField()

    class Meta(UserCreationForm.Meta):
        model = User
        fields = (
            "first_name",
            "last_name",
            "email",
            "phone",
            "birth_date",
        )

    # Cette initialisation harmonise classes CSS et placeholders.
    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        placeholders = {
            "first_name": "Votre prenom",
            "last_name": "Votre nom",
            "email": "adresse@email.com",
            "phone": "Telephone",
            "password1": "Mot de passe",
            "password2": "Confirmation du mot de passe",
        }

        for name, field in self.fields.items():
            field.widget.attrs.setdefault("class", "form-input")
            if name in placeholders:
                field.widget.attrs.setdefault("placeholder", placeholders[name])

    # Cette sauvegarde cree un compte candidat avec les seules donnees essentielles.
    def save(self, commit: bool = True):
        user = super().save(commit=False)
        user.account_type = "candidate"
        user.role = "user"
        user.terms_accepted = self.cleaned_data["terms_accepted"]
        user.application_stage = "profile_created"

        if commit:
            user.save()
        return user


class CandidateProfileForm(forms.ModelForm):
    """Formulaire post-login pour completer ou modifier les informations non essentielles."""

    attachment_label = forms.ChoiceField(
        choices=(
            ("", "Choisir"),
            ("Etudiant(e)", "Etudiant(e)"),
            ("Jeune diplome", "Jeune diplome"),
            ("Professionnel", "Professionnel"),
        ),
        required=False,
    )
    diploma = forms.ChoiceField(
        choices=(
            ("", "Choisir"),
            ("BAC+2", "BAC+2"),
            ("BAC+3", "BAC+3"),
            ("BAC+5", "BAC+5"),
            ("Ingenieur", "Ingenieur"),
        ),
        required=False,
    )
    birth_date = forms.DateField(required=False, widget=forms.DateInput(attrs={"type": "date"}))
    cv_document = forms.FileField(required=False)
    motivation_letter = forms.FileField(required=False)

    class Meta:
        model = User
        fields = (
            "phone",
            "attachment_label",
            "birth_date",
            "diploma",
            "graduation_year",
            "field_of_study",
            "graduation_city",
            "goal",
        )

    # Cette initialisation garde un style uniforme sur la page de profil.
    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        placeholders = {
            "phone": "Telephone",
            "graduation_year": "2026",
            "field_of_study": "Ingenierie informatique et reseaux",
            "graduation_city": "Rabat",
            "goal": "Expliquez votre objectif professionnel et le poste vise.",
        }

        for name, field in self.fields.items():
            field.widget.attrs.setdefault("class", "form-input")
            if name in placeholders:
                field.widget.attrs.setdefault("placeholder", placeholders[name])

        self.fields["goal"].widget = forms.Textarea(
            attrs={"class": "form-textarea", "rows": 4, "placeholder": placeholders["goal"]}
        )

    # Cette methode conserve les noms de documents choisis par le candidat.
    def save(self, commit: bool = True):
        user = super().save(commit=False)

        cv_document = self.cleaned_data.get("cv_document")
        motivation_letter = self.cleaned_data.get("motivation_letter")

        if cv_document:
            user.cv_path = cv_document.name

        if motivation_letter:
            user.motivation_letter_path = motivation_letter.name

        if commit:
            user.save()
        return user


class EmailAuthenticationForm(AuthenticationForm):
    """Formulaire de connexion simplifie autour de l'email."""

    username = forms.EmailField(label="E-mail", widget=forms.EmailInput(attrs={"class": "form-input"}))
    password = forms.CharField(
        label="Mot de passe",
        strip=False,
        widget=forms.PasswordInput(attrs={"class": "form-input"}),
    )


class UserAdminCreationForm(UserCreationForm):
    """Formulaire admin pour creer des candidats, entreprises ou admins."""

    class Meta(UserCreationForm.Meta):
        model = User
        fields = (
            "email",
            "first_name",
            "last_name",
            "account_type",
            "role",
            "phone",
            "organization_name",
            "sector",
            "company_city",
            "company_size",
            "website",
            "target_profiles",
            "goal",
            "application_stage",
            "terms_accepted",
        )


class UserAdminChangeForm(UserChangeForm):
    """Formulaire admin pour modifier tous les champs metier utiles."""

    class Meta:
        model = User
        fields = (
            "email",
            "first_name",
            "last_name",
            "account_type",
            "role",
            "phone",
            "attachment_label",
            "birth_date",
            "diploma",
            "graduation_year",
            "field_of_study",
            "graduation_city",
            "organization_name",
            "sector",
            "company_city",
            "company_size",
            "website",
            "target_profiles",
            "goal",
            "application_stage",
            "terms_accepted",
            "cv_path",
            "motivation_letter_path",
            "is_active",
            "is_staff",
            "is_superuser",
        )
