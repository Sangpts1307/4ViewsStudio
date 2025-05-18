<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailLinkImage extends Mailable
{
    use Queueable, SerializesModels;

    public $staff;
    public $concept;
    public $workDay;
    public $shift;
    public $linkImage;
    public $reply;

    public function setStaff($staff) {
        $this->staff = $staff;
    }

    public function setConcept($concept) {
        $this->concept = $concept;
    }

    public function setWorkDay($workDay) {
        $this->workDay = $workDay;
    }
    
    public function setShift($shift) {
        $this->shift = $shift;
    }

    public function setLinkImage($linkImage) {
        $this->linkImage = $linkImage;
    }

    public function setMessage($reply) {
        $this->reply = $reply;
    }

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '4Views Studio',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.link-image',
            with: [
                'staff' => $this->staff,
                'concept' => $this->concept,
                'workDay' => $this->workDay,
                'shift' => $this->shift,
                'linkImage' => $this->linkImage,
                'message' => $this->reply
            ]
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
