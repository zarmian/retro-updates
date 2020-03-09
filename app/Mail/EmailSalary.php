<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Libraries\Customlib;

class EmailSalary extends Mailable
{

    public $custom;
    public $array;
    public $dd;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($array = [])
    {
        $this->custom = new Customlib();
        $this->data = $array;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Email Salary';

        $dd['temp'] = $this->data;
        return $this->view('email.salary', $dd)->subject($subject);
    }
}
