<?php
declare(strict_types=1);

namespace Dootools;

/**
 * Class Generator
 * @package Dootools
 * @author pimenvibritania <pimen@doogether.id>
 */
class Generator
{
    /**
     *
     */
    const ENDPOINT = "App\Endpoint\\";

    /**
     * @param $app
     * @param $input
     * @param $dirPath
     * @return void
     */
    public function generate($app, $input, $dirPath): void
    {
        $dir = $input->args[2];

        if (is_null($dir)) {
            $app->getPrinter()->error("Folder <argument> must be filled!");
            die();
        }

        $endpointDir = $dirPath . DIRECTORY_SEPARATOR . $dir;

        $fileName = match ($input->flags[0]) {
            "--a" => $endpointDir . DIRECTORY_SEPARATOR . "Action.php",
            "--p" => $endpointDir . DIRECTORY_SEPARATOR . "Parameter.php",
            "--r" => $endpointDir . DIRECTORY_SEPARATOR . "Repository.php",
            default => [
                "Action" => $endpointDir . DIRECTORY_SEPARATOR . "Action.php",
                "Parameter" => $endpointDir . DIRECTORY_SEPARATOR . "Parameter.php",
                "Repository" => $endpointDir . DIRECTORY_SEPARATOR . "Repository.php",
            ]
        };

        if ( !is_dir($endpointDir) ) {
            mkdir($endpointDir, 0777, true);
        }

        if (is_array($fileName)) {
            foreach ($fileName as $index => $file) {

                if (file_exists($file)) {
                    $app->getPrinter()->error("File already exist!");
                    die();
                }

                $act = 'generate' . $index . 'File';
                $this->$act($dir, $file);

                $app->getPrinter()->success("File successfully created at " . $file);
            }
        } else {
            match ($input->flags) {
                "--a" => $this->generateActionFile($dir, $fileName),
                "--p" => $this->generateParameterFile($dir, $fileName),
                "--r" => $this->generateRepositoryFile($dir, $fileName)
            };

            $app->getPrinter()->success("File successfully created at " . $fileName);
        }
    }

    /**
     * @param $contents
     * @param $dirName
     * @param $path
     * @return void
     */
    private function generateFile($contents, $dirName, $path): void
    {
        $replacedContent = str_replace("{{ namespace }}", self::ENDPOINT . "$dirName", $contents);
        file_put_contents($path, $replacedContent);
    }

    /**
     * @param $dirName
     * @param $path
     * @return void
     */
    private function generateActionFile($dirName, $path): void
    {
        $contents = file_get_contents(__DIR__ . '/stubs/action.stub');

        $this->generateFile($contents, $dirName, $path);
    }

    /**
     * @param $dirName
     * @param $path
     * @return void
     */
    private function generateParameterFile($dirName, $path): void
    {
        $contents = file_get_contents(__DIR__ . '/resources/stubs/parameter.stub');

        $this->generateFile($contents, $dirName, $path);
    }

    /**
     * @param $dirName
     * @param $path
     * @return void
     */
    private function generateRepositoryFile($dirName, $path): void
    {
        $contents = file_get_contents(__DIR__ . '/resources/stubs/repository.stub');

        $this->generateFile($contents, $dirName, $path);
    }
}
