<?php
/**
 * Created by IntelliJ IDEA.
 * User: bimdeer
 * Date: 01.06.18
 * Time: 17:00
 */


class RestException extends \Exception
{

    /**
     * @var integer $code
     */
    protected $status;

    /**
     * @var integer $timestamp
     */
    protected $timestamp;

    /**
     * @var string $error
     */
    protected $error;

    /**
     * @var string $message
     */
    protected $message;

    /**
     * @var string $data
     */
    protected $data;



    /**
     * RestException constructor.
     * @param int $status
     * @param string $error
     * @param string $message
     */
    public function __construct($status, $error, $message)
    {
        $this->timestamp = time();
        $this->status = $status;
        $this->error = $error;
        $this->message = $message;
        $this->data = [];
    }


    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }


    public function __toArray()
    {
        return [
            'status' => $this->getStatus(),
            'error' => $this->getError(),
            'message' => $this->getMessage(),
            'timestamp' => $this->getTimestamp(),
            'data' => []
        ];
    }
}