<?php

namespace SiegeLi\Console;

// Laravel
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

// Siege
use SiegeLi\Console\SiegeCommand as Command;


class MvcCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siege:mvc {resource}
                            {--o|options= : Comma delimited list of stub options to include}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes model, views, controller, routes for resource';

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

        // Make controller
        $this->call('siege:c', [
            'resource' => $this->resource(),
            '--options' => $this->option('options'),
            '--route' => true,
        ]);

        // Make the model
        $this->call('siege:m', [
            'model' => $this->resource(),
            '--options' => $this->option('options'),
        ]);

    }

    /**
    * Description
    *
    * @param
    *
    * @return
    *
    * @author Spencer Jones
    **/
    protected function resource() {
    
        return $this->argument('resource');

    }
        
}
