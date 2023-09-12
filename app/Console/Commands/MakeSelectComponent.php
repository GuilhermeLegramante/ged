<?php

namespace App\Console\Commands;

use Exception;
use File;
use Illuminate\Console\Command;
use Str;

class MakeSelectComponent extends Command
{
    protected string $entity;

    protected string $entityUcFirst;

    protected string $stub;

    protected string $entityPtBr;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:select';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Livewire Select Creator';

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
            $this->askEntityName();
            $this->askEntityPtBrName();
            $this->createFiles();
            $this->output->newLine();
            $this->output->writeln('Success!');

        } catch (Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }

    protected function askEntityName(): void
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

    }

    protected function askEntityPtBrName(): void
    {
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
        $this->createTrait();
        $this->createSelectFrontEnd();
        $this->createSelectBackEnd();
    }

    private function createTrait(): void
    {
        $path = 'Http/Livewire/Traits/Selects/';

        $path = app_path($path . 'With' . ucfirst($this->entity) . 'Select.php');

        $this->stub = File::get(app_path() . '/stubs/select/trait.stub');

        $this->stub = str_replace('{{ entity }}', $this->entity, $this->stub);
        $this->stub = str_replace('{{ entityUcFirst }}', $this->entityUcFirst, $this->stub);

        File::put($path, $this->stub);
    }

    private function createSelectFrontEnd(): void
    {
        $path = base_path() . '\\resources\\views\\livewire\\' . Str::kebab($this->entity) . '-select.blade.php';

        $this->stub = File::get(app_path() . '/stubs/select/front.stub');

        File::put($path, $this->stub);
    }

    private function createSelectBackEnd(): void
    {
        $path = app_path('Http/Livewire/' . ucfirst($this->entity) . 'Select.php');

        $this->stub = File::get(app_path() . '/stubs/select/back.stub');

        $this->stub = str_replace('{{ entity }}', $this->entity, $this->stub);
        $this->stub = str_replace('{{ entityUcFirst }}', $this->entityUcFirst, $this->stub);
        $this->stub = str_replace('{{ entityPtBr }}', $this->entityPtBr, $this->stub);

        File::put($path, $this->stub);
    }
}
