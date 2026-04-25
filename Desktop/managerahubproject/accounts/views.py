"""Vues Django pour l'accueil, l'authentification et le portail."""

from django.contrib import messages
from django.contrib.auth import login
from django.contrib.auth.decorators import login_required
from django.contrib.auth.views import LoginView, LogoutView, PasswordResetConfirmView, PasswordResetView
from django.db.models import Count
from django.shortcuts import redirect, render
from django.urls import reverse_lazy

from .forms import CandidateProfileForm, CandidateSignupForm, EmailAuthenticationForm
from .models import User


# Cette constante decrit la timeline visible par le candidat dans son espace.
CANDIDATE_TIMELINE = [
    ("profile_created", "Profil cree", "Vos informations sont enregistrees et votre compte est actif."),
    ("application_submitted", "Candidature envoyee", "Votre dossier est transmis vers les entreprises ciblees."),
    ("under_review", "Etude du dossier", "Le recruteur analyse votre profil et vos competences."),
    ("interview", "Entretien", "Vous etes invite a echanger avec l'entreprise."),
    ("decision", "Decision finale", "Vous recevez la reponse finale et les prochaines etapes."),
]


# Cette vue affiche la page d'accueil du site.
def home(request):
    return render(request, "home.html")


# Cette vue gere l'inscription publique, reservee aux candidats.
def signup(request):
    if request.user.is_authenticated:
        return redirect("auth_portal")

    if request.method == "POST":
        form = CandidateSignupForm(request.POST, request.FILES)
        if form.is_valid():
            user = form.save()
            login(request, user)
            messages.success(request, "Votre compte candidat a ete cree avec succes.")
            return redirect("auth_portal")
    else:
        form = CandidateSignupForm()

    return render(request, "auth/signup.html", {"form": form})


# Cette vue permet au candidat de completer et modifier ses informations non essentielles apres login.
@login_required
def profile_edit(request):
    user = request.user

    if user.account_type != "candidate":
        messages.error(request, "Cette page de profil detaille est reservee aux candidats.")
        return redirect("auth_portal")

    if request.method == "POST":
        form = CandidateProfileForm(request.POST, request.FILES, instance=user)
        if form.is_valid():
            form.save()
            messages.success(request, "Votre profil a ete mis a jour avec succes.")
            return redirect("auth_portal")
    else:
        form = CandidateProfileForm(instance=user)

    return render(request, "auth/profile_edit.html", {"form": form, "user_obj": user})


class EmailLoginView(LoginView):
    """Vue de connexion centralisee pour candidats, entreprises et admins."""

    template_name = "auth/login.html"
    authentication_form = EmailAuthenticationForm
    redirect_authenticated_user = True

    # Cette methode garde la session selon le choix remember me.
    def form_valid(self, form):
        response = super().form_valid(form)
        if not self.request.POST.get("remember_me"):
            self.request.session.set_expiry(0)
        return response


class UserLogoutView(LogoutView):
    """Vue de deconnexion simple avec redirection vers l'accueil."""

    next_page = reverse_lazy("home")


class ForgotPasswordView(PasswordResetView):
    """Vue d'envoi du lien de reinitialisation par email."""

    template_name = "auth/forgot_password.html"
    email_template_name = "auth/password_reset_email.txt"
    subject_template_name = "auth/password_reset_subject.txt"
    success_url = reverse_lazy("password_reset_done")

    # Cette methode ajoute un message clair apres l'envoi du lien.
    def form_valid(self, form):
        messages.success(self.request, "Si cette adresse existe, un lien de reinitialisation a ete envoye.")
        return super().form_valid(form)


class ResetPasswordView(PasswordResetConfirmView):
    """Vue de choix du nouveau mot de passe apres reception du lien."""

    template_name = "auth/reset_password.html"
    success_url = reverse_lazy("login")

    # Cette methode confirme la reinitialisation du mot de passe.
    def form_valid(self, form):
        messages.success(self.request, "Votre mot de passe a ete reinitialise. Vous pouvez maintenant vous connecter.")
        return super().form_valid(form)


# Cette vue construit le tableau de bord selon le type de compte connecte.
@login_required
def portal(request):
    user = request.user
    context = {"user_obj": user}

    if user.is_admin():
        counts = User.objects.aggregate(total_users=Count("id"))
        context["admin_stats"] = {
            "total_users": counts["total_users"],
            "candidates": User.objects.filter(account_type="candidate").count(),
            "companies": User.objects.filter(account_type="company").count(),
            "admins": User.objects.filter(role="admin").count(),
        }
        context["recent_users"] = User.objects.order_by("-date_joined")[:6]
    elif user.account_type == "candidate":
        timeline_keys = [item[0] for item in CANDIDATE_TIMELINE]
        try:
            current_index = timeline_keys.index(user.application_stage)
        except ValueError:
            current_index = 0

        timeline = []
        for index, (key, label, description) in enumerate(CANDIDATE_TIMELINE):
            if index < current_index:
                state = "done"
            elif index == current_index:
                state = "active"
            else:
                state = "todo"
            timeline.append({"key": key, "label": label, "description": description, "state": state})

        context["timeline"] = timeline

    return render(request, "auth/portal.html", context)
