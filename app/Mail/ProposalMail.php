<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProposalMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;
    public string $pdfFilePath;
    public string $region;

    /**
     * Create a new message instance.
     * @param array $data The summary data for the email content.
     * @param string $pdfFilePath The full path to the generated PDF file.
     * @param string $locale The current locale.
     * @param string $region The current region.
     */
    public function __construct(array $data, string $pdfFilePath, string $locale, string $region = 'sa')
    {
        $this->data = $data;
        $this->pdfFilePath = $pdfFilePath;
        $this->region = $region;

        $this->locale($locale);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                env('MAIL_FROM_ADDRESS', 'start@start-easy.com'),
                env('MAIL_FROM_NAME', 'Start Easy')
            ),
            subject: __('mail.user_subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'emails.' . $this->locale . '.proposal',
            with: [
                'proposalData' => $this->data,
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
