<?php

use JetBrains\PhpStorm\NoReturn;

/**
 * Get the base path  of the project
 *
 * @param string $path
 * @return string
 */

function basePath(string $path = ''): string
{
    return __DIR__ . '/' . $path;
}

/**
 * Load a partial
 *
 * @param string $name
 * @return void
 */

function loadPartial(string $name): void
{
    $partialPath = basePath("App/Views/partials/{$name}.php");

    if( !file_exists($partialPath) ) {
        echo "Partial {$name} not found";
    }

    require $partialPath;
}

/**
 * Inspect a value(s)
 *
 * @param mixed $value
 * @return void
 */

function inspect($value): void
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

/**
 * Inspect a value(s) and die
 *
 * @param mixed $value
 * @return void
 */
function inspectAndDie($value) : void
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}

/**
 * Format salary
 *
 * @param string $salary
 * @return string
 */

function formatSalary(string $salary): string
{
    return'$'. number_format(floatval($salary));
}

/**
 * Config file loader
 *
 * @param string $name
 * @param array $default
 * @return array
 *
 * @throws Exception
 */

function loadConfig(string $name, array $default = []): array
{
    $name = str_replace('.', '/', $name);
    $configPath = basePath("config/{$name}.php");

    if( !file_exists($configPath) ) {
        if( !empty($default) ) {
            return $default;
        }
        throw new Exception("Config file {$name} not found");
    }

    return require $configPath;
}

/**
 * Sanitize data
 *
 * @param string $dirty
 * @return string
 */

function sanitize(string $dirty): string
{
    return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}


/**
 * Redirect to a given path
 *
 * @param string $path
 * @return void
 */

function redirect(string $path): void
{
    header("Location: {$path}");
    return;
}