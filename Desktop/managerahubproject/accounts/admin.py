"""Configuration de l'administration Django pour les comptes."""

from django.contrib import admin
from django.contrib.auth.admin import UserAdmin as DjangoUserAdmin

from .forms import UserAdminChangeForm, UserAdminCreationForm
from .models import User


@admin.register(User)
class UserAdmin(DjangoUserAdmin):
    """Vue admin qui permet a l'administrateur de creer aussi les entreprises."""

    add_form = UserAdminCreationForm
    form = UserAdminChangeForm
    model = User
    ordering = ("-date_joined",)
    list_display = ("email", "first_name", "last_name", "account_type", "role", "application_stage", "is_staff")
    list_filter = ("account_type", "role", "application_stage", "is_staff", "is_superuser", "is_active")
    search_fields = ("email", "first_name", "last_name", "organization_name")

    # Cette vue de creation regroupe les champs essentiels.
    add_fieldsets = (
        (
            "Creation du compte",
            {
                "classes": ("wide",),
                "fields": (
                    "email",
                    "first_name",
                    "last_name",
                    "password1",
                    "password2",
                    "account_type",
                    "role",
                ),
            },
        ),
        (
            "Informations metier",
            {
                "classes": ("wide",),
                "fields": (
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
                ),
            },
        ),
    )

    # Cette vue de modification expose les champs selon les besoins admin.
    fieldsets = (
        (
            "Identification",
            {"fields": ("email", "first_name", "last_name", "password")},
        ),
        (
            "Role et acces",
            {"fields": ("account_type", "role", "is_active", "is_staff", "is_superuser", "groups", "user_permissions")},
        ),
        (
            "Profil candidat",
            {
                "fields": (
                    "phone",
                    "attachment_label",
                    "birth_date",
                    "diploma",
                    "graduation_year",
                    "field_of_study",
                    "graduation_city",
                    "cv_path",
                    "motivation_letter_path",
                )
            },
        ),
        (
            "Profil entreprise",
            {
                "fields": (
                    "organization_name",
                    "sector",
                    "company_city",
                    "company_size",
                    "website",
                    "target_profiles",
                )
            },
        ),
        (
            "Suivi",
            {"fields": ("goal", "application_stage", "terms_accepted", "last_login", "date_joined")},
        ),
    )
