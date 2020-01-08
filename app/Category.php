<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function users()
    {
        return $this->belongsToMany(\App\User::class, 'users_categories_pivot')->withPivot('description')->withTimestamps();
    }
    public function groups()
    {
        return $this->belongsToMany(\App\Group::class, 'groups_categories_pivot')->withTimestamps();
    }
}
