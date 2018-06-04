<?php
/**
 * Created by IntelliJ IDEA.
 * User: bimdeer
 * Date: 01.06.18
 * Time: 13:44
 */

class PageModel
{

    public function __toArray() : array
    {
        return  [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'head' => $this->getHead(),
            'body' => $this->getBody(),
            'ext_body' => $this->getExtBody(),
            'date_create' => $this->getDateCreate(),
            'date_update' => $this->getDateUpdate(),
        ];
    }


    /**
     * @param int $id
     */
    protected $id;
    /**
     * @param string $title
     */
    protected $title;
    /**
     * @param string $head
     */
    protected $head;
    /**
     * @param string $body
     */
    protected $body;
    /**
     * @param string $ext_body
     */
    protected $ext_body;
    /**
     * @param string $date_create
     */
    protected $date_create;
    /**
     * @param string $date_update
     */
    protected $date_update;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @param mixed $head
     */
    public function setHead($head)
    {
        $this->head = $head;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getExtBody()
    {
        return $this->ext_body;
    }

    /**
     * @param mixed $ext_body
     */
    public function setExtBody($ext_body)
    {
        $this->ext_body = $ext_body;
    }

    /**
     * @return mixed
     */
    public function getDateCreate()
    {
        return $this->date_create;
    }

    /**
     * @param mixed $date_create
     */
    public function setDateCreate($date_create)
    {
        $this->date_create = $date_create;
    }

    /**
     * @return mixed
     */
    public function getDateUpdate()
    {
        return $this->date_update;
    }

    /**
     * @param mixed $date_update
     */
    public function setDateUpdate($date_update)
    {
        $this->date_update = $date_update;
    }







}