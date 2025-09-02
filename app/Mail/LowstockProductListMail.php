<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowstockProductListMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;

    public function __construct($pdfContent)
    {
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Low Stock / Out of Stock Products Notification')
            ->view('emails.products.low-stock')
            ->attachData($this->pdfContent, 'Products-list.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
