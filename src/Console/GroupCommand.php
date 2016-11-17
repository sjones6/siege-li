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


class GroupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siege:group {group}
                            {--f|from= Existing group to create new group}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a new stub group';

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

        $group = Str::slug($this->argument('group'));

        File::copyDir($this->getOriginDir(), Path::make($group, 'stub'));

        $this->info('New stub group ' . $group . ' created.');
    }
        
    /**
    * Generate path to copy stubs from
    *
    * @param void
    *
    * @return string | dir to copy stubs from
    *
    * @author Spencer Jones
    **/
    protected function getOriginDir() {

        if (!empty($this->option('from'))) {

            if (!Group::exists($this->option('from'))) {
                throw new \Exception('Origin group does not exist.');
            }

            return Group::path($this->option('from'));

        }
    
        return __DIR__ . '/../Stubs';
    
    }
        
}
