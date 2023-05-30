<?php
include 'Action.php';
class Specialitemedecin
{
    private $id;
    private $specialitemedecinid;
    private $medecinid;
    private $specialiteid;
    private $date;
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
    public function getMedecinid()
    {
        return $this->medecinid;
    }

    /**
     * @param mixed $medecinid
     */
    public function setMedecinid($medecinid)
    {
        $this->medecinid = $medecinid;
    }

    /**
     * @return mixed
     */
    public function getSpecialiteid()
    {
        return $this->specialiteid;
    }

    /**
     * @param mixed $specialiteid
     */
    public function setSpecialiteid($specialiteid)
    {
        $this->specialiteid = $specialiteid;
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
