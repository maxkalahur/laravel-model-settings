[![Latest Version on Packagist](https://img.shields.io/packagist/v/maxkalahur/laravel-model-settings.svg)](https://packagist.org/packages/maxkalahur/laravel-model-settings)
[![Run Tests](https://github.com/maxkalahur/laravel-model-settings/actions/workflows/run-tests.yml/badge.svg?branch=master)](https://github.com/maxkalahur/laravel-model-settings/actions/workflows/run-tests.yml)
[![Check & fix styling](https://github.com/maxkalahur/laravel-model-settings/actions/workflows/pint.yml/badge.svg?branch=master)](https://github.com/maxkalahur/laravel-model-settings/actions/workflows/pint.yml)

# laravel-model-settings
This Laravel package allows to: 
- **attach settings to Laravel Models** 
- **store model settings in DB** 
- **encrypt settings** in case of need with default Laravel's encryption via APP_KEY  

Data types that can be used in CustomSettings: 
- `bool`
- `int`
- `double`
- `string`
- `NULL`
- `array`

Laravel versions supported: 8+
## Instalation
```
composer require maxkalahur/laravel-model-settings

php artisan vendor:publish --provider="MaxKalahur\LaravelModelSettings\CustomSettingServiceProvider" --tag="migrations"
php artisan migrate
```
## Usage Instructions
Add Trait `HasCustomSettings` and an attribute `array $customSettings` to the Model.
```
use MaxKalahur\LaravelModelSettings\Traits\HasCustomSettings;

class DummyOrg extends Model
{
    use HasCustomSettings;
    ...
    private $customSettings = [
      'SECRET_KEY',
      'ADDRESS',
      'HAS_VISITS'
    ];
    
    // Using in query in scope
    public function scopeWithAddress($query)
    {
        return $query->whereHas('settings', function($q) {
            $q->where('key','ADDRESS')->whereNotNull('value');
        });
    }
}
```
**Methods of custom settings**:
- `setCustomSetting( string $key, $val, bool $is_encrypted)`
- `getCustomSetting( string $key )`
- `deleteCustomSetting( string $key )`
- `getAllCustomSettings()`
- `deleteAllCustomSettings()`
```
$org = DummyOrg::create();

$org->setCustomSetting('ADDRESS', 'Some address 59901 US'); 
$org->getCustomSetting('ADDRESS');            // Returns 'Some address 59901 US'

$org->setCustomSetting('SECRET_KEY', 'da39a3ee5e6b4b', true);   // Save with encription
$org->getCustomSetting('SECRET_KEY');         // returns 'da39a3ee5e6b4b'

$org->setCustomSetting('HAS_VISITS', true);
$org->getCustomSetting('HAS_VISITS');         // returns (bool) true

$org->setCustomSetting('HAS_VISITS', 'true');
$org->getCustomSetting('HAS_VISITS');         // returns (string) 'true'
$org->deleteCustomSetting('HAS_VISITS');
$org->getCustomSetting('HAS_VISITS');         // returns NULL

$org->getAllCustomSettings();                 // returns all settings as (array)
$org->deleteAllCustomSettings();              // deletes all settings from DB

// Using in scopes
DummyOrg::whereNotNull('name')
          ->orWhere
          ->withAddress();

```
**Eagier loading**
```
$org = DummyOrg::with('customSettings')->first();

foreach (range(1, 10) as $i) {
    $org->getCustomSetting('ADDRESS');   // no extra calls to DB
}
```
**Encription**: ENV `APP_KEY` is used for encryption, so please keep it safely.

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
