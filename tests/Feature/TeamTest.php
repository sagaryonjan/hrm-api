<?php

namespace Tests\Feature;

use App\Http\Resources\Team as TeamResource;
use App\Team;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function can_return_a_collection_of_teams_with_paginated()
    {
        $team1 = $this->createTeam();
        $team2 = $this->createTeam();
        $team3 = $this->createTeam();

        $response = $this->actingAs($this->createUser(), 'api')
            ->getJson('/api/teams');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'full_name', 'email', 'phone_number',
                        'company', 'address', 'about', 'created_at'
                    ]
                ],
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => [
                    'current_page', 'last_page', 'from', 'to',
                    'path', 'per_page', 'total'
                ]
            ]);
    }

    /** @test */
    public function can_create_a_team()
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'full_name'    => $this->faker->name,
            'email'        => $this->faker->email,
            'phone_number' => $this->faker->phoneNumber,
            'company'      => $this->faker->company,
            'address'      => $this->faker->address,
            'about'        => $this->faker->text,
        ];

        $response = $this->actingAs($this->createUser(), 'api')
            ->postJson('/api/teams', $attributes);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'id', 'full_name', 'email', 'phone_number',
                'company', 'address', 'about', 'created_at'
            ])->assertJson($attributes);


        $this->assertDatabaseHas('teams', $attributes);
    }

    /** @test */
    public function team_not_found_404()
    {
        $response = $this->actingAs($this->createUser(), 'api')
            ->getJson('/api/teams/-1');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function can_return_a_team()
    {
        $team = $this->createTeam();

        $response = $this->actingAs($this->createUser(), 'api')
            ->getJson('/api/teams/'.$team->id);

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function team_not_found_404_while_updating()
    {
        $response = $this->actingAs($this->createUser(), 'api')
            ->patchJson('/api/teams/-1');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function can_update_a_team()
    {
        $team = $this->createTeam();

        $attributes = [
            'id'           => $team->id,
            'full_name'    => $team->full_name . 'changed',
            'email'        => $team->email,
            'phone_number' => $team->phone_number,
            'company'      => $team->company . 'changed',
            'address'      => $team->address . 'changed',
            'about'        => $team->about . 'changed',
        ];

        $response = $this->actingAs($this->createUser(), 'api')
            ->patchJson('/api/teams/'.$team->id, $attributes);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'id', 'full_name', 'email', 'phone_number',
                'company', 'address', 'about', 'created_at'
            ])->assertJson($attributes);

        $this->assertDatabaseHas('teams', $attributes);
    }

    /** @test */
    public function team_not_found_404_while_deleting()
    {
        $response = $this->actingAs($this->createUser(), 'api')
            ->deleteJson('/api/teams/-1');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function can_delete_a_team()
    {
        $team = $this->createTeam();

        $response = $this->actingAs($this->createUser(), 'api')
            ->deleteJson('/api/teams/'. $team->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT)
            ->assertSee(null);

        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }

    /** @test */
    public function unauthorized_user_cannot_access_the_following_endpoints()
    {
        $index = $this->getJson('/api/teams');
        $index->assertStatus(Response::HTTP_UNAUTHORIZED);

        $index = $this->postJson('/api/teams');
        $index->assertStatus(Response::HTTP_UNAUTHORIZED);

        $index = $this->getJson('/api/teams/-1');
        $index->assertStatus(Response::HTTP_UNAUTHORIZED);

        $index = $this->patchJson('/api/teams/-1');
        $index->assertStatus(Response::HTTP_UNAUTHORIZED);

        $index = $this->deleteJson('/api/teams/-1');
        $index->assertStatus(Response::HTTP_UNAUTHORIZED);

    }


    /**
     * Create Team
     *
     * @param array $attributes
     * @return TeamResource
     */
    public function createTeam(array $attributes = [])
    {
        $team = factory(Team::class)->create($attributes);

        return new TeamResource($team);
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
