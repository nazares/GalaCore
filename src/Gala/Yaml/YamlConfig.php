<?php

declare(strict_types=1);

namespace Gala\Yaml;

use Gala\Base\Exception\BaseException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlConfig
{
    private function isFileExists(string $filename)
    {
        if (!file_exists($filename)) {
            throw new BaseException(sprintf('%s does not exist', $filename));
        }
    }

    public function getYaml(string $yamlFile)
    {
        foreach (glob(CONFIG_PATH . DS . '*.yaml') as $file) {
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
