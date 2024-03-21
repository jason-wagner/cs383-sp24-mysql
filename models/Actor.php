<?php

namespace Sakila\Model;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function films()
    {
        return $this->belongsToMany(Film::class, 'actor_film', 'actor_id', 'film_id');
    }
}