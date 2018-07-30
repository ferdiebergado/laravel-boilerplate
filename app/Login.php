<?php

namespace App;

use App\BaseModel;

class Login extends BaseModel
{
    protected $userstamping = false;
    protected $dates = [
        'date_created'
    ];
    protected $appends = [
        'date_created'
    ];
    protected $searchable = [
        'user.name',
        'user_agent'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getDateCreatedAttribute()
    {
        if (!empty($this->created_at)) {
            $created = $this->created_at;
            return $created->diffForHumans() . ' ' . $created;
        }
        return $this;
    }
}
