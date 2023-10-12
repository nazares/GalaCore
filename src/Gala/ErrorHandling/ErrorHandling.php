<?php

declare(strict_types=1);

namespace Gala\ErrorHandling;

use ErrorException;
use Gala\Base\BaseView;

class ErrorHandling
{
    /**
     * Error Handler. Convert all errors to exception by throwing anuse yii\base\ErrorException
     *
     * @return void
     */
    public static function errorHandler($severity, $message, $file, $line): void
    {
        if (!(error_reporting() && $severity)) {
            return;
        }
        throw new ErrorException($message, 0, $file, $line);
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
            echo sprintf('<p>Uncaught exception: %s</p>', get_class($exception));
            echo sprintf('<p>Message: %s</p>', $exception->getMessage());
            echo sprintf('<p>Stack trace: %s</p>', $exception->getTraceAsString());
            echo sprintf("<p>Thrown in %s on line %s</p>", $exception->getFile(), $exception->getLine());
            // echo "<p>Uncaught exception: " . get_class($exception) . "</p>";
            // echo "<p>Message: " . $exception->getMessage() . "</p>";
            // echo "<p>Stack trace: " . $exception->getTraceAsString() . "</p>";
            // echo "<p>Thrown in " . $exception->getFile() . " on line " . $exception->getLine() . "</p>";
        } else {
            // $error = LOG_DIR . "/" . date("Y-m-d H:is") . ".txt";
            $errorLog = sprintf('%s/%s.txt', LOG_DIR, date("Y-m-d H:is"));
            ini_set('error_log', $errorLog);
            $message = sprintf("Uncaught exception: %s", get_class($exception));
            $message .= sprintf(" with message: %s", $exception->getMessage());
            $message .= sprintf("\nStack trace: %s", $exception->getTraceAsString());
            $message .= sprintf("\nThrown in %s on line %s", $exception->getFile(), $exception->getLine());

            error_log($message);
            echo (new BaseView())->getTemplate("error/{$code}.html.twig", ['error_message' => $message]);
        }
    }
}
