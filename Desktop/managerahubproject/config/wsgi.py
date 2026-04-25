"""Point d'entree WSGI pour le projet."""

import os

from django.core.wsgi import get_wsgi_application


# Cette variable indique quel module de settings doit etre charge.
os.environ.setdefault("DJANGO_SETTINGS_MODULE", "config.settings")

# Cette application expose le projet aux serveurs WSGI.
application = get_wsgi_application()
