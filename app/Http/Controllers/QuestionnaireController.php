<?php

namespace App\Http\Controllers;

use App\Helpers\ArabicTextHelper;
use App\Mail\ProposalMail;
use App\Mail\AdminNotificationMail;
use App\Models\Questionnaire;
use App\Services\QuestionnaireService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class QuestionnaireController extends Controller
{
    protected QuestionnaireService $questionnaireService;

    public function __construct(QuestionnaireService $questionnaireService)
    {
        $this->questionnaireService = $questionnaireService;
    }

    /**
     * Processes the incoming questionnaire data, sends emails, and generates a PDF.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function processQuestionnaire(Request $request): JsonResponse
    {
        $locale = $request->query('locale', 'en');
        $region = $request->query('region', 'sa');
        App::setLocale($locale);

        $rawAnswers = $request->json()->all();
        $processedData = $this->questionnaireService->processAnswers($rawAnswers, $locale);

        $pdfData = $processedData['processed_data_for_pdf'];
        $emailData = $processedData['email_data_summary'];

        // Get the raw (un-reshaped) label for step2_1
        $sectorQuestionLabel_raw = $this->questionnaireService->getStepTitle('step2_1', $locale);

        $pdfLabels = [
            'proposal_title' => __('pdf.proposal_title'),
            'responses_title' => __('pdf.responses_title'),
            'question_field' => __('pdf.question_field'),
            'answer_field' => __('pdf.answer_field'),
            'name' => __('pdf.name'),
            'email' => __('pdf.email'),
            'phone' => __('pdf.phone'),
            'trade_name_en' => __('pdf.trade_name_en'),
            'trade_name_ar' => __('pdf.trade_name_ar'),
            'special_requests' => __('pdf.special_requests'),
            'address_line_1' => __('pdf.address_line_1'),
            'address_line_2' => __('pdf.address_line_2'),
            // Pass the raw label for reshaping
            'sector_question_label' => $sectorQuestionLabel_raw,
        ];

        $reshaper = new ArabicTextHelper();

        $pdfData = $reshaper->reshape($pdfData);
        $emailData = $reshaper->reshape($emailData);
        $pdfLabels = $reshaper->reshape($pdfLabels);

        // Get the *reshaped* label to find the correct item
        $reshapedSectorLabel = $pdfLabels['sector_question_label'];
        $sectorData = null;

        foreach ($pdfData as $index => $item) {
            if (isset($item['label']) && $item['label'] === $reshapedSectorLabel) {
                $sectorData = $item; // Copy the sector data
                unset($pdfData[$index]); // Remove it from the main PDF data array
                break;
            }
        }

        // Re-index the array to prevent issues after unsetting
        $pdfData = array_values($pdfData);

        $pdfFilePath = null;
        $logoPath = public_path('assets/mail/logo-white.png');

        try {
            $pdfDirectory = public_path('storage/proposals');
            $fileName = 'proposal_' . uniqid() . '.pdf';
            $pdfFilePath = $pdfDirectory . '/' . $fileName;

            if (!File::exists($pdfDirectory)) {
                File::makeDirectory($pdfDirectory, 0755, true);
            }

            $pdfView = "pdfs.{$locale}.proposal";

            $pdf = Pdf::loadView($pdfView, compact('pdfData', 'emailData', 'pdfLabels', 'logoPath', 'sectorData'));
            $pdf->save($pdfFilePath);

        } catch (\Exception $e) {
            Log::error('Error generating proposal PDF: ' . (string) $e);
            return response()->json(['error' => 'Failed to generate proposal PDF.', 'details' => $e->getMessage()], 500);
        }

        try {
            if (isset($emailData['email']) && filter_var($emailData['email'], FILTER_VALIDATE_EMAIL)) {
                if ($pdfFilePath && file_exists($pdfFilePath)) {
                    Mail::to($emailData['email'])->send(new ProposalMail($emailData, $pdfFilePath, $locale, $region));
                }
                Log::info('User "Thank You" email sent successfully to: ' . $emailData['email']);
            } else {
                Log::warning('User email address not found or invalid for sending "Thank You" email.');
            }
        } catch (\Exception $e) {
            Log::error('Error sending user "Thank You" email: ' . $e->getMessage());
        }

        try {
            $adminEmails = [
                env('MAIL_ADMIN_ADDRESS', 'admin@example.com'),
                'easy@start-easy.com',
                'rm@start-easy.com',
            ];

            if ($pdfFilePath && file_exists($pdfFilePath)) {
                Mail::to($adminEmails)
                    ->send(new AdminNotificationMail($emailData, $pdfFilePath, $locale, $region));

                Log::info('Admin notification email with PDF sent successfully to: ' . implode(', ', $adminEmails));
            } else {
                Log::warning('PDF file not found for admin email attachment: ' . $pdfFilePath);
            }
        } catch (\Exception $e) {
            Log::error('Error sending admin notification email: ' . $e->getMessage());
        }

        try {
            Questionnaire::create([
                'region' => $region,
                'full_name' => $emailData['full_name'] ?? null,
                'email' => $emailData['email'] ?? null,
                'phone' => $emailData['phone'] ?? null,
                'name_en' => $emailData['name_en'] ?? null,
                'name_ar' => $emailData['name_ar'] ?? null,
                'answers' => $rawAnswers,
                'pdf_path' => $pdfFilePath ? str_replace(public_path(), '', $pdfFilePath) : null,
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving questionnaire to database: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Questionnaire processed.',
        ]);
    }
}
