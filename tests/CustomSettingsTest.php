<?php

namespace MaxKalahur\LaravelModelSettings\Tests;

use Illuminate\Database\Eloquent\Model;
use MaxKalahur\LaravelModelSettings\Tests\Models\DummyUser;

class CustomSettingsTest extends TestCase
{
    private $settingsTetsData;

    private Model $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->settingsTetsData = [
            ['boolean',   true],
            ['boolean',   false],
            ['integer',   123],
            ['double',    123.123],
            ['string',    'test test'],
            ['NULL',      null],
            ['array',      [1, 'Max', null, false, '3']],
        ];

        $this->model = DummyUser::create([
            'name' => 'Test',
            'email' => 'test@test.com',
        ]);
    }

    public function test_settings_fill_and_delete()
    {
        foreach ($this->settingsTetsData as $key => $valArr) {
            [$type,$val] = $valArr;

            $settingsObj = $this->model->setCustomSetting($key, $val);

            $this->assertEquals($type, $settingsObj->type);
            $this->assertEquals($key, $settingsObj->key);
            $this->assertEquals($this->model->id, $settingsObj->model_id);
            $this->assertEquals(get_class($this->model), $settingsObj->model_type);

            $settingsVal = $this->model->getCustomSetting($key);
            $this->assertEquals($val, $settingsVal);
            $this->assertEquals($type, gettype($settingsVal));

            $this->assertEquals(true, $this->model->deleteCustomSetting($key));
            $this->assertEquals(null, $this->model->deleteCustomSetting($key));
        }
    }

    public function test_settings_fill_encrypted()
    {
        foreach ($this->settingsTetsData as $key => $valArr) {
            [$type,$val] = $valArr;

            $settingsObj = $this->model->setCustomSetting($key, $val, true);

            $this->assertEquals($type, $settingsObj->type);
            $this->assertEquals($key, $settingsObj->key);
            $this->assertEquals($this->model->id, $settingsObj->model_id);
            $this->assertEquals(get_class($this->model), $settingsObj->model_type);

            $settingsVal = $this->model->getCustomSetting($key);
            $this->assertEquals($val, $settingsVal);
            $this->assertEquals($type, gettype($settingsVal));
        }
    }

    public function test_settings_get_all()
    {
        $testArr = [
            'test1' => true,
            'test2' => 123,
            'test3' => '123',
        ];
        array_walk($testArr, fn ($val, $key) => $this->model->setCustomSetting($key, $val));
        $this->assertEquals($testArr, $this->model->getAllCustomSettings());
    }

    public function test_settings_wrong_type_array_exception()
    {
        $this->expectException(\Exception::class);
        $this->model->setCustomSetting('test1', []);
    }

    public function test_settings_wrong_type_object_exception()
    {
        $this->expectException(\Exception::class);
        $this->model->setCustomSetting('test2', new \stdClass);
    }
}
