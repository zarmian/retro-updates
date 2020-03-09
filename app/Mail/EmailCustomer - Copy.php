<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Libraries\Customlib;

class EmailEmployee extends Mailable
{

    public $custom;
    public $data;
    public $dd;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = [])
    {
        $this->custom = new Customlib();
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $subject = 'New Employee Create';

        $dd['temp'] = $this->data;
        return $this->view('email.customer', $dd)->subject($subject);
    }
}
