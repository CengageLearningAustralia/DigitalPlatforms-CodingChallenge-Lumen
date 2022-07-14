<?php

use App\Models\Book;
use App\Models\Session;
use App\Models\User;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use Illuminate\Http\Response;

class SessionTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_sessions_exist_for_a_user()
    {
        $this->actingAs(User::whereHas('sessions')->inRandomOrder()->first());
        $this->get("/sessions/index");
        $this->assertResponseOk();
        $this->response->assertJsonStructure(['data' => [0 => ['id']]]);
        $this->response->assertJsonStructure(['meta']);
    }

    /**
     *
     * @return void
     */
    public function test_sessions_only_future_sessions_returned()
    {
        $user = User::whereHas('sessions')->inRandomOrder()->first();
        $this->actingAs($user);
        $this->get("/sessions/index?filters[includePastSessions]=false");
        $filters = ['includePastSessions' => "false"];
        $sessionsBuilder = app(SessionRepositoryInterface::class)->getByUserId($user->id, [], $filters);
        $this->assertResponseOk();
        $this->response->assertJsonCount($sessionsBuilder->count(), 'data');
        $this->response->assertJsonStructure(['data' => [0 => ['id']]]);
        $this->response->assertJsonStructure(['meta']);
    }

    /**
     *
     * @return void
     */
    public function test_sessions_all_sessions_returned()
    {
        $user = User::whereHas('sessions')->inRandomOrder()->first();
        $this->actingAs($user);
        $this->get("/sessions/index?filters[includePastSessions]=true");
        $filters = ['includePastSessions' => "true"];
        $sessionsBuilder = app(SessionRepositoryInterface::class)->getByUserId($user->id, [], $filters);
        $this->assertResponseOk();
        $this->response->assertJsonCount($sessionsBuilder->count(), 'data');
        $this->response->assertJsonStructure(['data' => [0 => ['id']]]);
        $this->response->assertJsonStructure(['meta']);
    }

    /**
     *
     * @return void
     */
    public function test_sessions_doesnt_exist_for_a_user()
    {
        $this->actingAs(User::whereDoesntHave('sessions')->inRandomOrder()->first());
        $this->get("/sessions/index");
        $this->assertResponseOk();
        $this->response->assertJsonStructure(['data']);
    }

    /**
     *
     * @return void
     */
    public function test_show()
    {
        $user = User::whereHas('sessions')->inRandomOrder()->first();
        $this->actingAs($user);
        $session = Session::where('user_id', $user->id)->inRandomOrder()->first();

        $this->get("/sessions/{$session->id}/show");

        $this->assertResponseOk();
        $this->response->assertJsonPath('id', $session->id);
        $this->response->assertJsonPath('name', $session->name);
    }

    /**
     *
     * @return void
     */
    public function test_expected_forbidden_exception()
    {
        $user = User::inRandomOrder()->first();
        $this->actingAs($user);
        $session = Session::where('user_id', '!=', $user->id)->inRandomOrder()->first();

        $res = $this->get("/sessions/{$session->id}/show");

        $res->assertResponseStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_expected_not_found_exception()
    {
        $this->actingAs(User::inRandomOrder()->first());

        $this->get("/sessions/0000/show");

        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     *
     * @return void
     */
    public function test_create_successfully()
    {
        $this->actingAs(User::inRandomOrder()->first());
        $this->post('/sessions/create',
            Session::factory()->make()->toArray()
        );

        $this->assertResponseOk();
    }

    /**
     *
     * @return void
     */
    public function test_validation_exception_on_create()
    {
        $this->actingAs(User::inRandomOrder()->first());
        $this->post('/sessions/create',
            []
        );
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->response->assertJsonStructure(['errors']);
    }

    /**
     *
     * @return void
     */
    public function test_book_assignment_to_session()
    {
        $this->actingAs(User::inRandomOrder()->first());
        $session = Session::inRandomOrder()->first();
        $book = Book::inRandomOrder()->first();
        $this->put("/sessions/{$session->id}/assign/{$book->id}");

        $this->assertResponseOk();
    }

    /**
     *
     * @return void
     */
    public function test_not_found_exception_expected()
    {
        $this->actingAs(User::inRandomOrder()->first());
        $book = Book::inRandomOrder()->first();
        $this->put("/sessions/000/assign/{$book->id}");

        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }
}
