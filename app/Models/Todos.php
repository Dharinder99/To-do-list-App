<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todos extends Model

{
    protected $table = 'todos';
    protected $fillable = ['title', 'status'];

    use HasFactory;
}
