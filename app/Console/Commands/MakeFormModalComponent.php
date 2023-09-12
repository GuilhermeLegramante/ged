<?php

namespace App\Console\Commands;

use Exception;
use File;
use Illuminate\Console\Command;
use Str;

class MakeFormModalComponent extends Command
{
    protected string $componentName;

    protected string $entity;

    protected string $entityPtBr;

    protected string $entityUcFirst;

    protected string $stub;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:form-modal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a Livewire custom form modal component';

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
     * @return int
     */
    public function handle()
    {
        try {
            $this->askComponentName();
            $this->createFiles();
            $this->output->newLine();
            $this->output->writeln('Form modal created successfully!');

        } catch (Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }

    protected function askComponentName(): void
    {
        $this->entity = strval($this->ask('Entity name: (Ex., <comment>user</comment>)', 'user'));

        if (empty(trim(strval($this->entity))) || !is_string($this->entity)) {
            throw new Exception('Entity name is required!');
        }

        $this->entity = str_replace(['.', '\\'], '/', (string) $this->entity);

        preg_match('/(.*)(\/|\.|\\\\)(.*)/', $this->entity, $matches);

        if (!is_array($matches)) {
            throw new Exception('Format is incorrect!');
        }

        $this->entityUcFirst = ucfirst($this->entity);

        $this->componentName = $this->entityUcFirst . 'FormModal';

        $this->entityPtBr = strval($this->ask('PT-BR name: (Ex., <comment>usuario</comment>)', 'usuario'));

        if (empty(trim(strval($this->entityPtBr))) || !is_string($this->entityPtBr)) {
            throw new Exception('Entity PT-BR name is required!');
        }

        $this->entityPtBr = ucfirst(str_replace(['.', '\\'], '/', (string) $this->entityPtBr));

        preg_match('/(.*)(\/|\.|\\\\)(.*)/', $this->entityPtBr, $matches);

        if (!is_array($matches)) {
            throw new Exception('Format is incorrect!');
        }

    }

    protected function createFiles(): void
    {
        $this->createBackEndFile();
        $this->createFrontEndFiles();

    }

    private function createBackEndFile(): void
    {
        $livewirePath = 'Http/Livewire/';
        $path = app_path($livewirePath . $this->componentName . '.php');

        $this->stub = File::get(app_path() . '/stubs/form-modal.back.stub');

        $this->stub = str_replace('{{ componentName }}', $this->componentName, $this->stub);
        $this->stub = str_replace('{{ viewName }}', Str::kebab($this->componentName), $this->stub);
        $this->stub = str_replace('{{ entity }}', $this->entity, $this->stub);
        $this->stub = str_replace('{{ entityPtBr }}', $this->entityPtBr, $this->stub);
        $this->stub = str_replace('{{ entityUcFirst }}', $this->entityUcFirst, $this->stub);

        File::put($path, $this->stub);
    }

    private function createFrontEndFiles(): void
    {
        $path = base_path() . '\\resources\\views\\livewire\\' . Str::kebab($this->componentName) . '.blade.php';

        $this->stub = File::get(app_path() . '/stubs/form-modal.front.stub');

        File::put($path, $this->stub);

        $this->stub = File::get(app_path() . '/stubs/form-modal.fields.stub');

        $path = base_path() . '\\resources\\views\\partials\\forms\\' . Str::kebab($this->entity) . '.blade.php';

        File::put($path, $this->stub);

    }

}
