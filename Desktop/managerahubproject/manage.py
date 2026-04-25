#!/usr/bin/env python
"""Point d'entree principal pour les commandes Django."""

import os
import sys


def main() -> None:
    """Charge les reglages Django puis execute la commande demandee."""
    os.environ.setdefault("DJANGO_SETTINGS_MODULE", "config.settings")
    from django.core.management import execute_from_command_line

    execute_from_command_line(sys.argv)


if __name__ == "__main__":
    main()
