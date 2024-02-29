<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'tabel',
        'mobile_number',
        'pnfl',
        'department_id',
        'position_id',
        'created_at',
        'updated_at'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function getFullNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name;
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function records()
    {
        return $this->setConnection('pgsql')->hasMany(Record::class, 'user_id', 'tabel');
    }
}
