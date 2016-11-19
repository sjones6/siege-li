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

class MakeModelCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siege:m {resource}
                            {--a|all : Include all optional blocks}
                            {--g|group= : Which stub group to use}
                            {--m|migration : Make a migration}
                            {--s|seeder : Make a seeder}
                            {--f|factory : Make a factory}
                            {--o|options= : Comma delimited list of stub options to include}';

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
        $path = Path::make(Name::file($this->resource()), 'model');
        $model = Stub::get('model', $this->group())->make($this->getOptions());

        // Make the file
        File::put($path, $model);

        // Migration
        if ($this->shouldMakeMigration()) {
            $this->makeMigration();
        }

        if ($this->shouldMakeSeeder()) {
            $this->makeSeeder();
        }

        if ($this->shouldMakeFactory()) {
            $this->makeFactory();
        }

        $this->info('Model made.');
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

        return Name::className($this->resource());
        
    }


    /**
    * Check if a migration should be made
    *
    * @param void
    *
    * @return boolean | should / shouldnt
    *
    * @author Spencer Jones
    **/
    protected function shouldMakeMigration()
    {
    
        return ($this->option('all') || $this->option('migration')) ? true : false;

    }

    /**
    * Check if a seeder should be made
    *
    * @param void
    *
    * @return boolean | should / shouldnt
    *
    * @author Spencer Jones
    **/
    protected function shouldMakeSeeder()
    {
    
        return ($this->option('all') || $this->option('seeder')) ? true : false;

    }

    /**
    * Check if a factory should be made
    *
    * @param void
    *
    * @return boolean | should / shouldnt
    *
    * @author Spencer Jones
    **/
    protected function shouldMakeFactory()
    {
    
        return ($this->option('all') || $this->option('factory')) ? true : false;

    }

    /**
    * Make a migration
    *
    * @param void
    *
    * @return void
    *
    * @author Spencer Jones
    **/
    protected function makeMigration()
    {
    
        // Get the path and contents.
        $path = Path::file(Name::migration($this->resource()), 'migration');
        $model = Stub::get('migration', $this->group())->make($this->getOptions());

        // Make the file
        File::put($path, $model);
    
    }


    /**
    * Make a seeder
    *
    * @param void
    *
    * @return void
    *
    * @author Spencer Jones
    **/
    protected function makeSeeder()
    {
    
        // Get the path and contents.
        $path = Path::file(Name::seed($this->resource()), 'seed');
        $seeder = Stub::get('seeder', $this->group())->make($this->getOptions());

        // Make the file
        File::put($path, $seeder);    

    }

    /**
    * Make a factory
    *
    * @param void
    *
    * @return void
    *
    * @author Spencer Jones
    **/
    protected function makeFactory()
    {

        $qualifiedModel = preg_replace('/\\\\/', '', Str::studly(Name::space())) . '\\' . Str::studly($this->resource());
    
        $factory = PHP_EOL
        ."\$factory->define(${qualifiedModel}::class, function (Faker\Generator \$faker) {
    return [
        //
    ];
});"
. PHP_EOL;

        $path = Path::file('', 'factory_file');

        // Append factory to factory file
        File::append($path, $factory);    
    
    }
        
        

}
