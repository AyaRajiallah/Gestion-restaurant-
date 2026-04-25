@extends('welcome')

@section('content')
<div class="simple-auth-shell">
    <div class="simple-auth-card">
        <h1>Nouveau mot de passe</h1>
        <p>Choisissez un nouveau mot de passe pour votre compte.</p>

        @if ($errors->any())
            <div class="simple-auth-alert simple-auth-alert--error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.update', absolute: false) }}" class="simple-auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="email" name="email" value="{{ old('email', $email) }}" placeholder="Email" required>
            <input type="password" name="password" placeholder="Nouveau mot de passe" required>
            <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
            <button type="submit">Reinitialiser</button>
        </form>
    </div>
</div>

<style>
    .simple-auth-shell {
        min-height: 100vh;
        display: grid;
        place-items: center;
        padding: 1.5rem;
        background:
            radial-gradient(circle at top left, rgba(197, 210, 248, 0.42), transparent 28%),
            radial-gradient(circle at bottom right, rgba(79, 12, 40, 0.08), transparent 18%),
            #f1faee;
    }

    .simple-auth-card {
        width: min(100%, 480px);
        border: 1px solid rgba(255, 255, 255, 0.55);
        border-radius: 2rem;
        background: rgba(255, 255, 255, 0.54);
        padding: 2rem;
        box-shadow: 0 20px 45px rgba(86, 92, 116, 0.12);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    .simple-auth-card h1 {
        margin: 0;
        color: #4f0c28;
    }

    .simple-auth-card p {
        color: rgba(36, 40, 38, 0.76);
        line-height: 1.7;
    }

    .simple-auth-form {
        display: grid;
        gap: 0.95rem;
        margin-top: 1.4rem;
    }

    .simple-auth-form input {
        border: 1px solid rgba(197, 210, 248, 0.72);
        border-radius: 999px;
        padding: 0.95rem 1rem;
        background: #f6f7f8;
        font: inherit;
    }

    .simple-auth-form button {
        border: none;
        border-radius: 999px;
        background: #4f0c28;
        color: white;
        padding: 0.95rem 1rem;
        font: inherit;
        font-weight: 700;
        cursor: pointer;
    }

    .simple-auth-alert {
        margin-top: 1rem;
        border-radius: 1rem;
        padding: 0.85rem 1rem;
        background: rgba(79, 12, 40, 0.1);
        color: #4f0c28;
    }
</style>
@endsection

