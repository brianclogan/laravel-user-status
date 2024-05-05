<?php

namespace Workbench\App\Models;

use BrianLogan\LaravelUserStatus\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Workbench\Database\Factories\TestModelFactory;

class TestModel extends Model
{
    use HasFactory, HasStatus;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public static function newFactory(): TestModelFactory
    {
        return TestModelFactory::new();
    }
}
