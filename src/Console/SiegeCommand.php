<?php

namespace SiegeLi\Console;

// Laravel
use Illuminate\Console\Command;
use Illuminate\Console\AppNamespaceDetectorTrait;


class SiegeCommand extends Command
{

    use AppNamespaceDetectorTrait;

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


        return [
            'namespace' => $this->appNamespace(),
        ];
    
    }

    /**
    * Get the application namespace
    *
    * @param void
    *
    * @return string | app namespace
    *
    * @author Spencer Jones
    **/
    protected function appNamespace() {
    
        return $this->getAppNamespace();

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
        
        
        

}
