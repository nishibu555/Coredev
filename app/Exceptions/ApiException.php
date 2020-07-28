<?php namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Class ApiException
 * @package App\Exceptions
 */
class ApiException extends Exception implements Jsonable
{

    /**
     * @var mixed
     */
    public $data;

    public function __construct($message, string $data = null)
    {
        parent::__construct('API exception: ' . $message);
        $this->data = $data;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return $this->data;
    }
}
