<?php

namespace App\Listeners;

class Deleting {

    /**
     * When the model is being deleted.
     *
     * @param Illuminate\Database\Eloquent $model
     * @return void
     */
    public function handle($model)
    {
        if (! $model -> isUserstamping()) {
            return;
        }

        if (is_null($model -> deleted_by)) {
            $model -> deleted_by = auth() -> id();
        }

        $model -> save();
    }
}
