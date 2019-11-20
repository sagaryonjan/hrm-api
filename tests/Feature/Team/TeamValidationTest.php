<?php

namespace Tests\Feature\Team;

use App\Team;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamValidationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_team_requires_a_full_name()
    {
        $attributes = factory(Team::class)->raw(['full_name' => '']);

        $this->actingAs($this->createUser(), 'api')
            ->postJson('/api/teams', $attributes)
            ->assertJsonValidationErrors('full_name');
    }

    /** @test */
    public function a_team_requires_a_email()
    {
        $attributes = factory(Team::class)->raw(['email' => '']);

        $this->actingAs($this->createUser(), 'api')
            ->postJson('/api/teams', $attributes)
            ->assertJsonValidationErrors('email');
    }

    /** @test */
    public function a_team_requires_a_phone_number()
    {
        $attributes = factory(Team::class)->raw(['phone_number' => '']);

        $this->actingAs($this->createUser(), 'api')
            ->postJson('/api/teams', $attributes)
            ->assertJsonValidationErrors('phone_number');
    }

    /** @test */
    public function a_team_requires_a_company()
    {
        $attributes = factory(Team::class)->raw(['company' => '']);

        $this->actingAs($this->createUser(), 'api')
            ->postJson('/api/teams', $attributes)
            ->assertJsonValidationErrors('company');
    }

    /** @test */
    public function a_team_requires_a_address()
    {
        $attributes = factory(Team::class)->raw(['address' => '']);

        $this->actingAs($this->createUser(), 'api')
            ->postJson('/api/teams', $attributes)
            ->assertJsonValidationErrors('address');
    }

    /** @test */
    public function a_team_requires_a_about()
    {
        $attributes = factory(Team::class)->raw(['about' => '']);

        $this->actingAs($this->createUser(), 'api')
            ->postJson('/api/teams', $attributes)
            ->assertJsonValidationErrors('about');
    }

    /**
     * Create User
     *
     * @param array $attributes
     * @return mixed
     */
    public function createUser(array $attributes = [])
    {
        $user = factory(User::class)->create($attributes);

        return $user;
    }

}
