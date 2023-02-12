<?php

namespace MaxKalahur\LaravelModelSettings\Tests\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use MaxKalahur\LaravelModelSettings\Traits\HasCustomSettings;

class DummyUser extends Authenticatable
{
    use HasCustomSettings;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    private $customSettings = [
        0,1,2,3,4,5,"test1","test2","test3"
    ];
}
