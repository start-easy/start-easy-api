<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class QaAdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $proposalData;
    public string $pdfFilePath;
    public string $region;

    public function __construct(array $proposalData, string $pdfFilePath, string $locale, string $region = 'qa')
    {
        $this->proposalData = $proposalData;
        $this->pdfFilePath = $pdfFilePath;
        $this->region = $region;

        $this->locale($locale);
    }

    public function envelope(): Envelope
    {
        // Explicitly inject the Qatar Website tag to prevent admin confusion
        $subject = '[Qatar Website] ' . __('qa/mail.admin_subject', [
                'name' => $this->proposalData['name'] ?? 'Unknown User'
            ]);

        return new Envelope(
            from: new Address(
                env('MAIL_FROM_ADDRESS', 'easy@start-easy.com'),
                env('MAIL_FROM_NAME', 'Start Easy')
            ),
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.qa.' . $this->locale . '.admin_notification',
            with: [
                'proposalData' => $this->proposalData,
                'region' => $this->region,
            ],
        );
    }

    public function attachments(): array
    {
        if (file_exists($this->pdfFilePath)) {
            return [
                Attachment::fromPath($this->pdfFilePath)
                    ->as('Qatar_Setup_Proposal.pdf')
                    ->withMime('application/pdf'),
            ];
        }
        return [];
    }
}
