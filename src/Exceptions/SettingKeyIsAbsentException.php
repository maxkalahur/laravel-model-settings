<?php

namespace MaxKalahur\LaravelModelSettings\Exceptions;

class SettingKeyIsAbsentException extends SettingException
{
    protected $message = 'Setting Key is absent in the Model\'s property $customSettings';
}
