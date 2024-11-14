<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $data;
    public $user;

    //menginisialisasi objek yang digunakan pada template email
    // public function __construct(array $data)
    // {
    //     $this->data = $data;
    // }

    public function __construct($user)
    {
        $this->user = $user;
    }

    //mengatur struktur email yang lebih spesifik
    public function build()
    {
        return $this->subject('Selamat, Pendaftaran Berhasil!')
                    ->view('emails.viewemail');
        // return $this->subject($this->data['subject'])
        //     ->view('emails.sendemail');
    }


    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Send Email',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.sendemail',
    //     );
    // }

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
