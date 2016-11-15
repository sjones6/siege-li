<?php

namespace SiegeLi\Console;

// Laravel
use Illuminate\Support\Str;

// Siege
use SiegeLi\Helpers\Stub;
use SiegeLi\Console\SiegeCommand as Command;

class MakeModelCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siege:m {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a model';

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

        // Get the path and contents.
        $path = app_path() . '/' . Stub::stubName($this->argument('model'));
        $model = Stub::get('model')->make($this->getOptions());

        // Make the file
        file_put_contents($path, $model);

        $this->info('Model made.');
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
            'namespace' => strstr(Str::studly($this->appNamespace()), '/'),
            'model' => Str::studly($this->argument('model')),
            'table' => Str::snake($this->argument('model')),
            'primary_key' => Str::snake($this->argument('model')) . '_id',
        ];
    
    }
        

}
