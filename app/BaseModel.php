<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Userstamps;

abstract class BaseModel extends Model
{
    use Cachable, SoftDeletes, Userstamps;

    protected $dates = [
        'deleted_at'
    ];

    /**
     * The searchable attributes of the Model
     *
     * @var array
     */
    protected $searchable = [];

    /**
     * Set the value of searchable
     *
     * @return  self
     */
    public function setSearchable($searchable)
    {
        $this->searchable = $searchable;
    }

    /**
     * Get the value of searchable
     */
    public function getSearchable()
    {
        return $this->searchable;
    }
}
