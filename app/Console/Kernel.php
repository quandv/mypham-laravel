<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Mail\ReportDay;
use Mail;
use Illuminate\Mail\Mailer;
use App\Models\Backend\Statistic;
use SPDF;
use DateTime;
use DateInterval;
use Config;
use File;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*
            crontab -e : Create new cron table : * * * * * /usr/bin/php /var/www/html/dv.gengargaming.vn/artisan schedule:run 1>> /dev/null 2>&1
            crontab -l : List cron table
            crontab -r :  Remove cron table and all scheduled jobs
        */
        // $schedule->command('inspire')
        //          ->hourly();

       /*$schedule->call(function () {
            $data =['name'=>'kkk111111111111'];
             Mail::send(['text'=>'mail'],$data,function($message){
                $message->to('hoangkhoik5@gmail.com','hello ')->subject('Send mail from Laravel with Basic');
                $message->from('hello@app.com', 'Your Application');       
            });*/
        //echo 'Basic Email was sent';
        $schedule->call(function () { 
            $recent_day = DateTime::createFromFormat('d-m-Y', date('d-m-Y'))->sub(new DateInterval('P1D'))->format('Y-m-d'); 
            $newday = DateTime::createFromFormat('d-m-Y', date('d-m-Y'))->format('Y-m-d');
            $schedule = Statistic::getAllSchedule();
            $startCa1 = $schedule[0]->time_start;
            $endCa3 = $schedule[count($schedule)-1]->time_end;
            $fromCase = $recent_day.' '.$startCa1;
            $toCase = $newday.' '.$endCa3;
            $dataResult = Statistic::listDayOrder($recent_day, $fromCase , $toCase,0,'print');
            if( $dataResult['status'] ){
                    $data['status'] = true;
                    $data['day'] = date('d-m-Y',strtotime('-1 day',strtotime(date('d-m-Y'))));
                    $data['data'] = $dataResult['data'];
                    $data['sumTotalAll'] = $dataResult['sumTotalAll'];
                    $data['sumCountAll'] = $dataResult['sumCountAll'];
                    $data['sumCountSuccess'] = $dataResult['sumCountSuccess'];
                    $data['sumTotalSuccess'] = $dataResult['sumTotalSuccess'];
                    $data['totalTK'] = $dataResult['totalTK'];
                    $data['totalCombo'] = $dataResult['totalCombo'];
                }else{
                    $data['status'] = false;
                }
                 $filename = date('d-m-Y',strtotime('-1 day',strtotime(date('d-m-Y')))) .'-report_day.pdf';
                 if (file_exists(public_path().'/report/' .$filename)) {
                        File::delete(public_path().'/report/' .$filename);
                 }
                 $pdf = SPDF::loadView('backend.statistic.printDay',['data'=> $data])
                   ->setPaper('a4')
                   ->setOption('margin-top', 12)
                   ->setOption('margin-bottom', 12)
                   //->setOption('margin-left', 0)
                   //->setOption('margin-right', 0)
                   //->setOption('header-html', base_path('resources/views/backend/statistic/printHeader.html'))
                   //->setOption('footer-html', base_path('resources/views/backend/statistic/printFooter.html'))
                   ->setOption('footer-right', 'Trang [page]')->save(public_path().'/report/' .$filename);
            $arr  = Config::get('vgmmail.to') ;  
            Mail::to($arr)->send(new ReportDay('Báo cáo ngày '. date('d-m-Y',strtotime('-1 day',strtotime(date('d-m-Y'))))));
        })->dailyAt('08:31');//->everyMinute();//->dailyAt('08:31');->everyMinute();//
        /*$schedule->exec('cd /var/www/html/dv.gengargaming.vn && ls')
            ->everyMinute()
            ->sendOutputTo('/var/www/html/dv.gengargaming.vn/bootstrap/listing.txt');*/
    }
}
