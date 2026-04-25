from django.apps import AppConfig


class AccountsConfig(AppConfig):
    # Cette cle identifie l'application dans Django.
    default_auto_field = "django.db.models.BigAutoField"
    # Ce nom relie la configuration au package Python.
    name = "accounts"
    # Ce libelle ameliore l'affichage dans l'admin.
    verbose_name = "Gestion des comptes"
