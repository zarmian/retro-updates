<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Libraries\Customlib;

class EmailDailyActivity extends Mailable
{
    use Queueable, SerializesModels;

    public $custom;
    public $data;
    public $dd;
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

        $subject = 'Notice Board';

        $dd['temp'] = $this->data;
        return $this->view('email.dailyactivity', $dd)->subject($subject);
        //return $this->view('view.name');
    }
}
