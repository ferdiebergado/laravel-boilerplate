<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

abstract class BasePivot extends Pivot
{
    use Cachable;
}
