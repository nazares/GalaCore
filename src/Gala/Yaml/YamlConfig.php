<?php

declare(strict_types=1);

namespace Gala\Yaml;

use Gala\Base\Exception\BaseException;
use Symfony\Component\Yaml\Yaml;

class YamlConfig
{
    private function isFileExists(string $filename)
    {
        if (!file_exists($filename)) {
            throw new BaseException("{$filename} does not exist");
        }
    }

    public function getYaml(string $yamlFile)
    {
        foreach (glob(CONFIG_PATH . DS . '*.{yml,yaml}', GLOB_BRACE) as $file) {
            $this->isFileExists($file);
            $parts = parse_url($file);
            $path = $parts['path'];
            if (strpos($path, $yamlFile) !== false) {
                return Yaml::parseFile($file);
            }
        }
    }

    public static function file(string $yamlFile)
    {
        return (new YamlConfig())->getYaml($yamlFile);
    }
}
