<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Crud Model, Controller and Resources';

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
        $className = $this->ask('ClassName?');
        $componentType = $this->ask('Component Type');
        Artisan::call('make:model Model/'. $className);
        Artisan::call('make:controller '. $className.'Controller -r');
        Artisan::call('make:resource '. $className.'Resource');
        File::append(base_path('routes/api.php'), 'Route::resource(\'' . strtolower($className) . "', '{$className}Controller');");
        $this->component($className, $componentType);
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    protected function component($name, $componentType)
    {
        /*$modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Component')
        );*/
        if($componentType == 'dt'){
            $modelTemplate = $this->getStub('Component');
        }else{
            $modelTemplate = $this->getStub('Component2');
        }
        file_put_contents(resource_path("/backend/views/{$name}.vue"), $modelTemplate);
    }
}
