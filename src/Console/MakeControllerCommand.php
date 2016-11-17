<?php

namespace SiegeLi\Console;


// Laravel
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

// Siege
use SiegeLi\Helpers\Stub;
use SiegeLi\Helpers\File;
use SiegeLi\Helpers\Path;
use SiegeLi\Helpers\Group;
use SiegeLi\Console\SiegeCommand as Command;

class MakeControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siege:c {resource}
                            {--r|route : Make resourceful route}
                            {--a|all : Include all optional blocks}
                            {--g|group= : Which stub group to use}
                            {--o|options= : Comma delimited list of stub options to include}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a controller for a resource.';

    /**
    * @var string | the resource parameter
    **/
    protected $resource = '';

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

        $this->setResource($this->argument('resource'));

        // Get the path and contents.
        $path = Path::make(Stub::fileName($this->resource() . 'Controller'), 'controller');
        $model = Stub::get('controller')->make($this->getOptions());

        // Make the file
        File::put($path, $model);

        if ($this->shouldMakeRoute()) {
            $this->makeResourcefulRoute();
        }

        $this->info('Controller made.');
    }


    /**
    * Check if a route should be made
    *
    * @param void
    *
    * @return boolean | should / shouldnt
    *
    * @author Spencer Jones
    **/
    protected function shouldMakeRoute() {
    
        return ($this->option('all') || $this->option('route')) ? true : false;

    }

    /**
    * Makes a resourceful route in routes file
    *
    * @param void
    *
    * @return void
    *
    * @author Spencer Jones
    **/
    protected function makeResourcefulRoute()
    {
    
        $slug = Str::slug($this->resource());
        $resource = Str::studly($this->resource());

        // If resources are limited
        // add this parameter to routes creation
        $resources = '';
        $flags = !empty($this->option('options')) ? explode(',', $this->option('options')) : [];
        if (!empty($flags)) {
            $resources = ', [\'only\' => [\'' . implode($flags, '\', \'') . '\']]';
        }

        // Get the path and contents.
        $path = Path::make('web.php', 'route');
        $route = "

Route::resource('${slug}', '${resource}Controller'${resources});
        ";

        // Add new route to end of current routes/web.php
        File::append($path, $route);

    }
        
        

    /**
    * Assembles all arguments passed by user input
    *
    * @param void
    *
    * @return array | options
    *
    * @author Spencer Jones
    **/
    protected function getOptions()
    {

        $flags = !empty($this->option('options')) ? explode(',', $this->option('options')) : [];

        return [
            'vars' => new Collection([
                'namespace' => preg_replace('/\\\\/', '', Str::studly($this->appNamespace())),
                'model' => Str::studly($this->resource()),
                'model_camel' => Str::camel($this->resource()),
                'name' => Str::studly($this->resource()) . 'Controller',
                'slug' => Str::slug($this->resource()),
            ]),
            'flags' => new Collection($flags),
            'all' => (empty($flags) || $this->option('all')) ? true : false,
        ];
    
    }

    /**
    * Get the resource name
    *
    * @param void
    *
    * @return string | resource name
    *
    * @author Spencer Jones
    **/
    protected function resource()
    {
        
        return $this->resource;
    
    }

    /**
    * Set the resource name
    *
    * @param void
    *
    * @return string | resource name
    *
    * @author Spencer Jones
    **/
    protected function setResource($resource)
    {
        
        $this->resource = Str::snake($resource);
    
    }
        
}
