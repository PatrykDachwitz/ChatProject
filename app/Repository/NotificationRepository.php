<?php
declare(strict_types=1);
namespace App\Repository;

interface NotificationRepository
{
    public function create(array $data);
    public function find(int $id);
    public function destroy(int $id);
    public function update(array $data, int $id);
    public function get(int $id);
}