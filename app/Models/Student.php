<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public function state()
    {
        return $this->belongsTo(State::class, 'state');
    }

    /**
     * Get the city associated with the student.
     */
    public function city()
    {
        return $this->belongsTo(City::class,'city');
    }
}
