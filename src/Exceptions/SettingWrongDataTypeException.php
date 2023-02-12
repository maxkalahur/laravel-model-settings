<?php

namespace MaxKalahur\LaravelModelSettings\Exceptions;

class SettingWrongDataTypeException extends SettingException
{
    protected $message = 'Settings has a wrong data type';
}
