<?php

namespace Tests\Feature\Api\Message;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotAuthUserTest extends DefaultParametr
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('api.messages.index'));

        $response->assertStatus(302)
        ->assertRedirect(route('login'));
    }
    public function testShow()
    {
        $response = $this->get(route('api.messages.show', [
            'id' => 1
        ]));

        $response->assertStatus(302)
        ->assertRedirect(route('login'));
    }
    public function testUpdate()
    {
        $response = $this->put(route('api.messages.update', [
            'id' => 1
        ]), $this->correctData);

        $response->assertStatus(302)
        ->assertRedirect(route('login'));
    }
    public function testCreate()
    {
        $response = $this->post(route('api.messages.store'), $this->correctData);

        $response->assertStatus(302)
        ->assertRedirect(route('login'));
    }
}
