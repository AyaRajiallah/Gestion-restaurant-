@extends('welcome')

@section('content')
@php
    $timelineOrder = array_keys($timeline);
    $currentIndex = array_search($user->application_stage, $timelineOrder, true);
    $currentIndex = $currentIndex === false ? 0 : $currentIndex;
    $isAdmin = $user->isAdmin();
    $photoUrl = $user->profile_photo_path ? route('users.photo', $user, false) : null;
@endphp

<div class="portal-shell">
    <div class="portal-topbar">
        <a href="{{ route('home', absolute: false) }}" class="portal-pill">Retour a l'accueil</a>

        <form method="POST" action="{{ route('logout', absolute: false) }}">
            @csrf
            <button type="submit" class="portal-pill portal-pill--accent">Se deconnecter</button>
        </form>
    </div>

    <div class="portal-grid">
        <section class="portal-main-card">
            <div class="portal-header">
                <div class="portal-avatar">
                    @if ($photoUrl)
                        <img src="{{ $photoUrl }}" alt="Photo de profil">
                    @else
                        <span>{{ strtoupper(substr($user->first_name ?? $user->name, 0, 1)) }}</span>
                    @endif
                </div>

                <div class="portal-intro">
                    <p class="portal-kicker">
                        @if ($isAdmin)
                            espace administrateur
                        @elseif ($user->account_type === 'company')
                            espace entreprise
                        @else
                            espace candidat
                        @endif
                    </p>
                    <h1>{{ $user->name }}</h1>
                    <p class="portal-summary">
                        @if ($isAdmin)
                            Vous supervisez la plateforme, les utilisateurs et la qualite du parcours de recrutement.
                        @elseif ($user->account_type === 'company')
                            Vous pilotez vos besoins, vos profils recherches et l'avancement du recrutement.
                        @else
                            Vous suivez votre demande, votre objectif professionnel et votre progression dans la timeline.
                        @endif
                    </p>
                </div>
            </div>

            @if (session('status'))
                <div class="portal-status">{{ session('status') }}</div>
            @endif

            @if ($isAdmin)
                <div class="admin-stats-grid">
                    <article class="stat-card">
                        <p>Total utilisateurs</p>
                        <strong>{{ $adminStats['total_users'] }}</strong>
                    </article>
                    <article class="stat-card">
                        <p>Candidats</p>
                        <strong>{{ $adminStats['candidates'] }}</strong>
                    </article>
                    <article class="stat-card">
                        <p>Entreprises</p>
                        <strong>{{ $adminStats['companies'] }}</strong>
                    </article>
                    <article class="stat-card">
                        <p>Admins</p>
                        <strong>{{ $adminStats['admins'] }}</strong>
                    </article>
                </div>

                <div class="profile-grid">
                    <article class="profile-block">
                        <h3>Fonctionnalites administrateur</h3>
                        <ul class="feature-list">
                            <li>Superviser les comptes candidats, entreprises et administrateurs</li>
                            <li>Controler les offres publiees et l'activite generale de la plateforme</li>
                            <li>Verifier la coherence des profils, candidatures et contenus metiers</li>
                            <li>Assurer la securite et la maintenance du systeme</li>
                        </ul>
                    </article>

                    <article class="profile-block">
                        <h3>Actions principales</h3>
                        <ul class="feature-list">
                            <li>Consulter les derniers comptes crees</li>
                            <li>Observer la repartition des acteurs du systeme</li>
                            <li>Controler l'avancement general du parcours utilisateur</li>
                            <li>Superviser les offres, candidatures et besoins publies</li>
                        </ul>
                    </article>
                </div>

                <article class="recent-users-card">
                    <div class="section-head">
                        <p class="section-kicker">Derniers comptes</p>
                        <h2>Vue rapide des utilisateurs recents</h2>
                    </div>

                    <div class="recent-users-list">
                        @foreach ($recentUsers as $recentUser)
                            <div class="recent-user-row">
                                <div>
                                    <strong>{{ $recentUser->name }}</strong>
                                    <p>{{ $recentUser->email }}</p>
                                </div>
                                <span>{{ $recentUser->role === 'admin' ? 'Admin' : ucfirst($recentUser->account_type) }}</span>
                            </div>
                        @endforeach
                    </div>
                </article>
            @elseif ($user->account_type === 'candidate')
                <div class="profile-grid">
                    <article class="profile-block">
                        <h3>Profil candidat</h3>
                        <dl>
                            <div><dt>Prenom</dt><dd>{{ $user->first_name }}</dd></div>
                            <div><dt>Nom</dt><dd>{{ $user->last_name }}</dd></div>
                            <div><dt>Email</dt><dd>{{ $user->email }}</dd></div>
                            <div><dt>Telephone</dt><dd>{{ $user->phone ?: 'Non renseigne' }}</dd></div>
                            <div><dt>Rattachement</dt><dd>{{ $user->attachment_label ?: 'Non renseigne' }}</dd></div>
                            <div><dt>But</dt><dd>{{ $user->goal }}</dd></div>
                        </dl>
                    </article>

                    <article class="profile-block">
                        <h3>Parcours academique</h3>
                        <dl>
                            <div><dt>Diplome</dt><dd>{{ $user->diploma ?: 'Non renseigne' }}</dd></div>
                            <div><dt>Annee</dt><dd>{{ $user->graduation_year ?: 'Non renseignee' }}</dd></div>
                            <div><dt>Filiere</dt><dd>{{ $user->field_of_study ?: 'Non renseignee' }}</dd></div>
                            <div><dt>Ville</dt><dd>{{ $user->graduation_city ?: 'Non renseignee' }}</dd></div>
                        </dl>
                    </article>

                    <article class="profile-block">
                        <h3>Documents de candidature</h3>
                        <dl>
                            <div><dt>CV</dt><dd>{{ $user->cv_path ? 'Ajoute au profil' : 'Non ajoute' }}</dd></div>
                            <div><dt>Lettre de motivation</dt><dd>{{ $user->motivation_letter_path ? 'Ajoutee au profil' : 'Non ajoutee' }}</dd></div>
                            <div><dt>Historique</dt><dd>Le suivi vertical vous aide a visualiser chaque etape de la candidature.</dd></div>
                        </dl>
                    </article>
                </div>

                <article class="timeline-card">
                    <div class="section-head">
                        <p class="section-kicker">Suivi de demande</p>
                        <h2>Timeline verticale de votre candidature</h2>
                    </div>

                    <div class="timeline">
                        @foreach ($timeline as $key => $step)
                            @php
                                $stepIndex = array_search($key, $timelineOrder, true);
                                $state = $stepIndex < $currentIndex ? 'done' : ($stepIndex === $currentIndex ? 'active' : 'todo');
                            @endphp
                            <div class="timeline-item timeline-item--{{ $state }}">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h3>{{ $step['label'] }}</h3>
                                    <p>{{ $step['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>
            @else
                <div class="profile-grid">
                    <article class="profile-block">
                        <h3>Fiche entreprise</h3>
                        <dl>
                            <div><dt>Contact</dt><dd>{{ $user->name }}</dd></div>
                            <div><dt>Entreprise</dt><dd>{{ $user->organization_name ?: 'Non renseignee' }}</dd></div>
                            <div><dt>Secteur</dt><dd>{{ $user->sector ?: 'Non renseigne' }}</dd></div>
                            <div><dt>Ville</dt><dd>{{ $user->company_city ?: 'Non renseignee' }}</dd></div>
                            <div><dt>Taille</dt><dd>{{ $user->company_size ?: 'Non renseignee' }}</dd></div>
                            <div><dt>Site web</dt><dd>{{ $user->website ?: 'Non renseigne' }}</dd></div>
                        </dl>
                    </article>

                    <article class="profile-block">
                        <h3>Fonctionnalites entreprise</h3>
                        <ul class="feature-list">
                            <li>Publier, modifier ou supprimer des offres d'emploi</li>
                            <li>Consulter les candidatures recues et examiner les profils</li>
                            <li>Accepter, refuser ou convoquer un candidat a un entretien</li>
                            <li>Centraliser le besoin, les profils cibles et le suivi du recrutement</li>
                        </ul>
                    </article>
                </div>

                <article class="recent-users-card">
                    <div class="section-head">
                        <p class="section-kicker">Besoin de recrutement</p>
                        <h2>Objectif et profils recherches</h2>
                    </div>

                    <div class="company-needs-grid">
                        <div class="need-card">
                            <h3>But de l'entreprise</h3>
                            <p>{{ $user->goal }}</p>
                        </div>
                        <div class="need-card">
                            <h3>Profils recherches</h3>
                            <p>{{ $user->target_profiles ?: 'Aucun profil specifie.' }}</p>
                        </div>
                    </div>
                </article>
            @endif
        </section>

        <aside class="portal-side-card">
            <p class="portal-side-kicker">Actions clefs</p>
            <h2>
                @if ($isAdmin)
                    Pilotage plateforme
                @elseif ($user->account_type === 'company')
                    Pilotage entreprise
                @else
                    Espace candidat
                @endif
            </h2>
            <div class="side-stack">
                <div class="side-chip">Photo de profil disponible</div>
                <div class="side-chip">Theme clair / sombre actif</div>
                <div class="side-chip">Recuperation mot de passe par email</div>
                <div class="side-chip">
                    @if ($isAdmin)
                        Gestion des comptes, des offres et de la securite
                    @elseif ($user->account_type === 'company')
                        Publication d'offres et gestion des candidatures
                    @else
                        Recherche d'offres, pieces jointes et suivi visuel
                    @endif
                </div>
            </div>
        </aside>
    </div>
</div>

<style>
    .portal-shell {
        min-height: 100vh;
        padding: 1.5rem;
        background:
            radial-gradient(circle at top left, rgba(197, 210, 248, 0.42), transparent 28%),
            radial-gradient(circle at bottom right, rgba(79, 12, 40, 0.08), transparent 18%),
            #f1faee;
    }

    html[data-theme='dark'] .portal-shell {
        background:
            radial-gradient(circle at top left, rgba(197, 210, 248, 0.12), transparent 24%),
            radial-gradient(circle at bottom right, rgba(79, 12, 40, 0.12), transparent 16%),
            #11141b;
    }

    .portal-topbar {
        max-width: 1240px;
        margin: 0 auto 1.3rem;
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .portal-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.78rem 1.15rem;
        border: 1px solid rgba(255, 255, 255, 0.55);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.44);
        color: #4f0c28;
        text-decoration: none;
        font: inherit;
        font-weight: 700;
        box-shadow: 0 16px 35px rgba(86, 92, 116, 0.12);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        cursor: pointer;
    }

    .portal-pill--accent {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.5), rgba(197, 210, 248, 0.24));
    }

    .portal-grid {
        max-width: 1240px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.18fr 0.52fr;
        gap: 1.4rem;
    }

    .portal-main-card,
    .portal-side-card {
        border: 1px solid rgba(255, 255, 255, 0.55);
        border-radius: 2rem;
        background: rgba(255, 255, 255, 0.58);
        padding: 2rem;
        box-shadow: 0 20px 45px rgba(86, 92, 116, 0.12);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    html[data-theme='dark'] .portal-main-card,
    html[data-theme='dark'] .portal-side-card {
        background: rgba(23, 27, 35, 0.72);
        border-color: rgba(197, 210, 248, 0.16);
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.24);
        color: #edf3ef;
    }

    .portal-header {
        display: grid;
        grid-template-columns: 120px 1fr;
        gap: 1.2rem;
        align-items: center;
    }

    .portal-avatar {
        width: 120px;
        height: 120px;
        border-radius: 999px;
        overflow: hidden;
        display: grid;
        place-items: center;
        background: rgba(197, 210, 248, 0.34);
        color: #4f0c28;
        font-size: 2rem;
        font-weight: 800;
        border: 1px solid rgba(197, 210, 248, 0.5);
    }

    .portal-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .portal-kicker,
    .portal-side-kicker,
    .section-kicker {
        margin: 0;
        color: #4f0c28;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.16em;
        font-size: 0.8rem;
    }

    .portal-intro h1,
    .portal-side-card h2,
    .section-head h2,
    .stat-card strong {
        color: #4f0c28;
    }

    html[data-theme='dark'] .portal-intro h1,
    html[data-theme='dark'] .portal-side-card h2,
    html[data-theme='dark'] .section-head h2,
    html[data-theme='dark'] .profile-block h3,
    html[data-theme='dark'] .timeline-content h3,
    html[data-theme='dark'] .need-card h3 {
        color: #efc5cd;
    }

    .portal-summary,
    .profile-block p,
    .timeline-content p,
    .need-card p {
        color: rgba(36, 40, 38, 0.8);
        line-height: 1.8;
    }

    html[data-theme='dark'] .portal-summary,
    html[data-theme='dark'] .profile-block p,
    html[data-theme='dark'] .timeline-content p,
    html[data-theme='dark'] .profile-block dd,
    html[data-theme='dark'] .feature-list li,
    html[data-theme='dark'] .recent-user-row p,
    html[data-theme='dark'] .need-card p {
        color: rgba(237, 243, 239, 0.8);
    }

    .portal-status {
        margin-top: 1rem;
        border-radius: 1rem;
        padding: 0.85rem 1rem;
        background: rgba(96, 140, 112, 0.12);
        color: #31503b;
    }

    .admin-stats-grid,
    .profile-grid,
    .company-needs-grid {
        display: grid;
        gap: 1rem;
        margin-top: 1.4rem;
    }

    .admin-stats-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    .profile-grid,
    .company-needs-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .stat-card,
    .profile-block,
    .timeline-card,
    .recent-users-card,
    .need-card {
        border: 1px solid rgba(197, 210, 248, 0.48);
        border-radius: 1.6rem;
        background: rgba(255, 255, 255, 0.54);
        padding: 1.4rem;
    }

    html[data-theme='dark'] .stat-card,
    html[data-theme='dark'] .profile-block,
    html[data-theme='dark'] .timeline-card,
    html[data-theme='dark'] .recent-users-card,
    html[data-theme='dark'] .need-card {
        background: rgba(15, 19, 26, 0.66);
        border-color: rgba(197, 210, 248, 0.14);
    }

    .stat-card p {
        margin: 0;
        color: #6b7280;
    }

    .stat-card strong {
        display: block;
        margin-top: 0.4rem;
        font-size: 2rem;
    }

    .profile-block dl {
        margin: 0;
        display: grid;
        gap: 0.85rem;
    }

    .profile-block dl div {
        display: grid;
        gap: 0.2rem;
    }

    .profile-block dt {
        color: rgba(107, 114, 128, 0.9);
        font-size: 0.92rem;
    }

    html[data-theme='dark'] .profile-block dt {
        color: rgba(237, 243, 239, 0.58);
    }

    .profile-block dd {
        margin: 0;
        color: #242826;
        line-height: 1.6;
    }

    .feature-list {
        margin: 0;
        padding-left: 1.1rem;
        line-height: 1.8;
    }

    .section-head {
        margin-bottom: 1rem;
    }

    .timeline {
        position: relative;
        margin-top: 1.4rem;
        display: grid;
        gap: 1.15rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0.2rem;
        bottom: 0.2rem;
        left: 0.7rem;
        width: 2px;
        background: rgba(197, 210, 248, 0.9);
    }

    .timeline-item {
        position: relative;
        display: grid;
        grid-template-columns: 1.8rem 1fr;
        gap: 1rem;
    }

    .timeline-marker {
        position: relative;
        width: 1.4rem;
        height: 1.4rem;
        margin-top: 0.15rem;
        border-radius: 999px;
        border: 2px solid rgba(79, 12, 40, 0.24);
        background: #fff;
        z-index: 1;
    }

    .timeline-item--done .timeline-marker,
    .timeline-item--active .timeline-marker {
        background: #4f0c28;
        border-color: #4f0c28;
        box-shadow: 0 0 0 6px rgba(79, 12, 40, 0.08);
    }

    .timeline-item--todo .timeline-content {
        opacity: 0.7;
    }

    .recent-users-list {
        display: grid;
        gap: 0.85rem;
    }

    .recent-user-row {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        align-items: center;
        padding: 0.95rem 1rem;
        border-radius: 1.1rem;
        background: rgba(197, 210, 248, 0.14);
    }

    .recent-user-row p {
        margin: 0.2rem 0 0;
        color: rgba(36, 40, 38, 0.72);
    }

    .recent-user-row span {
        padding: 0.45rem 0.7rem;
        border-radius: 999px;
        background: rgba(79, 12, 40, 0.08);
        color: #4f0c28;
        font-size: 0.86rem;
        font-weight: 700;
    }

    .portal-side-card {
        align-self: start;
    }

    .side-stack {
        display: grid;
        gap: 0.85rem;
        margin-top: 1.2rem;
    }

    .side-chip {
        border: 1px solid rgba(197, 210, 248, 0.48);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.62);
        padding: 0.85rem 1rem;
        color: #4f0c28;
        font-weight: 700;
    }

    html[data-theme='dark'] .side-chip {
        background: rgba(15, 19, 26, 0.66);
        border-color: rgba(197, 210, 248, 0.14);
        color: #efc5cd;
    }

    @media (max-width: 1100px) {
        .portal-grid {
            grid-template-columns: 1fr;
        }

        .admin-stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .portal-header,
        .profile-grid,
        .company-needs-grid,
        .admin-stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

