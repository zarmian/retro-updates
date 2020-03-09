<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Libraries\Customlib;

class EmailOfficialLeaves extends Mailable
{
    use Queueable, SerializesModels;

    public $custom;
    public $content;
    public $dd;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content = '', $data = [])
    {
        $this->custom = new Customlib();
        $this->content = $content;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Official Leave '.$this->data['title'];

        $dd['temp'] = $this->content;
        return $this->view('email.officialleaves', $dd)->subject($subject);
    }
}
