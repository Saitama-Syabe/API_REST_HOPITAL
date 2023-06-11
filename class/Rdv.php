<?php
include 'Action.php';
class Rdv
{
    private $id;
    private $rdvid;
    private $userid;
    private $daterdv;
    private $specialitemedecinid;
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
    public function getDaterdv()
    {
        return $this->daterdv;
    }

    /**
     * @param mixed $daterdv
     */
    public function setDaterdv($daterdv): void
    {
        $this->daterdv = $daterdv;
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
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return mixed
     */
    public function getSpecialitemedecinid()
    {
        return $this->specialitemedecinid;
    }

    /**
     * @param mixed $specialitemedecinid
     */
    public function setSpecialitemedecinid($specialitemedecinid)
    {
        $this->specialitemedecinid = $specialitemedecinid;
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
