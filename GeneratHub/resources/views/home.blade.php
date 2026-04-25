@extends('welcome')

@section('content')
<div class="landing-shell min-h-screen">
    <nav id="navbar" class="site-navbar">
        <a href="{{ route('login', absolute: false) }}" class="login-orb" aria-label="Login">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-3.33 0-6 1.79-6 4v1h12v-1c0-2.21-2.67-4-6-4Zm7-3h-5v2h5v3l4-4-4-4Z" />
            </svg>
        </a>

        <div class="site-navbar__inner">
            <button id="mobileToggle" class="site-navbar__toggle" type="button">Menu</button>

            <div id="navLinks" class="site-navbar__links">
                <a href="#hero">Accueil</a>
                <a href="#presentation">Presentation</a>
                <a href="#actors">Acteurs</a>
                <a href="#objectives">Objectifs</a>
                <a href="#explore">Explorer</a>
            </div>
        </div>
    </nav>

    <header id="hero" class="hero-section">
        <div class="hero-section__media">
            <div class="hero-section__overlay"></div>

            <div class="hero-section__content">
                <p class="eyebrow">Plateforme de recrutement</p>
                <h1>Une page d'accueil moderne et elegante pour ManageraHub</h1>
                <p class="hero-section__lead">
                    Une plateforme centralisee qui connecte les candidats, les entreprises et le processus de recrutement
                    dans une interface claire, professionnelle et visuellement forte.
                </p>
                <div class="hero-section__actions">
                    <a href="#presentation" class="btn-primary">Decouvrir</a>
                    <a href="#explore" class="btn-secondary">Voir les espaces</a>
                </div>
            </div>

            <div class="hero-placeholder">
                <div class="hero-placeholder__label">Zone image hero</div>
                <div class="hero-placeholder__hint">Ajoutez votre visuel principal ici plus tard</div>
            </div>
        </div>

        <div class="hero-wave"></div>
    </header>

    <main class="page-flow">
        <section id="presentation" class="section presentation-section">
            <div class="section-heading">
                <span class="eyebrow eyebrow--dark">Presentation</span>
                <h2>ManageraHub centralise le recrutement du profil jusqu'au suivi de candidature</h2>
            </div>

            <div class="presentation-grid">
                <div class="presentation-gallery">
                    <div class="gallery-card gallery-card--tall">
                        <span>Emplacement image verticale</span>
                    </div>
                    <div class="gallery-card">
                        <span>Emplacement image secondaire</span>
                    </div>
                    <div class="gallery-card gallery-card--accent">
                        <strong>100+</strong>
                        <small>Profils, opportunites ou indicateurs a valoriser</small>
                    </div>
                </div>

                <div class="presentation-copy">
                    <span class="chip">Perimetre du projet</span>
                    <h3>Une plateforme unique pour relier candidats, entreprises et gestion du recrutement.</h3>
                    <p>
                        La plateforme permet aux entreprises de publier leurs offres, aux candidats de creer un profil,
                        ajouter leurs documents, rechercher et postuler, puis de suivre chaque candidature dans un
                        parcours clair et structuré.
                    </p>
                    <ul class="check-list">
                        <li>Gestion des profils candidats, entreprises et administrateurs</li>
                        <li>Publication d'offres, suivi des candidatures et gestion du recrutement</li>
                        <li>Interface moderne avec acces rapide aux espaces metiers</li>
                    </ul>
                    <a href="#actors" class="btn-primary btn-primary--small">Voir les acteurs</a>
                </div>
            </div>
        </section>

        <section id="actors" class="section actors-section">
            <div class="section-heading">
                <span class="eyebrow eyebrow--dark">Acteurs du systeme</span>
                <h2>Chaque acteur dispose de ses actions et fonctionnalites dediees</h2>
                <p>Le site combine les besoins du candidat, de l'entreprise et de l'administration pour offrir un parcours coherent et performant.</p>
            </div>

            <div class="actors-grid">
                <article class="actor-card">
                    <span class="actor-card__index">01</span>
                    <h3>Candidat</h3>
                    <p>Creation de compte, ajout du CV, recherche d'offres, depot des candidatures et suivi de l'avancement.</p>
                </article>

                <article class="actor-card">
                    <span class="actor-card__index">02</span>
                    <h3>Entreprise</h3>
                    <p>Publication d'offres, consultation des candidatures, analyse des profils et gestion du recrutement.</p>
                </article>

                <article class="actor-card">
                    <span class="actor-card__index">03</span>
                    <h3>Administrateur</h3>
                    <p>Supervision des comptes, moderation, suivi global de la plateforme et gestion generale du systeme.</p>
                </article>
            </div>
        </section>

        <section id="objectives" class="section objectives-section">
            <div class="section-heading">
                <span class="eyebrow eyebrow--dark">Objectifs</span>
                <h2>Une structure claire, moderne et exploitable pour votre projet</h2>
            </div>

            <div class="objectives-grid">
                <div class="objective-card">
                    <h3>Centraliser</h3>
                    <p>Regrouper les profils, les offres et les candidatures dans une meme plateforme.</p>
                </div>

                <div class="objective-card">
                    <h3>Fluidifier</h3>
                    <p>Simplifier l'inscription, la recherche d'offres, le depot des candidatures et leur suivi efficace.</p>
                </div>

                <div class="objective-card">
                    <h3>Valoriser</h3>
                    <p>Mettre en avant les entreprises, les candidats et les opportunites de facon visuelle et professionnelle.</p>
                </div>
            </div>
        </section>

        <section id="explore" class="section explore-section">
            <div class="section-heading">
                <span class="eyebrow eyebrow--dark">Explorer</span>
                <h2>Choisissez votre espace</h2>
                <p>Deux grands blocs prets a accueillir vos vraies images plus tard tout en restant deja exploitables.</p>
            </div>

            <div class="explore-grid">
                <a href="{{ route('register.form', ['type' => 'candidate'], false) }}" class="explore-card">
                    <div class="explore-card__placeholder">
                        <span>Grande image 01</span>
                    </div>
                    <div class="explore-card__content">
                        <p class="explore-card__eyebrow">Espace 01</p>
                        <h3>Espace Candidat</h3>
                        <p>Creation de profil, depot des documents, recherche d'offres et timeline de suivi.</p>
                        <span class="explore-card__cta">S'inscrire comme candidat</span>
                    </div>
                </a>

                <a href="{{ route('register.form', ['type' => 'company'], false) }}" class="explore-card explore-card--alt">
                    <div class="explore-card__placeholder">
                        <span>Grande image 02</span>
                    </div>
                    <div class="explore-card__content">
                        <p class="explore-card__eyebrow">Espace 02</p>
                        <h3>Espace Entreprise</h3>
                        <p>Publication d'offres, consultation des candidatures et gestion du recrutement.</p>
                        <span class="explore-card__cta">S'inscrire comme entreprise</span>
                    </div>
                </a>
            </div>
        </section>
    </main>
</div>

<style>
    .landing-shell {
        min-height: 100vh;
        background:
            radial-gradient(circle at top left, rgba(197, 210, 248, 0.5), transparent 28%),
            radial-gradient(circle at bottom right, rgba(79, 12, 40, 0.08), transparent 18%),
            #f4f8ff;
        color: #1f2937;
    }

    .site-navbar {
        position: sticky;
        top: 0;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.25rem;
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        background: rgba(255, 255, 255, 0.45);
        border-bottom: 1px solid rgba(255, 255, 255, 0.55);
    }

    .site-navbar__inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: 1280px;
        margin: 0 auto;
        gap: 1rem;
    }

    .site-navbar__links {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .site-navbar__links a {
        text-decoration: none;
        color: #4f0c28;
        font-weight: 700;
        padding: 0.7rem 1rem;
        border-radius: 999px;
        transition: 0.25s ease;
    }

    .site-navbar__links a:hover {
        background: rgba(197, 210, 248, 0.35);
    }

    .site-navbar__toggle {
        display: none;
        border: none;
        background: rgba(197, 210, 248, 0.35);
        color: #4f0c28;
        padding: 0.8rem 1rem;
        border-radius: 999px;
        font-weight: 700;
        cursor: pointer;
    }

    .login-orb {
        width: 52px;
        height: 52px;
        min-width: 52px;
        border-radius: 999px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.72), rgba(197, 210, 248, 0.38));
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 16px 30px rgba(0, 0, 0, 0.08);
        text-decoration: none;
    }

    .login-orb svg {
        width: 24px;
        height: 24px;
        fill: #4f0c28;
    }

    .hero-section {
        position: relative;
        padding: 2rem 1.25rem 0;
    }

    .hero-section__media {
        max-width: 1280px;
        margin: 0 auto;
        min-height: 720px;
        border-radius: 2rem;
        overflow: hidden;
        position: relative;
        display: grid;
        grid-template-columns: 1.05fr 0.95fr;
        background:
            linear-gradient(135deg, rgba(79, 12, 40, 0.16), rgba(197, 210, 248, 0.18)),
            linear-gradient(180deg, #dbe7ff, #c8d6fb 45%, #b5c6f6);
        box-shadow: 0 24px 60px rgba(70, 90, 130, 0.18);
    }

    .hero-section__overlay {
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 15% 20%, rgba(255, 255, 255, 0.8), transparent 18%),
            radial-gradient(circle at 80% 30%, rgba(255, 255, 255, 0.32), transparent 15%),
            linear-gradient(180deg, rgba(255, 255, 255, 0.08), transparent 35%);
        pointer-events: none;
    }

    .hero-section__content {
        position: relative;
        z-index: 2;
        padding: 5rem 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .eyebrow {
        margin: 0 0 1rem;
        font-size: 0.88rem;
        font-weight: 800;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #5f6f94;
    }

    .eyebrow--dark {
        color: #5d7c66;
    }

    .hero-section__content h1 {
        margin: 0;
        font-size: clamp(2.6rem, 5vw, 5rem);
        line-height: 0.98;
        color: #172033;
        max-width: 700px;
    }

    .hero-section__lead {
        max-width: 620px;
        margin-top: 1.35rem;
        font-size: 1.05rem;
        line-height: 1.9;
        color: rgba(23, 32, 51, 0.8);
    }

    .hero-section__actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }

    .btn-primary,
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 170px;
        padding: 0.95rem 1.4rem;
        border-radius: 999px;
        text-decoration: none;
        font-weight: 800;
        transition: 0.25s ease;
    }

    .btn-primary {
        background: #4f0c28;
        color: #fff;
        box-shadow: 0 16px 28px rgba(79, 12, 40, 0.18);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
    }

    .btn-primary--small {
        min-width: 0;
        width: fit-content;
        margin-top: 0.6rem;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.55);
        color: #4f0c28;
        border: 1px solid rgba(255, 255, 255, 0.72);
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
    }

    .hero-placeholder {
        position: relative;
        z-index: 2;
        margin: 2rem;
        border-radius: 1.7rem;
        border: 1px dashed rgba(79, 12, 40, 0.25);
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.34), rgba(255, 255, 255, 0.15)),
            rgba(197, 210, 248, 0.22);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: calc(100% - 4rem);
        text-align: center;
        padding: 2rem;
    }

    .hero-placeholder__label {
        font-size: 1.3rem;
        font-weight: 800;
        color: #4f0c28;
    }

    .hero-placeholder__hint {
        margin-top: 0.75rem;
        color: rgba(79, 12, 40, 0.7);
        line-height: 1.8;
    }

    .hero-wave {
        height: 80px;
        margin-top: -24px;
        background: linear-gradient(to bottom, transparent, #f4f8ff);
    }

    .page-flow {
        display: grid;
        gap: 2rem;
        padding: 0 1.25rem 3rem;
    }

    .section {
        max-width: 1280px;
        margin: 0 auto;
        width: 100%;
        padding: 2.2rem;
        border-radius: 2rem;
        background: rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 18px 40px rgba(80, 98, 138, 0.08);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
    }

    .section-heading h2 {
        margin: 0.45rem 0 0;
        font-size: clamp(1.8rem, 3vw, 3rem);
        color: #172033;
        line-height: 1.1;
    }

    .section-heading p {
        margin-top: 0.9rem;
        max-width: 760px;
        color: rgba(23, 32, 51, 0.75);
        line-height: 1.9;
    }

    .presentation-grid {
        display: grid;
        grid-template-columns: 0.95fr 1.05fr;
        gap: 1.6rem;
        margin-top: 2rem;
        align-items: center;
    }

    .presentation-gallery {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 230px 170px;
        gap: 1rem;
    }

    .gallery-card {
        border-radius: 1.5rem;
        background: linear-gradient(145deg, rgba(197, 210, 248, 0.38), rgba(255, 255, 255, 0.7));
        border: 1px solid rgba(255, 255, 255, 0.65);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 1.2rem;
        color: #4f0c28;
        font-weight: 700;
        min-height: 170px;
    }

    .gallery-card--tall {
        grid-row: span 2;
        min-height: 410px;
    }

    .gallery-card--accent {
        flex-direction: column;
        background: linear-gradient(135deg, #4f0c28, #6d1a42);
        color: white;
    }

    .gallery-card--accent strong {
        font-size: 2.5rem;
        line-height: 1;
    }

    .gallery-card--accent small {
        margin-top: 0.8rem;
        line-height: 1.7;
        max-width: 180px;
    }

    .presentation-copy h3 {
        margin: 1rem 0 0;
        font-size: clamp(1.5rem, 2.5vw, 2.4rem);
        line-height: 1.2;
        color: #172033;
    }

    .presentation-copy p {
        margin-top: 1rem;
        line-height: 1.95;
        color: rgba(23, 32, 51, 0.78);
    }

    .chip {
        display: inline-flex;
        align-items: center;
        padding: 0.55rem 0.95rem;
        border-radius: 999px;
        background: rgba(197, 210, 248, 0.4);
        color: #4f0c28;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .check-list {
        margin: 1.2rem 0 0;
        padding-left: 1.2rem;
        color: rgba(23, 32, 51, 0.82);
        line-height: 1.9;
    }

    .actors-grid,
    .objectives-grid,
    .explore-grid {
        display: grid;
        gap: 1.2rem;
        margin-top: 2rem;
    }

    .actors-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .objectives-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .explore-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .actor-card,
    .objective-card {
        padding: 1.5rem;
        border-radius: 1.5rem;
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.88), rgba(197, 210, 248, 0.25));
        border: 1px solid rgba(255, 255, 255, 0.65);
        box-shadow: 0 14px 28px rgba(80, 98, 138, 0.07);
    }

    .actor-card__index {
        display: inline-flex;
        width: 44px;
        height: 44px;
        border-radius: 999px;
        align-items: center;
        justify-content: center;
        background: rgba(79, 12, 40, 0.1);
        color: #4f0c28;
        font-weight: 800;
    }

    .actor-card h3,
    .objective-card h3 {
        margin: 1rem 0 0.6rem;
        color: #172033;
    }

    .actor-card p,
    .objective-card p {
        margin: 0;
        line-height: 1.85;
        color: rgba(23, 32, 51, 0.76);
    }

    .explore-card {
        overflow: hidden;
        border-radius: 1.7rem;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.65);
        background: rgba(255, 255, 255, 0.75);
        box-shadow: 0 18px 36px rgba(80, 98, 138, 0.1);
        transition: 0.25s ease;
    }

    .explore-card:hover {
        transform: translateY(-4px);
    }

    .explore-card__placeholder {
        min-height: 320px;
        display: grid;
        place-items: center;
        background:
            linear-gradient(135deg, rgba(79, 12, 40, 0.18), rgba(197, 210, 248, 0.28)),
            linear-gradient(180deg, #cfdcff, #bccdf8);
        color: #4f0c28;
        font-size: 1.1rem;
        font-weight: 800;
        text-align: center;
        padding: 2rem;
    }

    .explore-card--alt .explore-card__placeholder {
        background:
            linear-gradient(135deg, rgba(58, 95, 84, 0.18), rgba(197, 210, 248, 0.24)),
            linear-gradient(180deg, #d8ecdf, #bdd9c7);
        color: #244236;
    }

    .explore-card__content {
        padding: 1.5rem;
    }

    .explore-card__eyebrow {
        margin: 0;
        color: #5f6f94;
        font-size: 0.85rem;
        font-weight: 800;
        letter-spacing: 0.15em;
        text-transform: uppercase;
    }

    .explore-card__content h3 {
        margin: 0.7rem 0 0;
        font-size: 1.7rem;
        color: #172033;
    }

    .explore-card__content p {
        margin-top: 0.8rem;
        line-height: 1.85;
        color: rgba(23, 32, 51, 0.76);
    }

    .explore-card__cta {
        display: inline-block;
        margin-top: 1rem;
        color: #4f0c28;
        font-weight: 800;
    }

    @media (max-width: 1100px) {
        .hero-section__media,
        .presentation-grid,
        .explore-grid,
        .actors-grid,
        .objectives-grid {
            grid-template-columns: 1fr;
        }

        .hero-placeholder {
            min-height: 360px;
        }

        .presentation-gallery {
            grid-template-columns: 1fr 1fr;
        }

        .gallery-card--tall {
            grid-row: span 1;
            min-height: 240px;
        }
    }

    @media (max-width: 768px) {
        .site-navbar {
            align-items: flex-start;
        }

        .site-navbar__inner {
            flex-direction: column;
            align-items: stretch;
        }

        .site-navbar__toggle {
            display: inline-flex;
            align-self: flex-end;
        }

        .site-navbar__links {
            display: none;
            flex-direction: column;
            align-items: stretch;
            width: 100%;
            padding-top: 0.5rem;
        }

        .site-navbar__links.is-open {
            display: flex;
        }

        .hero-section__content {
            padding: 3rem 1.4rem;
        }

        .hero-section__media {
            min-height: auto;
        }

        .section {
            padding: 1.4rem;
        }

        .presentation-gallery {
            grid-template-columns: 1fr;
            grid-template-rows: auto;
        }

        .gallery-card,
        .gallery-card--tall {
            min-height: 220px;
        }
    }
</style>

<script>
    const mobileToggle = document.getElementById('mobileToggle');
    const navLinks = document.getElementById('navLinks');

    if (mobileToggle && navLinks) {
        mobileToggle.addEventListener('click', function () {
            navLinks.classList.toggle('is-open');
        });
    }
</script>
@endsection