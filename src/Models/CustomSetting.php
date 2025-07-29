<?php

namespace MaxKalahur\LaravelModelSettings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * DON'T USE THIS MODEL DIRECTLY!
 * TO ADD SETTINGS TO SOME MODEL USE TRAIT "MaxKalahur\LaravelModelSettings\Traits\HasSettings"
 */
class CustomSetting extends Model
{
    use HasFactory;

    const DATA_TYPES = ['boolean', 'integer', 'double', 'string', 'NULL', 'array'];

    private $modelId;

    private $modelType;

    protected $table = 'settings';

    protected $fillable = [
        'type',
        'key',
        'model_id',
        'model_type',
        'value',
        'is_encrypted',
    ];

    public function model()
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id');
    }
}
