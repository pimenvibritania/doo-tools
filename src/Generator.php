<?php

namespace Dootools;

class Generator
{
    public function copy($path)
    {
        $file = file_get_contents(__DIR__ . '/stubs/file.stub');
        $content = str_replace("{{ replaced }}", 'GANTENG', $file);

        file_put_contents($path . '/Tester.php', $content);
    }
}