<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QaProposalMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;
    public string $pdfFilePath;
    public string $region;

    public function __construct(array $data, string $pdfFilePath, string $locale, string $region = 'qa')
    {
        $this->data = $data;
        $this->pdfFilePath = $pdfFilePath;
        $this->region = $region;

        $this->locale($locale);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                env('MAIL_FROM_ADDRESS', 'easy@start-easy.com'),
                env('MAIL_FROM_NAME', 'Start Easy')
            ),
            subject: __('qa/mail.user_subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.qa.' . $this->locale . '.proposal',
            with: [
                'proposalData' => $this->data,
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
