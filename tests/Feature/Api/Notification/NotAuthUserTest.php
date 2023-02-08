<?php
declare(strict_types=1);
namespace Tests\Feature\Api\Notification;

class NotAuthUserTest extends DefaultParametr
{

    public function testIndex() {
        $response = $this->get(route('api.notifications.index'));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }
    public function testShow() {
        $response = $this->get(route('api.notifications.show', [
            'id' => 1
        ]));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }
    public function testCreate() {
        $response = $this->post(route('api.notifications.store'), $this->correctData);

        $this->assertDatabaseMissing('notifications', $this->correctData);

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }
    public function testUpdate() {
        $response = $this->put(route('api.notifications.update', [
            'id' => 1
        ]), $this->correctData);

        $this->assertDatabaseMissing('notifications', $this->correctData);

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function testDelete() {
        $response = $this->delete(route('api.notifications.destroy', [
            'id' => 1
        ]));

        $this->assertDatabaseHas('notifications', [
            'id' => 1
        ]);

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

}