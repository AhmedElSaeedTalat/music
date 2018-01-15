<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class acceptedVendors extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $secret;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($secret,$userName)
    {
        $this->secret = $secret;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('vendor.acceptedVendors')->attach('../images/location2.jpg');
;
    }
}
