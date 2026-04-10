<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class userEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $contant;
    public $view;
    /**
     * Create a new message instance.
     */
    public function __construct($contant, $view)
    {
       $this->contant = $contant;
       $this->view = $view;
    }



    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
       $view = 'livewire.email.'.$this->view;
        return new Content(
            view: $view,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
