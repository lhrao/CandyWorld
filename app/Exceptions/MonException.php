<?php

namespace App\Exceptions;
use Exception;
use Throwable;

class MonException extends Exception
{
    protected $message = "Unknown exception";
    protected $string;
    protected $code;
    protected $file;
    protected $line;
    protected $trace;

    public function __construct($message,$code = 0, Exception $previous = null)
    {
        if (!$message)
        {
            throw new $this('Unknown '. get_class($this));
        }
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file} ({$this->line}) \n" . " {$this->getTraceAsString()}";
    }
}