<?php

namespace App\Listeners;

class Creating
{

    /**
     * When the model is being created.
     *
     * @param Illuminate\Database\Eloquent $model
     * @return void
     */
    public function handle($model)
    {
        if (! $model -> isUserstamping()) {
            return;
        }

        if (is_null($model -> created_by)) {
            $model -> created_by = auth() -> id();
        }

        if (is_null($model -> updated_by)) {
            $model -> updated_by = auth() -> id();
        }
    }
}
