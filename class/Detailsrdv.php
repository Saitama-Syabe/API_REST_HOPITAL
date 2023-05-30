<?php
include 'Action.php';
class Detailsrdv
{
    private $id;
    private $detailsrdvid;
    private $rdvid;
    private $date;
    private $isfirstrdv;
    private $createdby;
    private $createdon;
    private $status;
    private $Action;

    public function __construct()
    {
    }

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
    public function getDetailsrdvid()
    {
        return $this->detailsrdvid;
    }

    /**
     * @param mixed $detailsrdvid
     */
    public function setDetailsrdvid($detailsrdvid)
    {
        $this->detailsrdvid = $detailsrdvid;
    }

    /**
     * @return mixed
     */
    public function getRdvid()
    {
        return $this->rdvid;
    }

    /**
     * @param mixed $rdvid
     */
    public function setRdvid($rdvid)
    {
        $this->rdvid = $rdvid;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getIsfirstrdv()
    {
        return $this->isfirstrdv;
    }

    /**
     * @param mixed $isfirstrdv
     */
    public function setIsfirstrdv($isfirstrdv)
    {
        $this->isfirstrdv = $isfirstrdv;
    }

    /**
     * @return mixed
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * @param mixed $createdby
     */
    public function setCreatedby($createdby)
    {
        $this->createdby = $createdby;
    }

    /**
     * @return mixed
     */
    public function getCreatedon()
    {
        return $this->createdon;
    }

    /**
     * @param mixed $createdon
     */
    public function setCreatedon($createdon)
    {
        $this->createdon = $createdon;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->Action;
    }

    /**
     * @param mixed $Action
     */
    public function setAction($Action)
    {
        $this->Action = $Action;
    }


}
