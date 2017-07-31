<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-07-31
 * Time: 14:42
 */

namespace App\Exceptions;

use Exception;

class TipsException extends Exception
{
    private $params;
    private $headers;

    public function __construct($message = "", array $params = [], array $headers = [])
    {
        parent::__construct($message);
        $this->params  = $params;
        $this->headers = $headers;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getParams()
    {
        return $this->params;
    }
}