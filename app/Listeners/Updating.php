<?php

namespace App\Listeners;

class Updating
{

    /**
     * When the model is being updated.
     *
     * @param Illuminate\Database\Eloquent $model
     * @return void
     */
    public function handle($model)
    {
        if (! $model -> isUserstamping()) {
            return;
        }

        $model -> updated_by = auth() -> id();
    }
}
