<?php

namespace SiegeLi\Console;

// Laravel
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

// Siege
use SiegeLi\Helpers\File;
use SiegeLi\Helpers\Path;
use SiegeLi\Helpers\Name;
use SiegeLi\Helpers\Group;
use SiegeLi\Templating\Stub;
use SiegeLi\Console\SiegeCommand as Command;

class MakeTestCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siege:t {resource}
                            {--a|all : Include all optional blocks}
                            {--g|group= : Which stub group to use}
                            {--o|options= : Comma delimited list of stub options to include}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a test';

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
        $path = Path::make(Name::test($this->resource()), 'test');
        $test = Stub::get('test', $this->group())->make($this->getOptions());

        // Make the file
        File::put($path, $test);
    }    

    /**
    * Get the class name
    * 
    * @param void
    *
    * @return string | resource clss name
    *
    * @author Spencer Jones
    **/
    protected function className() {

        return Name::className($this->resource(), 'Test');
        
    } 

}
