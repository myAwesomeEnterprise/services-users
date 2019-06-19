<?php

namespace App\Console\Commands;

use App\Providers\RabbitEventServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RabbitEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitevents:listen-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen for all events thrown from other services';

    protected $rabbit;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $events = $this->laravel->make('broadcast.events')->getEvents();

        foreach ($events as $event) {
            $this->info("php /var/www/html/artisan rabbitevents:listen {$event} >> /dev/null 2>&1");

            exec("php /var/www/html/artisan rabbitevents:listen {$event} >> /dev/null 2>&1");
            // > /dev/null &

            /*
            $this->call('rabbitevents:listen', [
                'event' => $event, '> /dev/null &'
            ]);
            */
        }

        return true;
    }
}
