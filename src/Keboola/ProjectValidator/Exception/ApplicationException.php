<?php

/**
 * Created by Miroslav Čillík <miro@keboola.com>
 * Date: 23/08/17
 * Time: 15:22
 */

namespace Keboola\ProjectValidator\Exception;

class ApplicationException extends \Exception
{
    /**
     * @var array
     */
    protected $data;
    public function __construct($message = "", $code = 0, \Exception $previous = null, $data = [])
    {
        $this->setData($data);
        parent::__construct($message, $code, $previous);
    }
    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }
    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
