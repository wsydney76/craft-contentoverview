<?php

namespace wsydney76\contentoverview\helpers;

use craft\helpers\App;

class ConfigHelper
{
    /**
     * Requires a config file with parameters
     *
     * @param string $file The file to require, lives inside the config/contentoverview folder. Without .php extension.
     * @param array $params Array of key/value pairs
     * @return mixed Any content returned by the required file
     */
    public static function require(string $file, array $params = []): mixed {
        return require App::parseEnv("@config/contentoverview/$file.php");
    }
}