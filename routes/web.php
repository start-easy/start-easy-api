<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionnaireController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/process-questionnaire', [QuestionnaireController::class, 'processQuestionnaire']);
