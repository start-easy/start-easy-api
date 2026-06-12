<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QaQuestionnaireController;
use App\Http\Controllers\TalkToExpertController;
use Illuminate\Support\Facades\Route;

// Existing Saudi endpoint
Route::post('/process-questionnaire', [QuestionnaireController::class, 'processQuestionnaire']);

// New Isolated Qatar endpoint
Route::post('/qa/get-started', [QaQuestionnaireController::class, 'process']);

// Shared endpoints
Route::post('/ask-question', [TalkToExpertController::class, 'askQuestion']);
Route::post('/request-callback', [TalkToExpertController::class, 'requestCallBack']);
Route::post('/feedback', [FeedbackController::class, 'submit']);

Route::get('/preview-mail', function () {
    return view('emails.feedback', ['data' => [
        'selected' => 1,
        'feedback' => "I need assistance with setting up my business registration.\n" .
            "Could you please provide information about required documentation?\n" .
            "What are the estimated timeframes for the registration process?\n" .
            "Are there any specific requirements for foreign investors?\n" .
            "What are the associated costs and fees for business registration?",
    ]]);
});
