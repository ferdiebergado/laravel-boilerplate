<?php

namespace App;

use App\BaseModel;

class Login extends BaseModel
{
    protected $userstamping = false;

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
        $created = $this->created_at;
        return $created->diffForHumans() . ' ' . $created;
    }
}
