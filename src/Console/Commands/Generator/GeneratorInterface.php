<?php

namespace MikhailMouner\Datatable\Console\Commands\Generator;

interface GeneratorInterface
{
    public function getFilePath(string $name): string;

    public function getStubVariables(string $model): array;

    public function getStubPath(): string;

}
