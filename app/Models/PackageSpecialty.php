<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageSpecialty extends Model
{
    use HasFactory;
    
    public $table = 'package_specialty';
    public $timestamps = false;
}
