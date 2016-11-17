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


class MakeViewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siege:v {resource} {view}
                            {--a|all : Include all optional blocks}
                            {--g|group= : Which stub group to use}
                            {--o|options= : Comma delimited list of stub options to include}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a resourceful view';

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
        $dirAndFile = Stub::dirName($this->argument('resource')) . Stub::bladeFileName($this->argument('view'));
        $path = Path::make($dirAndFile, 'view');
        $model = Stub::get($this->argument('view'))->make($this->getOptions());

        // Make the file
        File::put($path, $model);

        $this->info('View made.');
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
                'model_camel' => Str::camel($this->argument('resource')),
                'model_slug' => Str::slug($this->argument('resource')),
            ]),
            'flags' => new Collection($flags),
            'all' => (empty($flags) || $this->option('all')) ? true : false,
        ];


    }
}
