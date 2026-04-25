"""Reglages Django pour la reconstruction du site ManageraHub."""

from pathlib import Path


# Cette base sert a construire tous les chemins du projet.
BASE_DIR = Path(__file__).resolve().parent.parent

# Cette cle convient au developpement local.
SECRET_KEY = "django-insecure-managerahubproject-local-key"

# Ces options gardent un mode local simple pour le projet.
DEBUG = True
ALLOWED_HOSTS = ["127.0.0.1", "localhost", "testserver"]

# Ces applications couvrent Django et la logique metier du site.
INSTALLED_APPS = [
    "django.contrib.admin",
    "django.contrib.auth",
    "django.contrib.contenttypes",
    "django.contrib.sessions",
    "django.contrib.messages",
    "django.contrib.staticfiles",
    "accounts",
]

# Ces middlewares gerent securite, sessions et messages.
MIDDLEWARE = [
    "django.middleware.security.SecurityMiddleware",
    "django.contrib.sessions.middleware.SessionMiddleware",
    "django.middleware.common.CommonMiddleware",
    "django.middleware.csrf.CsrfViewMiddleware",
    "django.contrib.auth.middleware.AuthenticationMiddleware",
    "django.contrib.messages.middleware.MessageMiddleware",
    "django.middleware.clickjacking.XFrameOptionsMiddleware",
]

# Cette racine charge la table de routage globale du projet.
ROOT_URLCONF = "config.urls"

# Cette configuration active les templates partages du projet.
TEMPLATES = [
    {
        "BACKEND": "django.template.backends.django.DjangoTemplates",
        "DIRS": [BASE_DIR / "templates"],
        "APP_DIRS": True,
        "OPTIONS": {
            "context_processors": [
                "django.template.context_processors.request",
                "django.contrib.auth.context_processors.auth",
                "django.contrib.messages.context_processors.messages",
            ],
        },
    }
]

# Cette passerelle expose l'application aux serveurs WSGI.
WSGI_APPLICATION = "config.wsgi.application"

# Cette base SQLite permet de lancer rapidement le projet.
DATABASES = {
    "default": {
        "ENGINE": "django.db.backends.sqlite3",
        "NAME": BASE_DIR / "db.sqlite3",
    }
}

# Ces regles protegent les mots de passe utilisateurs.
AUTH_PASSWORD_VALIDATORS = [
    {"NAME": "django.contrib.auth.password_validation.UserAttributeSimilarityValidator"},
    {"NAME": "django.contrib.auth.password_validation.MinimumLengthValidator"},
    {"NAME": "django.contrib.auth.password_validation.CommonPasswordValidator"},
    {"NAME": "django.contrib.auth.password_validation.NumericPasswordValidator"},
]

# Cette localisation garde le projet en francais.
LANGUAGE_CODE = "fr"
TIME_ZONE = "Europe/Paris"
USE_I18N = True
USE_TZ = True

# Ces chemins servent les fichiers statiques du front.
STATIC_URL = "static/"
STATICFILES_DIRS = [BASE_DIR / "static"]

# Ce modele remplace l'utilisateur par notre version metier.
AUTH_USER_MODEL = "accounts.User"

# Ces redirections simplifient les flux d'authentification.
LOGIN_URL = "login"
LOGIN_REDIRECT_URL = "auth_portal"
LOGOUT_REDIRECT_URL = "home"

# Ce backend affiche les emails de reset en console pendant le developpement.
EMAIL_BACKEND = "django.core.mail.backends.console.EmailBackend"
DEFAULT_FROM_EMAIL = "hello@managerahub.local"

# Cette cle primaire reste sur la convention recente de Django.
DEFAULT_AUTO_FIELD = "django.db.models.BigAutoField"
