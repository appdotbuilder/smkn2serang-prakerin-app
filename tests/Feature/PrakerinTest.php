<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\DailyJournal;
use App\Models\PrakerinPlacement;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrakerinTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the welcome page loads correctly.
     */
    public function test_welcome_page_loads(): void
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
    }

    /**
     * Test that authenticated users are redirected to prakerin dashboard.
     */
    public function test_authenticated_users_redirected_to_prakerin(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertRedirect(route('prakerin.index'));
    }

    /**
     * Test that students can access their prakerin dashboard.
     */
    public function test_student_can_access_prakerin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $student = Student::factory()->create(['user_id' => $user->id]);
        
        $response = $this->actingAs($user)->get(route('prakerin.index'));
        
        $response->assertStatus(200);
    }

    /**
     * Test that students with active placement can access journal form.
     */
    public function test_student_with_placement_can_access_journal_form(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $student = Student::factory()->create(['user_id' => $user->id]);
        $company = Company::factory()->active()->create();
        $teacher = Teacher::factory()->supervisingTeacher()->create();
        
        PrakerinPlacement::factory()->ongoing()->create([
            'student_id' => $student->id,
            'company_id' => $company->id,
            'supervising_teacher_id' => $teacher->id,
        ]);
        
        $response = $this->actingAs($user)->get(route('prakerin.create'));
        
        $response->assertStatus(200);
    }

    /**
     * Test that students can submit journal entries.
     */
    public function test_student_can_submit_journal_entry(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $student = Student::factory()->create(['user_id' => $user->id]);
        $company = Company::factory()->active()->create();
        $teacher = Teacher::factory()->supervisingTeacher()->create();
        
        $placement = PrakerinPlacement::factory()->ongoing()->create([
            'student_id' => $student->id,
            'company_id' => $company->id,
            'supervising_teacher_id' => $teacher->id,
        ]);
        
        $journalData = [
            'journal_date' => now()->format('Y-m-d'),
            'activities' => 'Melakukan maintenance sistem komputer dan troubleshooting',
            'learning_outcomes' => 'Belajar troubleshooting hardware',
            'challenges' => 'Kesulitan mengidentifikasi masalah motherboard',
            'attendance_status' => 'present',
            'clock_in' => '08:00',
            'clock_out' => '17:00',
        ];
        
        $response = $this->actingAs($user)->post(route('prakerin.store'), $journalData);
        
        $response->assertStatus(200);
        
        $this->assertDatabaseHas('daily_journals', [
            'placement_id' => $placement->id,
            'activities' => $journalData['activities'],
            'attendance_status' => 'present',
        ]);
    }

    /**
     * Test that teachers can view their supervised students.
     */
    public function test_teacher_can_view_supervised_students(): void
    {
        $user = User::factory()->create(['role' => 'teacher']);
        $teacher = Teacher::factory()->supervisingTeacher()->create(['user_id' => $user->id]);
        $student = Student::factory()->create();
        $company = Company::factory()->active()->create();
        
        PrakerinPlacement::factory()->ongoing()->create([
            'student_id' => $student->id,
            'company_id' => $company->id,
            'supervising_teacher_id' => $teacher->id,
        ]);
        
        $response = $this->actingAs($user)->get(route('prakerin.index'));
        
        $response->assertStatus(200)
                ->assertSee($student->name);
    }

    /**
     * Test that guests cannot access prakerin routes.
     */
    public function test_guests_cannot_access_prakerin_routes(): void
    {
        $response = $this->get(route('prakerin.index'));
        $response->assertRedirect(route('login'));
        
        $response = $this->get(route('prakerin.create'));
        $response->assertRedirect(route('login'));
        
        $response = $this->post(route('prakerin.store'), []);
        $response->assertRedirect(route('login'));
    }

    /**
     * Test that journal validation works correctly.
     */
    public function test_journal_validation_works(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $student = Student::factory()->create(['user_id' => $user->id]);
        $company = Company::factory()->active()->create();
        $teacher = Teacher::factory()->supervisingTeacher()->create();
        
        PrakerinPlacement::factory()->ongoing()->create([
            'student_id' => $student->id,
            'company_id' => $company->id,
            'supervising_teacher_id' => $teacher->id,
        ]);
        
        // Test with invalid data
        $response = $this->actingAs($user)->post(route('prakerin.store'), [
            'journal_date' => '',
            'activities' => 'abc', // Too short
            'attendance_status' => 'invalid',
        ]);
        
        $response->assertSessionHasErrors(['journal_date', 'activities', 'attendance_status']);
    }
}