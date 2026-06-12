<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;

class FeedbackController extends Controller
{
    public function submit(Request $request): \Illuminate\Http\JsonResponse
    {
        $locale = $request->query('locale', 'en');
        $region = $request->query('region', 'sa');

        App::setLocale($locale);

        $validated = $request->validate([
            'selected' => 'required',
            'feedback' => 'required|string',
        ]);

        $adminEmails = [
            env('MAIL_ADMIN_ADDRESS', 'admin@example.com'),
            'easy@start-easy.com',
            'rm@start-easy.com',
        ];

        $subjectPrefix = $region === 'qa' ? '[Qatar Website] ' : '[Saudi Arabia Website] ';

        // Send email to admin using the dynamic locale
        Mail::send('emails.' . $locale . '.feedback', ['data' => $validated, 'region' => $region], function ($message) use ($adminEmails, $subjectPrefix) {
            $message->to($adminEmails)
                ->subject($subjectPrefix . 'New Feedback');
        });

        return response()->json(['success' => true]);
    }
}
