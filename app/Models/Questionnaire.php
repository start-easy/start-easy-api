<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $fillable = [
        'region',
        'full_name',
        'email',
        'phone',
        'name_en',
        'name_ar',
        'answers',
        'pdf_path',
    ];

    protected $casts = [
        'answers' => 'array',
    ];
}
