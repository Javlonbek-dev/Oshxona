<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealSchedule extends Model
{

    protected  $fillable=[
        'meal_id',
        'date',
        'shift_id'
    ];

    public  function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id');
    }

    public  function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
