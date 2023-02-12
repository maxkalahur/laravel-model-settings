<?php

namespace MaxKalahur\LaravelModelSettings\Traits;

use MaxKalahur\LaravelModelSettings\Models\CustomSetting;
use Illuminate\Support\Facades\Crypt;
use MaxKalahur\LaravelModelSettings\Exceptions\{SettingKeyIsAbsentException,SettingWrongDataTypeException};

/**
 * This trait adds Settings to Models
 * Every Model has to have a property: private array $customSettings with all setting KEYs it can have
 */

trait HasCustomSettings
{
    public function customSettings()
    {
        return $this->morphMany(CustomSetting::class, 'model');
    }

    public function getCustomSetting( string $key )
    {
        if( !in_array( $key, $this->customSettings ) ) {
            throw (new SettingKeyIsAbsentException)->withModel($this);
        }

        $setting = null;

        // in case settings were eager loaded with `with()` previously, to prevent N+1 error
        if( $this->relationLoaded('customSettings') ) {
            $setting = $this->settings->firstWhere('key',$key);
        }

        if( !$setting ) {
            $setting = $this->customSettings()->firstWhere('key',$key);
        }

        if( $setting ) {

            $val = $setting->value;

            if( $val && $setting->is_encrypted ) {
                $val = Crypt::decryptString($val);
            }

            if( $setting->type == 'boolean' ) {
                return ($val == 'true') ? true : false;
            }
            settype( $val, $setting->type );

            return $val;
        }

        return null;
    }

    public function getAllCustomSettings(): Array
    {
        $res = [];

        if( $this->customSettings()->count() > 0 ) {
            $this->customSettings()->get()->each(function($setting) use(&$res) {
                $res[$setting->key] = $this->getCustomSetting($setting->key);
            });
        }

        return $res;
    }

    public function deleteCustomSetting( string $key ): bool
    {
        if( !in_array( $key, $this->customSettings ) ) {
            throw (new SettingKeyIsAbsentException)->withModel($this);
        }

        $result = $this->customSettings()->where('key',$key)->delete();

        return $result;
    }

    public function deleteAllCustomSettings(): bool
    {
        $result = $this->customSettings()->delete();

        return $result;
    }

    public function setCustomSetting( string $key, $value = null, bool $isEncrypted = false ): CustomSetting
    {
        $valueType = gettype($value);

        if( !in_array( $valueType, CustomSetting::DATA_TYPES ) ) {
            throw (new SettingWrongDataTypeException)->withModel($this);
        }

        if( !in_array( $key, $this->customSettings ) ) {
            throw (new SettingKeyIsAbsentException)->withModel($this);
        }

        if( $valueType == 'boolean' ) {
            $value = $value ? 'true' : 'false';
        }

        if( $isEncrypted && $value ) {
            $value = Crypt::encryptString($value);
        }

        $setting = $this->customSettings()->updateOrCreate(
            [
                'key' => $key,
            ],
            [
                'value' => $value,
                'is_encrypted' => $isEncrypted,
                'type' => $valueType,
            ]
        );

        return $setting;
    }
}
