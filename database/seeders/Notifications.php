<?php
declare(strict_types=1);
namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Notifications extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $factory = Factory::create();
        $data = [];
        for ($i = 1; $i <= 13; $i++) {
            for ($j = 1; $j <= 15; $j++) {
                if ($i === $j) continue;
                $data[] = [
                    'message' => $factory->realText(255),
                    'sender_id' => $i,
                    'recipient_id' => $j,
                ];
            }
        }

        DB::table('notifications')
            ->insertOrIgnore($data);
    }
}
