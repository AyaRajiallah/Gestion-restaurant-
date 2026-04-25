@extends('welcome')

@section('content')
<div class="login-shell">
    <div class="login-topbar">
        <a href="{{ route('home', absolute: false) }}" class="glassy-login-pill">Retour a l'accueil</a>
        <a href="{{ route('register.form', ['type' => 'candidate'], false) }}" class="glassy-login-pill glassy-login-pill--accent">Sign up</a>
    </div>

    <div class="login-card">
        <section class="login-panel login-panel--form">
            <p class="login-kicker">ManageraHub</p>
            <h1>Log in</h1>
            <p class="login-copy">Connectez-vous a votre espace candidat, entreprise ou administrateur.</p>

            @if (session('status'))
                <div class="login-alert login-alert--success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="login-alert login-alert--error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.submit', absolute: false) }}" class="login-form">
                @csrf

                <label class="login-field">
                    <span>E-mail address</span>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>

                <label class="login-field">
                    <span>Password</span>
                    <input type="password" name="password" required>
                </label>

                <div class="login-row">
                    <label class="login-remember">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>

                    <a href="{{ route('password.request', absolute: false) }}">I forgot</a>
                </div>

                <button type="submit" class="login-submit">Se connecter</button>
            </form>
        </section>

        <aside class="login-panel login-panel--visual">
            <div class="login-photo-card">
                <div class="login-photo-placeholder">Photo profile</div>
            </div>

            <div class="login-floating login-floating--top">
                <strong>Admin ready</strong>
                <span>L'adresse `ayarajiallah@gmail.com` est promue automatiquement en administrateur.</span>
            </div>

            <div class="login-floating login-floating--bottom">
                <strong>Follow-up</strong>
                <span>Le candidat retrouve ensuite une timeline verticale de progression dans son espace.</span>
            </div>
        </aside>
    </div>
</div>

<style>
    .login-shell {
        min-height: 100vh;
        padding: 1.6rem 1.2rem 3rem;
        background:
            radial-gradient(circle at top left, rgba(197, 210, 248, 0.5), transparent 30%),
            radial-gradient(circle at bottom right, rgba(79, 12, 40, 0.08), transparent 20%),
            #f1faee;
    }

    html[data-theme='dark'] .login-shell {
        background:
            radial-gradient(circle at top left, rgba(197, 210, 248, 0.14), transparent 26%),
            radial-gradient(circle at bottom right, rgba(79, 12, 40, 0.16), transparent 18%),
            #11141b;
    }

    .login-topbar {
        max-width: 1120px;
        margin: 0 auto 1.25rem;
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .glassy-login-pill {
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
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    .glassy-login-pill--accent {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.48), rgba(197, 210, 248, 0.24));
    }

    .login-card {
        max-width: 1120px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 0.9fr 1.1fr;
        gap: 1.4rem;
        padding: 1rem;
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.62);
        background: rgba(255, 255, 255, 0.34);
        box-shadow: 0 20px 50px rgba(77, 84, 105, 0.12);
        backdrop-filter: blur(20px) saturate(155%);
        -webkit-backdrop-filter: blur(20px) saturate(155%);
    }

    html[data-theme='dark'] .login-card {
        background: rgba(22, 26, 34, 0.56);
        border-color: rgba(197, 210, 248, 0.16);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.26);
    }

    .login-panel {
        border-radius: 1.7rem;
    }

    .login-panel--form {
        padding: 2.1rem;
        background: rgba(255, 255, 255, 0.82);
    }

    html[data-theme='dark'] .login-panel--form {
        background: rgba(15, 19, 26, 0.84);
        color: #edf3ef;
    }

    .login-kicker {
        margin: 0;
        color: #6d726b;
        font-size: 0.9rem;
    }

    .login-panel--form h1 {
        margin: 0.7rem 0 0;
        color: #151816;
        font-size: clamp(2.2rem, 5vw, 3.2rem);
    }

    html[data-theme='dark'] .login-panel--form h1 {
        color: #edf3ef;
    }

    .login-copy {
        color: rgba(36, 40, 38, 0.74);
        line-height: 1.8;
    }

    html[data-theme='dark'] .login-copy {
        color: rgba(237, 243, 239, 0.76);
    }

    .login-form {
        display: grid;
        gap: 1rem;
        margin-top: 1.6rem;
    }

    .login-field {
        display: grid;
        gap: 0.45rem;
    }

    .login-field span {
        color: #6b7280;
        font-size: 0.92rem;
    }

    html[data-theme='dark'] .login-field span {
        color: rgba(237, 243, 239, 0.72);
    }

    .login-field input {
        border: none;
        border-radius: 999px;
        background: rgba(242, 244, 245, 0.9);
        padding: 0.95rem 1rem;
        font: inherit;
        color: #1f2937;
    }

    html[data-theme='dark'] .login-field input {
        background: rgba(36, 42, 54, 0.92);
        color: #edf3ef;
    }

    .login-row {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .login-row a {
        color: #4f0c28;
        text-decoration: none;
        font-weight: 700;
    }

    .login-remember {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
    }

    .login-submit {
        border: none;
        border-radius: 999px;
        background: linear-gradient(135deg, #4d6b56, #40604a);
        color: white;
        padding: 1rem 1.2rem;
        font: inherit;
        font-weight: 800;
        cursor: pointer;
    }

    .login-alert {
        margin-top: 1rem;
        padding: 0.9rem 1rem;
        border-radius: 1rem;
    }

    .login-alert--success {
        background: rgba(96, 140, 112, 0.12);
        color: #31503b;
    }

    .login-alert--error {
        background: rgba(79, 12, 40, 0.1);
        color: #4f0c28;
    }

    .login-panel--visual {
        position: relative;
        min-height: 620px;
        overflow: hidden;
        background:
            linear-gradient(145deg, rgba(79, 12, 40, 0.12), rgba(197, 210, 248, 0.28)),
            linear-gradient(180deg, rgba(57, 74, 66, 0.5), rgba(80, 95, 88, 0.62));
    }

    .login-panel--visual::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.06), transparent 35%),
            radial-gradient(circle at 60% 25%, rgba(255, 255, 255, 0.16), transparent 18%);
    }

    .login-photo-card,
    .login-floating {
        position: absolute;
        z-index: 1;
        border: 1px solid rgba(255, 255, 255, 0.44);
        background: rgba(255, 255, 255, 0.38);
        box-shadow: 0 14px 30px rgba(33, 49, 38, 0.16);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    .login-photo-card {
        top: 2rem;
        left: 50%;
        transform: translateX(-50%);
        width: 220px;
        height: 220px;
        border-radius: 2rem;
        display: grid;
        place-items: center;
    }

    .login-photo-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 999px;
        background: rgba(197, 210, 248, 0.4);
        display: grid;
        place-items: center;
        text-align: center;
        color: #4f0c28;
        font-weight: 700;
        padding: 0.5rem;
    }

    .login-floating {
        max-width: 260px;
        border-radius: 1.3rem;
        padding: 1rem 1.1rem;
        color: #243028;
    }

    .login-floating strong,
    .login-floating span {
        display: block;
    }

    .login-floating span {
        margin-top: 0.35rem;
        line-height: 1.6;
        color: rgba(36, 48, 40, 0.78);
    }

    .login-floating--top {
        top: 18rem;
        left: 2rem;
    }

    .login-floating--bottom {
        right: 2rem;
        bottom: 2rem;
    }

    @media (max-width: 980px) {
        .login-card {
            grid-template-columns: 1fr;
        }

        .login-panel--visual {
            min-height: 360px;
        }
    }
</style>
@endsection

