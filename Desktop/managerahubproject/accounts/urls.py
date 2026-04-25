"""Routes metier du projet ManageraHub."""

from django.contrib.auth.views import PasswordResetDoneView
from django.urls import path

from .views import (
    EmailLoginView,
    ForgotPasswordView,
    ResetPasswordView,
    UserLogoutView,
    home,
    portal,
    profile_edit,
    signup,
)


# Ces routes remplacent les anciennes routes du projet de reference.
urlpatterns = [
    path("", home, name="home"),
    path("signup/", signup, name="signup"),
    path("login/", EmailLoginView.as_view(), name="login"),
    path("logout/", UserLogoutView.as_view(), name="logout"),
    path("portal/", portal, name="auth_portal"),
    path("profile/", profile_edit, name="profile_edit"),
    path("forgot-password/", ForgotPasswordView.as_view(), name="password_request"),
    path(
        "forgot-password/done/",
        PasswordResetDoneView.as_view(template_name="auth/password_reset_done.html"),
        name="password_reset_done",
    ),
    path("reset-password/<uidb64>/<token>/", ResetPasswordView.as_view(), name="password_reset_confirm"),
]
