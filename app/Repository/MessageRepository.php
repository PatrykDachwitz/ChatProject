<?php
declare(strict_types=1);
namespace App\Repository;

interface MessageRepository
{
    public function get(int $id);
    public function find(int $id);
    public function create(array $data);
    public function update(array $data, int $id);
}