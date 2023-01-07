<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportDay extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $title;
    public function __construct($title)
    {
        //
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $filename = date('d-m-Y',strtotime('-1 day',strtotime(date('d-m-Y')))) .'-report_day.pdf';
        return $this->from('myapp@demo.com')
        ->view('backend.statistic.mailDay',['title'=>$this->title])
        ->subject('Báo cáo ngày ' .date('d-m-Y',strtotime('-1 day',strtotime(date('d-m-Y')))))
        ->attach(public_path().'/report/' . $filename);
    }
}
