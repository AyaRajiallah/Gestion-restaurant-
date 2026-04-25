"""Routes principales du projet Django."""

from django.contrib import admin
from django.urls import include, path


# Cette table relie l'admin Django et les routes metier du site.
urlpatterns = [
    path("admin/", admin.site.urls),
    path("", include("accounts.urls")),
]
