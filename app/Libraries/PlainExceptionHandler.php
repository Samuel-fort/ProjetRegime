<?php

namespace App\Libraries;

use CodeIgniter\Debug\ExceptionHandlerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

/**
 * Plain Exception Handler - Displays errors as simple HTML without Whoops
 */
class PlainExceptionHandler implements ExceptionHandlerInterface
{
    protected Throwable $exception;
    protected int $statusCode;

    public function __construct(Throwable $exception, int $statusCode = 500)
    {
        $this->exception = $exception;
        $this->statusCode = $statusCode;
    }

    public function handle(Throwable $exception, RequestInterface $request, ResponseInterface $response, int $statusCode, int $exitCode): void
    {
        $isDev = getenv('CI_ENVIRONMENT') === 'development';

        if (is_cli()) {
            echo $this->renderCLI();
        } else {
            http_response_code($statusCode);
            echo $this->renderHTML($isDev);
        }

        exit($exitCode);
    }

    private function renderCLI(): string
    {
        $message = "ERROR ({$this->statusCode}): " . $this->exception->getMessage() . "\n\n";
        $message .= "File: " . $this->exception->getFile() . " on line " . $this->exception->getLine() . "\n\n";

        if (getenv('CI_ENVIRONMENT') === 'development') {
            $message .= "Trace:\n";
            $message .= $this->exception->getTraceAsString();
        }

        return $message;
    }

    private function renderHTML(bool $isDev): string
    {
        $html = "<!DOCTYPE html>\n<html>\n<head>\n";
        $html .= "    <title>Error {$this->statusCode}</title>\n";
        $html .= "    <style>\n";
        $html .= "        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }\n";
        $html .= "        .error-container { background: white; border: 1px solid #ddd; padding: 20px; border-radius: 5px; }\n";
        $html .= "        .error-code { color: #d32f2f; font-weight: bold; font-size: 24px; }\n";
        $html .= "        .error-message { color: #333; font-size: 18px; margin: 10px 0; }\n";
        $html .= "        .error-details { color: #666; font-size: 14px; margin-top: 20px; }\n";
        $html .= "        .trace { background: #f9f9f9; border-left: 4px solid #d32f2f; padding: 10px; overflow-x: auto; }\n";
        $html .= "        pre { margin: 0; white-space: pre-wrap; word-wrap: break-word; }\n";
        $html .= "    </style>\n";
        $html .= "</head>\n<body>\n";
        $html .= "<div class='error-container'>\n";
        $html .= "    <div class='error-code'>Error {$this->statusCode}</div>\n";
        $html .= "    <div class='error-message'>" . htmlspecialchars($this->exception->getMessage()) . "</div>\n";
        $html .= "    <div class='error-details'>\n";
        $html .= "        <strong>File:</strong> " . htmlspecialchars($this->exception->getFile()) . "<br>\n";
        $html .= "        <strong>Line:</strong> " . $this->exception->getLine() . "\n";
        $html .= "    </div>\n";

        if ($isDev) {
            $html .= "    <div class='trace'>\n";
            $html .= "        <strong>Stack Trace:</strong>\n";
            $html .= "        <pre>" . htmlspecialchars($this->exception->getTraceAsString()) . "</pre>\n";
            $html .= "    </div>\n";
        }

        $html .= "</div>\n";
        $html .= "</body>\n";
        $html .= "</html>\n";

        return $html;
    }
}

