<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAllocation extends Model
{
    use HasFactory;
    protected $table = 'teacher_allocations';

    protected $fillable = [
        'class_id',
        'section_id',
        'teacher_id'
    ];
}
