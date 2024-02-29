<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'begin_date',
        'end_date',
    ];

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

}
