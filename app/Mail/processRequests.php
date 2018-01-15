<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class processRequests extends Mailable
{
    use Queueable, SerializesModels;

    public $requestType;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($requestType,$email)
    {
        $this->requestType =  $requestType ;
        $this->email = $email ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('vendor.processRequestsMail')->subject("you have been $this->requestType");
    }
}
