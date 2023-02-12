# laravel-model-settings
This Laravel package allows you to attach settings to Laravel Models, save them in DB and encrypt.  
Data types that can be used in CustomSettings: 
- boolean
- integer
- double
- string
- NULL

Laravel versions supported: 7,8,9.
## Usage Instructions
Add Trait `HasCustomSettings` and `private array $customSettings` to the Model.
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
Methods of custom settings.
```
$org = DummyOrg::create();

$org->setCustomSetting('ADDRESS', '34 N Somers Road, Kalispell, MT, 59901 US');  // Returns `\MaxKalahur\LaravelModelSettings\Models\CustomSetting`
$org->getCustomSetting('ADDRESS');            // Returns '34 N Somers Road, Kalispell, MT, 59901 US'

$org->setCustomSetting('SECRET_KEY', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', true);   // Setting 'SECRET_KEY' is saved with Laravel's encryption
$org->getCustomSetting('SECRET_KEY');         // returns 'da39a3ee5e6b4b0d3255bfef95601890afd80709'

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
Eagier loading
```
$org = DummyOrg::with('customSettings')->first();

foreach (range(1, 10) as $i) {
    $org->getCustomSetting('ADDRESS');   // no calls to DB
}
```
