<?php

namespace SiegeLi\Console;

// Laravel
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

// Siege
use SiegeLi\Helpers\File;
use SiegeLi\Helpers\Path;
use SiegeLi\Helpers\Group;
use SiegeLi\Console\SiegeCommand as Command;


class MvcCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siege:mvc {resource}
                            {--g|group= : Which stub group to use}
                            {--i|include= : Comma delimited list of views to include; index,show,edit,create by default}
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
            '--group' => $this->group(),
            '--options' => $this->option('options'),
            '--route' => true,
        ]);

        // Make the model
        $this->call('siege:m', [
            'model' => $this->resource(),
            '--group' => $this->group(),
            '--migration' => true,
            '--seeder' => true,
            '--factory' => true,
            '--options' => $this->option('options'),
        ]);

        $this->makeViews();

    }

    /**
    * Gets the resource parameter
    *
    * @param void
    *
    * @return string | resource name
    *
    * @author Spencer Jones
    **/
    protected function resource() {
    
        return $this->argument('resource');

    }


    /**
    * Makes all views
    *
    * @param void
    *
    * @return void
    *
    * @author Spencer Jones
    **/
    protected function makeViews() {

        $this->getViewOptions()->each(function($view) {

            $this->call('siege:v', [
                'resource' => $this->argument('resource'),
                'view' => $view,
                '--group' => $this->group(),
                '--options' => (!empty($this->option('options')) ? $this->option('options') : ''),
            ]);

        });
    
    }

    /**
    * Gets the options specified by -i flag
    * If no option given, returns resourceful views
    *
    * @param void
    *
    * @return object | Illuminate\Support\Collection
    *
    * @author Spencer Jones
    **/
    protected function getViewOptions() {
    
        // Make the views
        $views = new Collection(['index', 'edit', 'create', 'show']);
        $options = (!empty($this->option('include'))) ? new Collection(explode(',', $this->option('include'))) : new Collection([]);

        return ($options->isEmpty()) ? $views : $options;
    
    }
        
        
        
}
