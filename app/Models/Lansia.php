<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lansia extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'age', 'blood_pressure', 'health_status'];
}
