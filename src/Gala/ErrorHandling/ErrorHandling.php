<?php

declare(strict_types=1);

namespace Gala\ErrorHandling;

use ErrorException;
use Gala\Base\BaseView;

class ErrorHandling
{
    /**
     * Error Handler. Convert all errors to exception by throwing an ErrorException
     *
     * @return void
     */
    public static function errorHandler($severity, $message, $file, $line)
    {
        if (!error_reporting() && $severity) {
            return;
        }
        throw new ErrorException($message, code: 0, filename: $file, line: $line);
    }

    public static function exceptionHandler($exception)
    {
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);

        $error = true;
        if ($error) {
            echo "<h1>Fatal Error</h1>";
            echo "<p>Uncaught exception: " . get_class($exception) . "</p>";
            echo "<p>Message: " . $exception->getMessage() . "</p>";
            echo "<p>Stack trace: " . $exception->getTraceAsString() . "</p>";
            echo "<p>Thrown in: " . $exception->getFile() . " on line " . $exception->getLine() . "</p>";
        } else {
            $errorLog = LOG_DIR . "/" . date('Y-m-d H:is') . ".log";
            ini_set('error_log', $errorLog);
            $message = "Uncaught exception: " . get_class($exception);
            $message .= "with message " . $exception->getMessage();
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in: " . $exception->getFile() . " on line " . $exception->getLine();

            error_log($message);

            echo (new BaseView())->getTemplate("error/{$code}.html.twig", ['error_message' => $message]);
        }
    }
}
