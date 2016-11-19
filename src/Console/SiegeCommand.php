<?php

namespace SiegeLi\Console;

// Laravel
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

// Siege
use SiegeLi\Helpers\File;
use SiegeLi\Helpers\Path;
use SiegeLi\Helpers\Group;
use SiegeLi\Helpers\Name;


class SiegeCommand extends Command
{

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
    protected function getOptions() {

        $flags = !empty($this->option('options')) ? explode(',', $this->option('options')) : [];

        return [
            'vars' => new Collection([
                'resource' => $this->resource(),
                'namespace' => Name::space(),
                'model' => Str::studly($this->resource()),
                'model_camel' => Str::camel($this->resource()),
                'class_name' => $this->className(),
                'slug' => Str::slug($this->resource()),
                'table' => Str::plural($this->resource()),
                'primary_key' => Str::snake($this->resource()) . '_id',
            ]),
            'flags' => new Collection($flags),
            'all' => (empty($flags) || $this->option('all')) ? true : false,
        ];
    
    }

    /**
    * Get the group option
    * 
    * @param void
    *
    * @return string
    *
    * @author Spencer Jones
    **/
    protected function group() {
    
        return (!empty($this->option('group'))) ? $this->option('group'): '';

    }

    /**
    * Get the resource
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
    * Get the class name
    * should be overwritten in children
    * 
    * @param void
    *
    * @return string | resource name
    *
    * @author Spencer Jones
    **/
    protected function className() {

        return Str::studly($this->resource());
        
    }
        

}
