<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportTime extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $title;
    public $fileName;
    public function __construct($title,$fileName)
    {
        //
        $this->title = $title;
        $this->fileName = $fileName;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('myapp@demo.com')
        ->view('backend.statistic.mailDay',['title'=>$this->title])
        ->subject($this->title)
        ->attach(public_path().'/report/' . $this->fileName);
    }
}
