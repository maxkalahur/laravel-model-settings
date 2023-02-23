<?php

namespace MaxKalahur\LaravelModelSettings\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use MaxKalahur\LaravelModelSettings\Traits\HasCustomSettings;

class DummyUser extends Model
{
    use HasCustomSettings;

    protected $table = 'test_users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    private $customSettings = [
        0,1,2,3,4,5,"test1","test2","test3"
    ];
}
