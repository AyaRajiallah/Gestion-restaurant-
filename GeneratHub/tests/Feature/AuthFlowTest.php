<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_register_from_the_candidate_form(): void
    {
        Storage::fake('public');

        $response = $this->post('/register', [
            'first_name' => 'Aya',
            'last_name' => 'Test',
            'email' => 'aya@example.com',
            'phone' => '0600000000',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'account_type' => 'candidate',
            'profile_photo' => UploadedFile::fake()->create('profil.jpg', 120, 'image/jpeg'),
            'cv_document' => UploadedFile::fake()->create('cv.pdf', 180, 'application/pdf'),
            'motivation_letter' => UploadedFile::fake()->create('lettre.pdf', 120, 'application/pdf'),
            'attachment_label' => 'Etudiant(e)',
            'birth_date' => '2005-06-06',
            'diploma' => 'BAC+3',
            'graduation_year' => '2026',
            'field_of_study' => 'Ingenierie informatique et reseaux',
            'graduation_city' => 'Rabat',
            'goal' => 'Trouver un stage de fin d etudes puis un premier emploi.',
            'terms_accepted' => '1',
        ]);

        $response->assertRedirect('/portal');

        $this->assertDatabaseHas('users', [
            'email' => 'aya@example.com',
            'account_type' => 'candidate',
            'first_name' => 'Aya',
            'graduation_city' => 'Rabat',
        ]);

        $user = User::where('email', 'aya@example.com')->firstOrFail();

        Storage::disk('public')->assertExists($user->profile_photo_path);
        Storage::disk('public')->assertExists($user->cv_path);
        Storage::disk('public')->assertExists($user->motivation_letter_path);
    }

    public function test_the_forgot_password_page_is_accessible(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertOk();
        $response->assertSee('Mot de passe oublie');
    }

    public function test_the_admin_email_is_promoted_to_admin_on_registration(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Aya',
            'last_name' => 'Admin',
            'email' => 'ayarajiallah@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'account_type' => 'company',
            'organization_name' => 'ManageraHub',
            'company_city' => 'Rabat',
            'company_size' => '11-50',
            'sector' => 'Technologie',
            'target_profiles' => 'Developpeurs full stack',
            'goal' => 'Superviser la plateforme et piloter les operations.',
            'terms_accepted' => '1',
        ]);

        $response->assertRedirect('/portal');

        $this->assertDatabaseHas('users', [
            'email' => 'ayarajiallah@gmail.com',
            'role' => 'admin',
        ]);
    }

    public function test_an_authenticated_user_can_view_the_portal(): void
    {
        $user = User::factory()->create([
            'account_type' => 'company',
        ]);

        $response = $this->actingAs($user)->get('/portal');

        $response->assertOk();
        $response->assertSee('entreprise');
    }
}
