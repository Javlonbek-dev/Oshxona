<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'quantity',
        'department_id',
        'shift_id',
        'created_by',
        'updated_by',
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
