<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $proposalData;
    public string $pdfFilePath;
    public string $region;

    /**
     * Create a new message instance.
     *
     * @param array $proposalData The summary data for the email content.
     * @param string $pdfFilePath The full path to the generated PDF file.
     * @param string $locale The current locale.
     * @param string $region The current region.
     */
    public function __construct(array $proposalData, string $pdfFilePath, string $locale, string $region = 'sa')
    {
        $this->proposalData = $proposalData;
        $this->pdfFilePath = $pdfFilePath;
        $this->region = $region;

        $this->locale($locale);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Explicitly inject the Saudi Arabia Website tag to prevent admin confusion
        $subject = '[Saudi Arabia Website] ' . __('mail.admin_subject', [
                'name' => $this->proposalData['full_name'] ?? 'Unknown User'
            ]);

        return new Envelope(
            from: new Address(
                env('MAIL_FROM_ADDRESS', 'start@start-easy.com'),
                env('MAIL_FROM_NAME', 'Start Easy')
            ),
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'emails.' . $this->locale . '.admin_notification',
            with: [
                'proposalData' => $this->proposalData,
                'region' => $this->region,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        if (file_exists($this->pdfFilePath)) {
            return [
                Attachment::fromPath($this->pdfFilePath)
                    ->as('Your_Request_Summary.pdf')
                    ->withMime('application/pdf'),
            ];
        }
        return [];
    }
}
