<?php
/**
 *  Base controller class for all Controllers to extend
 *
 *   - to reduce code duplication (DRY)
 *   - to make sure all Controllers have access to the database
 *   - to make sure all Controllers have access to the config file
 *
 *  @category Base Controller Class
 *  @return void
 */
namespace Framework;

use Exception;

class Controller
{
    protected array $config;

    public function __construct()
    {
        // Load configuration
        $this->config = require basePath('config/_db.php');

        // Initialize the database
        try {
            Database::init($this->config);
        } catch (Exception $e) {
            error_log($e->getMessage());
            die('An error occurred while connecting to the database.');
        }
    }

    /**
     *  Load a view
     *
     *  @param string $view
     *  @param array $data
     *  @return void
     */
    protected function view(string $view, array $data = []): void
    {
        $viewPath = basePath("App/Views/{$view}.view.php");

        if ( !file_exists($viewPath) ) {
            echo "View {$view} not found";
        }
        extract($data);
        require $viewPath;
    }

    /**
     * Redirect to a given path
     *
     * @param string $path
     * @return void
     */

    function redirect(string $path) : void
    {
        header("Location: {$path}");
        return;
    }
}