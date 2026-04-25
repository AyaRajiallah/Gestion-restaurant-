<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegistrationForm(Request $request): RedirectResponse|View
    {
        $type = $request->query('type');

        if (!in_array($type, ['candidate', 'company'])) {
            return redirect('/')->with('error', 'Invalid registration type');
        }

        return view('auth.register', compact('type'));
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', 'min:8'],
            'account_type' => ['required', 'in:candidate,company'],
            'attachment_label' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'diploma' => ['nullable', 'string', 'max:255'],
            'graduation_year' => ['nullable', 'string', 'max:20'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'graduation_city' => ['nullable', 'string', 'max:255'],
            'organization_name' => ['nullable', 'string', 'max:255'],
            'sector' => ['nullable', 'string', 'max:255'],
            'goal' => ['required', 'string', 'max:1000'],
            'terms_accepted' => ['accepted'],
        ]);

        if ($validated['account_type'] === 'candidate') {
            $request->validate([
                'attachment_label' => ['required', 'string', 'max:255'],
                'birth_date' => ['required', 'date'],
                'diploma' => ['required', 'string', 'max:255'],
                'graduation_year' => ['required', 'string', 'max:20'],
                'field_of_study' => ['required', 'string', 'max:255'],
                'graduation_city' => ['required', 'string', 'max:255'],
            ]);
        }

        if ($validated['account_type'] === 'company') {
            $request->validate([
                'organization_name' => ['required', 'string', 'max:255'],
                'sector' => ['required', 'string', 'max:255'],
            ]);
        }

        $user = User::create([
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'account_type' => $validated['account_type'],
            'phone' => $validated['phone'] ?? null,
            'attachment_label' => $validated['attachment_label'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'diploma' => $validated['diploma'] ?? null,
            'graduation_year' => $validated['graduation_year'] ?? null,
            'field_of_study' => $validated['field_of_study'] ?? null,
            'graduation_city' => $validated['graduation_city'] ?? null,
            'organization_name' => $validated['organization_name'] ?? null,
            'sector' => $validated['sector'] ?? null,
            'goal' => $validated['goal'],
            'application_stage' => $validated['account_type'] === 'candidate' ? 'profile_created' : 'needs_defined',
            'terms_accepted' => true,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('auth.portal')->with('status', 'Votre compte a ete cree avec succes.');
    }

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email' => 'Les informations de connexion sont incorrectes.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('auth.portal'));
    }

    public function portal(Request $request): View
    {
        $timeline = [
            'profile_created' => [
                'label' => 'Profil cree',
                'description' => 'Vos informations sont enregistrees et votre compte est actif.',
            ],
            'application_submitted' => [
                'label' => 'Candidature envoyee',
                'description' => 'Votre dossier est transmis vers les entreprises ciblees.',
            ],
            'under_review' => [
                'label' => 'Etude du dossier',
                'description' => 'Le recruteur analyse votre profil et vos competences.',
            ],
            'interview' => [
                'label' => 'Entretien',
                'description' => 'Vous etes invite a echanger avec l\'entreprise.',
            ],
            'decision' => [
                'label' => 'Decision finale',
                'description' => 'Vous recevez la reponse finale et les prochaines etapes.',
            ],
        ];

        return view('auth.portal', [
            'user' => $request->user(),
            'timeline' => $timeline,
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->string('email')->value(),
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}