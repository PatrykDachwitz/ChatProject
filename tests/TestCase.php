<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, RefreshDatabase;

    protected function comparisonKeyWithModel(Model $model, array $keysSearch) {
        $issetKeys = [];
        foreach ($keysSearch ?? [] as $key) {
            if (isset ($model->$key)) array_push($issetKeys, $key);
        }

        return $issetKeys;
    }

}
