<?php

namespace Tests\Feature;

use App\Project;
use Carbon\Carbon;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_list_of_projects_can_be_fetched_for_the_authenticated_user()
    {
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $project = factory(Project::class)->create(['user_id' => $user->id]);
        $anotherUser = factory(Project::class)->create(['user_id' => $anotherUser->id]);

        $response = $this->get('/api/projects?api_token=' . $user->api_token);


        $response->assertJsonCount(1)
            ->assertJson([
                'data'  => [
                    [
                        'data'  => [
                            'project_id' => $project->id
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function an_unauthenticated_user_should_redirected_to_login()
    {
        $response = $this->post('api/projects',
            array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Project::all());
    }

    /** @test */
    public function an_authenticated_user_can_add_a_project()
    {

        $response = $this->post('/api/projects', $this->data());

        $project = Project::first();

        $this->assertEquals('Test Name', $project->name);
        $this->assertEquals('Test Company', $project->company);
        $this->assertEquals('Test Location', $project->location);
        $this->assertEquals('Test Description', $project->description);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'project_id' => $project->id,
            ],
            'links' => [
                'self' => $project->path(),
            ]
        ]);
    }

    /** @test */
    public function fields_are_required()
    {
        collect(['name', 'company', 'location', 'description'])
            ->each(function ($field) {
                $response = $this->post('/api/projects',
                    array_merge($this->data(), [$field => '']));

                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Project::all());
            });
    }

    /** @test */
    public function a_project_can_be_retrieved()
    {
        $project = factory(Project::class)->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/projects/' . $project->id . '?api_token=' . $this->user->api_token);

        $response->assertJson([
            'data' => [
                'project_id' => $project->id,
                'name' => $project->name,
                'company' => $project->company,
                'location' => $project->location,
                'description' => $project->description,
                'last_updated' => $project->updated_at->diffForHumans(),
            ]
        ]);
    }

    /** @test */
    public function only_the_users_projects_can_be_retrieved()
    {
        $project = factory(Project::class)->create(['user_id' => $this->user->id]);

        $anotherUser = factory(User::class)->create();

        $response = $this->get('/api/projects/' . $project->id . '?api_token=' . $anotherUser->api_token);

        $response->assertStatus(403);
    }

    /** @test */
    public function a_project_can_be_patched()
    {
        $project = factory(Project::class)->create(['user_id' => $this->user->id]);

        $response = $this->patch('/api/project/' . $project->id, $this->data());

        $project = $project->fresh();

        $this->assertEquals('Test Name', $project->name);
        $this->assertEquals('Test Company', $project->company);
        $this->assertEquals('Test Location', $project->location);
        $this->assertEquals('Test Description', $project->description);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'project_id' => $project->id,
            ],
            'links' => [
                'self' => $project->path(),
            ]
        ]);
    }

    /** @test */
    public function only_the_owner_of_the_project_can_patch_the_project()
    {
        $project = factory(Project::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->patch('/api/project/' . $project->id,
            array_merge($this->data(), ['api_token' => $anotherUser->api_token]));

        $response->assertStatus(403);
    }

    /** @test */
    public function a_project_can_be_deleted()
    {
        $project = factory(Project::class)->create(['user_id' => $this->user->id]);

        $response = $this->delete('/api/project/' . $project->id,
            ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Project::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function only_the_owner_can_delete_the_project()
    {
        $project = factory(Project::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->delete('/api/project/' . $project->id,
            ['api_token' => $this->user->api_token]);

        $response->assertStatus(403);
    }

    private function data()
    {
        return [
            'name' => 'Test Name',
            'location' => 'Test Location',
            'description' => 'Test Description',
            'company' => 'Test Company',
            'api_token' => $this->user->api_token,
        ];
    }

}
