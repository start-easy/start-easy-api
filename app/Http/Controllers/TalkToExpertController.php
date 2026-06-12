<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class TalkToExpertController extends Controller
{
    public function askQuestion(Request $request): \Illuminate\Http\JsonResponse
    {
        $locale = $request->query('locale', 'en');
        $region = $request->query('region', 'sa');

        App::setLocale($locale);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'question' => 'nullable|string',
        ]);

        $adminEmails = [
            env('MAIL_ADMIN_ADDRESS', 'admin@example.com'),
            'easy@start-easy.com',
            'rm@start-easy.com',
        ];

        $userView = 'emails.' . $locale . '.ask-question-user';
        $adminView = 'emails.' . $locale . '.ask-question-admin';

        $adminSubjectPrefix = $region === 'qa' ? '[Qatar Website] ' : '[Saudi Arabia Website] ';

        // Send confirmation email to user
        Mail::send($userView, ['data' => $validated, 'region' => $region], function ($message) use ($validated) {
            $message->to($validated['email'])
                ->subject(__('mail.ask_question_user_subject'));
        });

        // Send notification email to all admin addresses
        Mail::send($adminView, ['data' => $validated, 'region' => $region], function ($message) use ($validated, $adminEmails, $adminSubjectPrefix) {
            $message->to($adminEmails)
                ->subject($adminSubjectPrefix . __('mail.ask_question_admin_subject', ['name' => $validated['name']]));
        });

        return response()->json(['success' => true]);
    }

    public function requestCallBack(Request $request): \Illuminate\Http\JsonResponse
    {
        $locale = $request->query('locale', 'en');
        $region = $request->query('region', 'sa');

        App::setLocale($locale);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phoneOrEmail' => 'required|string|max:255',
            'communication' => 'required|string',
            'question' => 'nullable|string',
        ]);

        $adminEmails = [
            env('MAIL_ADMIN_ADDRESS', 'admin@example.com'),
            'easy@start-easy.com',
            'rm@start-easy.com',
        ];

        $userView = 'emails.' . $locale . '.request-callback-user';
        $adminView = 'emails.' . $locale . '.request-callback-admin';

        $adminSubjectPrefix = $region === 'qa' ? '[Qatar Website] ' : '[Saudi Arabia Website] ';

        // Send confirmation email to user if phoneOrEmail is a valid email address
        if (filter_var($validated['phoneOrEmail'], FILTER_VALIDATE_EMAIL)) {
            Mail::send($userView, ['data' => $validated, 'region' => $region], function ($message) use ($validated) {
                $message->to($validated['phoneOrEmail'])
                    ->subject(__('mail.callback_user_subject'));
            });
        }

        // Send notification email to all admin addresses
        Mail::send($adminView, ['data' => $validated, 'region' => $region], function ($message) use ($validated, $adminEmails, $adminSubjectPrefix) {
            $message->to($adminEmails)
                ->subject($adminSubjectPrefix . __('mail.callback_admin_subject', ['name' => $validated['name']]));
        });

        return response()->json(['success' => true]);
    }
}
