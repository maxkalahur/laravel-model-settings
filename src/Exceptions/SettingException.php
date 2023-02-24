<?php

namespace MaxKalahur\LaravelModelSettings\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;

class SettingException extends Exception
{
    protected Model $model;

    public function withModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the exception's context information.
     *
     * @return array
     */
    public function context()
    {
        return ['model' => $this->model];
    }
}
