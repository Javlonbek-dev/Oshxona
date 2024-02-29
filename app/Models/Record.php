<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $table = 'records';

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id', 'tabel');
    }
}
