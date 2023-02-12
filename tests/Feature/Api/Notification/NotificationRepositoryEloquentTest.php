<?php
declare(strict_types=1);
namespace Tests\Feature\Api\Notification;

use App\Models\notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationRepositoryEloquentTest extends NotificationDefaultParametr
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $notification = $this->repository->create($this->correctData);

        $keysResult = $this->comparisonKeyWithModel($notification, $this->expectedKeys);

        $this->assertDatabaseHas('notifications', $this->correctData)
            ->assertEquals($this->expectedKeys, $keysResult);
    }

    public function testUpdate()
    {
        $this->repository->update($this->correctData, 1);

        $this->assertDatabaseHas('notifications', $this->correctData);
    }

    public function testfindByFilters() {
        $response = $this->repository->findByFilters([
            'message' => "Lorem ipsum",
            'sender_id' => 1,
            'recipient_id' => 2
        ]);

        $correctStructure = $this->comparisonKeyWithModel($response, $this->expectedKeys);

        $this->assertEquals($this->expectedKeys, $correctStructure);
    }

    public function testFind()
    {
        $notification = $this->repository->find(1);

        $keysResult = $this->comparisonKeyWithModel($notification, $this->expectedKeys);

        $this->assertEquals($this->expectedKeys, $keysResult);
    }

    public function testGet()
    {

        notification::factory()
            ->count(3)
            ->create([
                'sender_id' => 2,
                'recipient_id' => 40
            ]);

        User::factory()->create([
            'id' => 2
        ]);

        notification::factory()
            ->count(3)
            ->create([
                'recipient_id' => 2
            ]);

        $notification = $this->repository->get(40);

        $resultVerificationRecipient = $this->verificationRecipient(40, $notification);
        $resultVerificationSender = $this->compariseUser($notification, 2);

        $this->assertTrue($resultVerificationRecipient);
        $this->assertTrue($resultVerificationSender);
        $this->assertCount(3, $notification);
    }

    public function testDelete()
    {
        $this->repository->destroy(1);

        $this->assertDatabaseMissing('notifications', [
            'id' => 1
        ]);
    }
}
