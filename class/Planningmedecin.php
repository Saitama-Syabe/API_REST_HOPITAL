<?php
include 'Action.php';
class Planningmedecin
{
    private $id;
    private $planningmedecinid;
    private $date;
    private $heuredebut;
    private $heurefin;
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
    public function getplanningmedecinid()
    {
        return $this->planningmedecinid;
    }

    /**
     * @param mixed $planningmedecinid
     */
    public function setPlanningmedecinid($planningmedecinid)
    {
        $this->planningmedecinid = $planningmedecinid;
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
    public function getHeuredebut()
    {
        return $this->heuredebut;
    }

    /**
     * @param mixed $heuredebut
     */
    public function setHeuredebut($heuredebut)
    {
        $this->heuredebut = $heuredebut;
    }

    /**
     * @return mixed
     */
    public function getHeurefin()
    {
        return $this->heurefin;
    }

    /**
     * @param mixed $heurefin
     */
    public function setHeurefin($heurefin)
    {
        $this->heurefin = $heurefin;
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
