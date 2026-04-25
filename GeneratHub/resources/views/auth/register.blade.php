@extends('welcome')

@php
    $accountType = $accountType ?? request('type') ?? 'candidate';
@endphp

@section('content')
<div class="registration-shell" data-registration-type="{{ $accountType }}">
    <div class="registration-topbar">
        <a href="{{ route('home', absolute: false) }}" class="glassy-pill">Retour a l'accueil</a>
        <a href="{{ route('login', absolute: false) }}" class="glassy-pill glassy-pill--accent">Login</a>
    </div>

    <div class="registration-card">
        <section class="registration-form-panel">
            <p class="registration-kicker">{{ $accountType === 'company' ? 'acteur systeme : entreprise' : 'acteur systeme : candidat' }}</p>
            <h1>{{ $accountType === 'company' ? 'Donnez forme a votre besoin de recrutement' : 'Construisez votre candidature' }}</h1>
            <p class="registration-copy">
                Le formulaire adapte les informations selon le perimetre du projet: le candidat suit sa demande,
                l'entreprise pilote ses offres, et chaque profil est structure de facon utile.
            </p>

            @if (session('status'))
                <div class="form-alert form-alert--success">{{ session('status') }}</div>
            @endif

            @if (session('error'))
                <div class="form-alert form-alert--error">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="form-alert form-alert--error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register.store', absolute: false) }}" class="registration-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="account_type" value="{{ $accountType }}">

                <div class="profile-upload-row">
                    <div class="profile-preview-frame">
                        <img id="profilePhotoPreview" class="profile-preview-image" alt="Photo de profil">
                        <div id="profilePhotoFallback" class="profile-preview-fallback">Photo de profil</div>
                    </div>

                    <label class="profile-upload-field">
                        <span>Ajouter une photo de profil</span>
                        <input id="profilePhotoInput" type="file" name="profile_photo" accept="image/*">
                    </label>
                </div>

                <div class="field-grid">
                    <label class="underlined-field">
                        <span>Prenom*</span>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required>
                    </label>

                    <label class="underlined-field">
                        <span>Nom*</span>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required>
                    </label>

                    <label class="underlined-field">
                        <span>E-mail*</span>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </label>

                    <label class="underlined-field">
                        <span>Telephone</span>
                        <input type="text" name="phone" value="{{ old('phone') }}">
                    </label>
                </div>

                @if ($accountType === 'candidate')
                    <div class="field-grid">
                        <label class="underlined-field">
                            <span>Rattachement*</span>
                            <select name="attachment_label" required>
                                <option value="">Choisir</option>
                                <option value="Etudiant(e)" @selected(old('attachment_label') === 'Etudiant(e)')>Etudiant(e)</option>
                                <option value="Jeune diplome" @selected(old('attachment_label') === 'Jeune diplome')>Jeune diplome</option>
                                <option value="Professionnel" @selected(old('attachment_label') === 'Professionnel')>Professionnel</option>
                            </select>
                        </label>

                        <label class="underlined-field">
                            <span>Date de naissance*</span>
                            <input type="date" name="birth_date" value="{{ old('birth_date') }}" required>
                        </label>

                        <label class="underlined-field">
                            <span>Diplome*</span>
                            <select name="diploma" required>
                                <option value="">Choisir</option>
                                <option value="BAC+2" @selected(old('diploma') === 'BAC+2')>BAC+2</option>
                                <option value="BAC+3" @selected(old('diploma') === 'BAC+3')>BAC+3</option>
                                <option value="BAC+5" @selected(old('diploma') === 'BAC+5')>BAC+5</option>
                                <option value="Ingenieur" @selected(old('diploma') === 'Ingenieur')>Ingenieur</option>
                            </select>
                        </label>

                        <label class="underlined-field">
                            <span>Annee d'obtention*</span>
                            <input type="text" name="graduation_year" value="{{ old('graduation_year') }}" placeholder="2026" required>
                        </label>

                        <label class="underlined-field">
                            <span>Filiere*</span>
                            <input type="text" name="field_of_study" value="{{ old('field_of_study') }}" placeholder="Ingenierie informatique et reseaux" required>
                        </label>

                        <label class="underlined-field">
                            <span>Ville d'obtention du diplome*</span>
                            <input type="text" name="graduation_city" value="{{ old('graduation_city') }}" placeholder="Rabat" required>
                        </label>
                    </div>

                    <div class="document-grid">
                        <label class="upload-card">
                            <span>CV du candidat*</span>
                            <small>Formats acceptes: PDF, DOC, DOCX</small>
                            <input type="file" name="cv_document" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
                        </label>

                        <label class="upload-card">
                            <span>Lettre de motivation</span>
                            <small>Ajoutez un document clair et professionnel</small>
                            <input type="file" name="motivation_letter" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        </label>
                    </div>
                @endif

                @if ($accountType === 'company')
                    <div class="field-grid">
                        <label class="underlined-field">
                            <span>Nom de l'entreprise*</span>
                            <input type="text" name="organization_name" value="{{ old('organization_name') }}" required>
                        </label>

                        <label class="underlined-field">
                            <span>Secteur*</span>
                            <input type="text" name="sector" value="{{ old('sector') }}" placeholder="Technologie, RH, Finance..." required>
                        </label>

                        <label class="underlined-field">
                            <span>Ville*</span>
                            <input type="text" name="company_city" value="{{ old('company_city') }}" placeholder="Casablanca" required>
                        </label>

                        <label class="underlined-field">
                            <span>Taille de l'entreprise*</span>
                            <select name="company_size" required>
                                <option value="">Choisir</option>
                                <option value="1-10" @selected(old('company_size') === '1-10')>1-10</option>
                                <option value="11-50" @selected(old('company_size') === '11-50')>11-50</option>
                                <option value="51-200" @selected(old('company_size') === '51-200')>51-200</option>
                                <option value="200+" @selected(old('company_size') === '200+')>200+</option>
                            </select>
                        </label>

                        <label class="underlined-field">
                            <span>Site web</span>
                            <input type="url" name="website" value="{{ old('website') }}" placeholder="https://...">
                        </label>

                        <label class="underlined-field">
                            <span>Profils recherches*</span>
                            <input type="text" name="target_profiles" value="{{ old('target_profiles') }}" placeholder="Developpeur full stack, RH, data analyst..." required>
                        </label>
                    </div>
                @endif

                <label class="goal-bar">
                    <span>{{ $accountType === 'company' ? 'But de l entreprise*' : 'But du candidat*' }}</span>
                    <textarea name="goal" rows="4" required placeholder="{{ $accountType === 'company' ? 'Expliquez votre besoin, votre objectif de recrutement et les profils attendus.' : 'Expliquez votre objectif professionnel, le type de poste vise et ce que vous recherchez.' }}">{{ old('goal') }}</textarea>
                </label>

                <div class="field-grid credentials-grid">
                    <label class="underlined-field">
                        <span>Mot de passe*</span>
                        <input type="password" name="password" required>
                    </label>

                    <label class="underlined-field">
                        <span>Confirmation du mot de passe*</span>
                        <input type="password" name="password_confirmation" required>
                    </label>
                </div>

                <label class="consent-row">
                    <input type="checkbox" name="terms_accepted" value="1" @checked(old('terms_accepted')) required>
                    <span>J'accepte les conditions d'utilisation, la politique de confidentialite et les notifications email jusqu'a changement de decision.</span>
                </label>

                <button type="submit" class="submit-button">Continuer</button>
            </form>

            <div class="registration-links">
                <a href="{{ route('password.request', absolute: false) }}">Mot de passe oublie ?</a>
            </div>
        </section>

        <aside class="registration-visual-panel">
            <div class="floating-note floating-note--top">
                <strong>{{ $accountType === 'company' ? 'Entreprise' : 'Candidat' }}</strong>
                <span>{{ $accountType === 'company' ? 'Formulaire dedie aux besoins de recrutement et aux profils recherches.' : 'Formulaire dedie au parcours, a la filiere et aux objectifs du candidat.' }}</span>
            </div>

            <div class="floating-note floating-note--middle">
                <strong>Fonctionnalites</strong>
                <span>{{ $accountType === 'company' ? 'Publication d offres, gestion des candidatures recues et pilotage du recrutement.' : 'Creation du profil, ajout du CV, lettre de motivation et suivi des candidatures.' }}</span>
            </div>

            <div class="floating-pill">Place pour visuel ou photo de profil</div>
        </aside>
    </div>
</div>

<style>
    .registration-shell {
        min-height: 100vh;
        padding: 1.6rem 1.2rem 3rem;
        background:
            radial-gradient(circle at top left, rgba(197, 210, 248, 0.5), transparent 30%),
            radial-gradient(circle at bottom right, rgba(79, 12, 40, 0.1), transparent 22%),
            #f1faee;
    }

    html[data-theme='dark'] .registration-shell {
        background:
            radial-gradient(circle at top left, rgba(197, 210, 248, 0.14), transparent 26%),
            radial-gradient(circle at bottom right, rgba(79, 12, 40, 0.16), transparent 18%),
            #11141b;
    }

    .registration-topbar {
        max-width: 1260px;
        margin: 0 auto 1.25rem;
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .glassy-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.15rem;
        border: 1px solid rgba(255, 255, 255, 0.55);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.42);
        color: #4f0c28;
        text-decoration: none;
        font-weight: 700;
        box-shadow: 0 18px 38px rgba(86, 92, 116, 0.12);
        backdrop-filter: blur(18px) saturate(150%);
        -webkit-backdrop-filter: blur(18px) saturate(150%);
    }

    .glassy-pill--accent {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.5), rgba(197, 210, 248, 0.24));
    }

    .registration-card {
        max-width: 1260px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 1.4rem;
        padding: 1rem;
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.62);
        background: rgba(255, 255, 255, 0.34);
        box-shadow: 0 20px 50px rgba(77, 84, 105, 0.12);
        backdrop-filter: blur(20px) saturate(155%);
        -webkit-backdrop-filter: blur(20px) saturate(155%);
    }

    html[data-theme='dark'] .registration-card {
        background: rgba(22, 26, 34, 0.56);
        border-color: rgba(197, 210, 248, 0.16);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.26);
    }

    .registration-form-panel,
    .registration-visual-panel {
        border-radius: 1.7rem;
    }

    .registration-form-panel {
        padding: 2.2rem;
        background: rgba(255, 255, 255, 0.82);
    }

    html[data-theme='dark'] .registration-form-panel {
        background: rgba(15, 19, 26, 0.84);
        color: #edf3ef;
    }

    .registration-kicker {
        margin: 0;
        color: #5d7c66;
        font-size: 0.86rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
    }

    .registration-form-panel h1 {
        margin: 0.75rem 0 0;
        font-size: clamp(2.2rem, 4vw, 3.5rem);
        line-height: 1.05;
        color: #191d1b;
    }

    html[data-theme='dark'] .registration-form-panel h1 {
        color: #edf3ef;
    }

    .registration-copy {
        margin: 0.95rem 0 0;
        line-height: 1.8;
        color: rgba(36, 40, 38, 0.74);
    }

    html[data-theme='dark'] .registration-copy {
        color: rgba(237, 243, 239, 0.76);
    }

    .form-alert {
        margin-top: 1rem;
        padding: 0.9rem 1rem;
        border-radius: 1rem;
    }

    .form-alert--success {
        background: rgba(96, 140, 112, 0.12);
        color: #31503b;
    }

    .form-alert--error {
        background: rgba(79, 12, 40, 0.1);
        color: #4f0c28;
    }

    .registration-form {
        display: grid;
        gap: 1.4rem;
        margin-top: 1.8rem;
    }

    .profile-upload-row {
        display: grid;
        grid-template-columns: 140px 1fr;
        gap: 1.2rem;
        align-items: center;
    }

    .profile-preview-frame {
        position: relative;
        width: 140px;
        height: 140px;
        border-radius: 999px;
        overflow: hidden;
        border: 1px dashed rgba(79, 12, 40, 0.22);
        background: rgba(197, 210, 248, 0.18);
        display: grid;
        place-items: center;
    }

    .profile-preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }

    .profile-preview-fallback {
        padding: 1rem;
        text-align: center;
        color: #4f0c28;
        font-weight: 700;
        line-height: 1.5;
    }

    .profile-upload-field {
        display: grid;
        gap: 0.55rem;
    }

    .profile-upload-field span {
        color: #6b7280;
        font-size: 0.95rem;
    }

    html[data-theme='dark'] .profile-upload-field span {
        color: rgba(237, 243, 239, 0.72);
    }

    .field-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.15rem 1.8rem;
    }

    .document-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .upload-card {
        display: grid;
        gap: 0.35rem;
        padding: 1rem 1.1rem;
        border: 1px solid rgba(197, 210, 248, 0.55);
        border-radius: 1.35rem;
        background: rgba(197, 210, 248, 0.12);
    }

    html[data-theme='dark'] .upload-card {
        border-color: rgba(197, 210, 248, 0.16);
        background: rgba(197, 210, 248, 0.06);
    }

    .upload-card span {
        color: #4f0c28;
        font-weight: 700;
    }

    .upload-card small {
        color: #6b7280;
        line-height: 1.6;
    }

    html[data-theme='dark'] .upload-card span {
        color: #efc5cd;
    }

    html[data-theme='dark'] .upload-card small {
        color: rgba(237, 243, 239, 0.72);
    }

    .credentials-grid {
        margin-top: 0.2rem;
    }

    .underlined-field {
        display: grid;
        gap: 0.35rem;
    }

    .underlined-field span,
    .goal-bar span {
        color: #6b7280;
        font-size: 0.95rem;
    }

    html[data-theme='dark'] .underlined-field span,
    html[data-theme='dark'] .goal-bar span {
        color: rgba(237, 243, 239, 0.72);
    }

    .underlined-field input,
    .underlined-field select,
    .goal-bar textarea {
        border: none;
        border-bottom: 1px solid rgba(107, 114, 128, 0.35);
        background: transparent;
        padding: 0.7rem 0 0.55rem;
        font: inherit;
        color: #1f2937;
        outline: none;
    }

    html[data-theme='dark'] .underlined-field input,
    html[data-theme='dark'] .underlined-field select,
    html[data-theme='dark'] .goal-bar textarea {
        border-bottom-color: rgba(197, 210, 248, 0.22);
        color: #edf3ef;
    }

    .underlined-field input:focus,
    .underlined-field select:focus,
    .goal-bar textarea:focus {
        border-bottom-color: #4f0c28;
    }

    .goal-bar {
        display: grid;
        gap: 0.45rem;
        padding: 1rem 1.15rem;
        border: 1px solid rgba(197, 210, 248, 0.55);
        border-radius: 1.4rem;
        background: rgba(197, 210, 248, 0.12);
    }

    html[data-theme='dark'] .goal-bar {
        border-color: rgba(197, 210, 248, 0.16);
        background: rgba(197, 210, 248, 0.06);
    }

    .goal-bar textarea {
        min-height: 96px;
        resize: vertical;
        border-bottom: none;
        padding-top: 0;
    }

    .consent-row {
        display: flex;
        align-items: flex-start;
        gap: 0.9rem;
        color: rgba(36, 40, 38, 0.82);
        line-height: 1.8;
    }

    html[data-theme='dark'] .consent-row {
        color: rgba(237, 243, 239, 0.82);
    }

    .consent-row input {
        margin-top: 0.35rem;
        width: 1.15rem;
        height: 1.15rem;
    }

    .submit-button {
        justify-self: center;
        min-width: 320px;
        border: none;
        border-radius: 999px;
        background: linear-gradient(135deg, #8d8d8d, #7b7b7b);
        color: white;
        padding: 1rem 1.35rem;
        font: inherit;
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        cursor: pointer;
    }

    .registration-links {
        margin-top: 1rem;
    }

    .registration-links a {
        color: #4f0c28;
        text-decoration: none;
        font-weight: 700;
    }

    .registration-visual-panel {
        position: relative;
        min-height: 840px;
        overflow: hidden;
        background:
            linear-gradient(145deg, rgba(79, 12, 40, 0.12), rgba(197, 210, 248, 0.28)),
            linear-gradient(180deg, rgba(57, 74, 66, 0.5), rgba(80, 95, 88, 0.62));
    }

    .registration-visual-panel::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.06), transparent 35%),
            radial-gradient(circle at 68% 26%, rgba(255, 255, 255, 0.18), transparent 18%);
    }

    .floating-note,
    .floating-pill {
        position: absolute;
        z-index: 1;
        border: 1px solid rgba(255, 255, 255, 0.44);
        background: rgba(255, 255, 255, 0.38);
        box-shadow: 0 14px 30px rgba(33, 49, 38, 0.16);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    .floating-note {
        max-width: 260px;
        border-radius: 1.3rem;
        padding: 1rem 1.1rem;
        color: #243028;
    }

    .floating-note strong,
    .floating-note span {
        display: block;
    }

    .floating-note span {
        margin-top: 0.4rem;
        line-height: 1.65;
        color: rgba(36, 48, 40, 0.78);
    }

    .floating-note--top {
        top: 2.1rem;
        left: 1.8rem;
    }

    .floating-note--middle {
        right: 2rem;
        bottom: 8rem;
    }

    .floating-pill {
        left: 50%;
        bottom: 2rem;
        transform: translateX(-50%);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.9);
        padding: 0.85rem 1.2rem;
        font-weight: 700;
    }

    @media (max-width: 1100px) {
        .registration-card {
            grid-template-columns: 1fr;
        }

        .registration-visual-panel {
            min-height: 380px;
        }
    }

    @media (max-width: 768px) {
        .field-grid,
        .profile-upload-row,
        .document-grid {
            grid-template-columns: 1fr;
        }

        .profile-preview-frame {
            margin: 0 auto;
        }

        .submit-button {
            min-width: 100%;
        }
    }
</style>

<script>
    const profilePhotoInput = document.getElementById('profilePhotoInput');
    const profilePhotoPreview = document.getElementById('profilePhotoPreview');
    const profilePhotoFallback = document.getElementById('profilePhotoFallback');

    if (profilePhotoInput) {
        profilePhotoInput.addEventListener('change', function (event) {
            const file = event.target.files[0];

            if (!file) {
                profilePhotoPreview.style.display = 'none';
                profilePhotoPreview.src = '';
                profilePhotoFallback.style.display = 'grid';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                profilePhotoPreview.src = e.target.result;
                profilePhotoPreview.style.display = 'block';
                profilePhotoFallback.style.display = 'none';
            };

            reader.readAsDataURL(file);
        });
    }
</script>
@endsection