<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailBooking extends Mailable
{
    use Queueable, SerializesModels;

    public $concept;
    public $workDay;
    public $shift;
    public $price;
    public $deposit;

    public function setConcept($concept) {
        $this->concept = $concept;
    }

    public function setWorkDay($workDay) {
        $this->workDay = $workDay;
    }
    
    public function setShift($shift) {
        $this->shift = $shift;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setDeposit($deposit) {
        $this->deposit = $deposit;
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
            subject: '「4Views Studio」',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.mail-booking',
            with: [
                'concept' => $this->concept,
                'workDay' => $this->workDay,
                'shift' => $this->shift,
                'price' => $this->price,
                'deposit' => $this->deposit
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
