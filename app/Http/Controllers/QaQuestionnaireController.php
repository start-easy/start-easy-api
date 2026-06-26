<?php

namespace App\Http\Controllers;

use App\Helpers\ArabicTextHelper;
use App\Mail\QaProposalMail;
use App\Mail\QaAdminNotificationMail;
use App\Models\Questionnaire;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class QaQuestionnaireController extends Controller
{
    public function process(Request $request): JsonResponse
    {
        $locale = $request->query('locale', 'en');
        $region = $request->query('region', 'qa');
        App::setLocale($locale);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'businessActivity' => 'nullable|string|max:1000',
            'ownershipStructure' => 'nullable|string|max:255',
            'setupType' => 'nullable|string|max:255',
        ]);

        $pdfLabels = [
            'proposal_title' => __('qa/pdf.proposal_title'),
            'responses_title' => __('qa/pdf.responses_title'),
            'question_field' => __('qa/pdf.question_field'),
            'answer_field' => __('qa/pdf.answer_field'),
            'name' => __('qa/pdf.name'),
            'email' => __('qa/pdf.email'),
            'phone' => __('qa/pdf.phone'),
            'businessActivity' => __('qa/pdf.businessActivity'),
            'ownershipStructure' => __('qa/pdf.ownershipStructure'),
            'setupType' => __('qa/pdf.setupType'),
            'address_line_1' => __('qa/pdf.address_line_1'),
            'address_line_2' => __('qa/pdf.address_line_2'),
        ];

        $reshaper = new ArabicTextHelper();

        // Initialize PDF array with structural fields that are always required
        $pdfData = [
            ['label' => $pdfLabels['name'], 'value' => $validated['name']],
            ['label' => $pdfLabels['email'], 'value' => $validated['email']],
            ['label' => $pdfLabels['phone'], 'value' => $validated['phone']],
        ];

        // Safely append optional fields only if they are filled
        if (!empty($validated['ownershipStructure'])) {
            $pdfData[] = ['label' => $pdfLabels['ownershipStructure'], 'value' => $validated['ownershipStructure']];
        }

        if (!empty($validated['setupType'])) {
            $pdfData[] = ['label' => $pdfLabels['setupType'], 'value' => $validated['setupType']];
        }

        if (!empty($validated['businessActivity'])) {
            $pdfData[] = ['label' => $pdfLabels['businessActivity'], 'value' => $validated['businessActivity']];
        }

        $pdfData = $reshaper->reshape($pdfData);
        $pdfLabels = $reshaper->reshape($pdfLabels);

        $pdfFilePath = null;
        $logoPath = public_path('assets/mail/logo-white.png');

        try {
            $pdfDirectory = public_path('storage/proposals/qa');
            $fileName = 'proposal_qa_' . uniqid() . '.pdf';
            $pdfFilePath = $pdfDirectory . '/' . $fileName;

            if (!File::exists($pdfDirectory)) {
                File::makeDirectory($pdfDirectory, 0755, true);
            }

            $pdfView = "pdfs.qa.{$locale}.modal_proposal";

            $pdf = Pdf::loadView($pdfView, compact('pdfData', 'pdfLabels', 'logoPath'));
            $pdf->save($pdfFilePath);

        } catch (\Exception $e) {
            Log::error('Error generating QA proposal PDF: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate proposal PDF.', 'details' => $e->getMessage()], 500);
        }

        try {
            if (filter_var($validated['email'], FILTER_VALIDATE_EMAIL) && file_exists($pdfFilePath)) {
                Mail::to($validated['email'])->send(new QaProposalMail($validated, $pdfFilePath, $locale, $region));
                Log::info('QA User email sent successfully to: ' . $validated['email']);
            }
        } catch (\Exception $e) {
            Log::error('Error sending QA user email: ' . $e->getMessage());
        }

        try {
            $adminEmails = [
                env('MAIL_ADMIN_ADDRESS', 'admin@example.com'),
                'easy@start-easy.com',
                'rm@start-easy.com',
            ];

            if (file_exists($pdfFilePath)) {
                Mail::to($adminEmails)->send(new QaAdminNotificationMail($validated, $pdfFilePath, $locale, $region));
                Log::info('QA Admin email sent successfully.');
            }
        } catch (\Exception $e) {
            Log::error('Error sending QA admin email: ' . $e->getMessage());
        }

        try {
            Questionnaire::create([
                'region' => $region,
                'full_name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'answers' => $validated,
                'pdf_path' => $pdfFilePath ? str_replace(public_path(), '', $pdfFilePath) : null,
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving QA questionnaire to database: ' . $e->getMessage());
        }

        return response()->json(['message' => 'QA Questionnaire processed.']);
    }
}
