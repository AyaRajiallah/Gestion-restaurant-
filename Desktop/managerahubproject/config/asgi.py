"""Point d'entree ASGI pour le projet."""

import os

from django.core.asgi import get_asgi_application


# Cette variable indique quel module de settings doit etre charge.
os.environ.setdefault("DJANGO_SETTINGS_MODULE", "config.settings")

# Cette application expose le projet aux serveurs ASGI.
application = get_asgi_application()
