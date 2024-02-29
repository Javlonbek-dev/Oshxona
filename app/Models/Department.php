<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name'
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function admin()
    {
        return $this->hasOne(User::class);
    }
}
