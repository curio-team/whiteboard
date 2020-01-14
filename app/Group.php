<?php

namespace App;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use Notifiable;

    public function Categories()
    {
        
        return $this->belongsToMany(\App\Category::class, 'groups_categories_pivot')->withTimestamps();
    }
}
