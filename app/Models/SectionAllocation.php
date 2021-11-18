<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionAllocation extends Model
{
    use HasFactory;

    protected $table = 'sections_allocations';

    protected $fillable = [
        'class_id',
        'section_id'
    ];
}
