<?php

class Action
{
    public static $Insert = 'Insert';
    public static $UpdateById = 'UpdateById';
    public static $DeleteById = 'DeleteById';
    public static $SelectAll = 'SelectAll';
    public static $SelectById = 'SelectById';
    public static $SelectAllBy = 'SelectAllBy';
    public static $SelectBy = 'SelectBy';
    public static $SelectLastPartage = 'SelectLastPartage';
    public static $ACCEPTE_ACTION = 'Accepter';
    public static $LoadAll = 'LoadAll';
    public static $Load = 'Load';
    public static $Filtre = 'Filtre';
    public static $List = 'List';
    public static $ListAll = 'ListAll';
    public static $LISTBY = 'ListBy';
    public static $Select = 'Select';
    public static $Connect = 'Connect';
    public static $ConnectCl = 'ConnectCl';
    public static $Find = 'Retrouver';
    public static $Stats = 'Stats';
    public static $StatsSuper = 'StatsSuper';
    public static $StatsMaint = 'StatsMaint';
    public static $Delete = 'Delete';
    public static $Disconnect = 'Disconnect';
    public static $Update = 'Update';
    public static $RemoveById= 'RemoveByID';


    private $createdby;
    private $createdon;
    private $status;
    private $action;

    /**
     * @return string
     */
    public static function getInsert()
    {
        return self::$Insert;
    }

    /**
     * @param string $Insert
     */
    public static function setInsert($Insert)
    {
        self::$Insert = $Insert;
    }

    /**
     * @return string
     */
    public static function getUpdateById()
    {
        return self::$UpdateById;
    }

    /**
     * @param string $UpdateById
     */
    public static function setUpdateById($UpdateById)
    {
        self::$UpdateById = $UpdateById;
    }

    /**
     * @return string
     */
    public static function getDeleteById()
    {
        return self::$DeleteById;
    }

    /**
     * @param string $DeleteById
     */
    public static function setDeleteById($DeleteById)
    {
        self::$DeleteById = $DeleteById;
    }

    /**
     * @return string
     */
    public static function getSelectAll()
    {
        return self::$SelectAll;
    }

    /**
     * @param string $SelectAll
     */
    public static function setSelectAll($SelectAll)
    {
        self::$SelectAll = $SelectAll;
    }

    /**
     * @return string
     */
    public static function getSelectById()
    {
        return self::$SelectById;
    }

    /**
     * @param string $SelectById
     */
    public static function setSelectById($SelectById)
    {
        self::$SelectById = $SelectById;
    }

    /**
     * @return string
     */
    public static function getSelectAllBy()
    {
        return self::$SelectAllBy;
    }

    /**
     * @param string $SelectAllBy
     */
    public static function setSelectAllBy($SelectAllBy)
    {
        self::$SelectAllBy = $SelectAllBy;
    }

    /**
     * @return string
     */
    public static function getSelectBy()
    {
        return self::$SelectBy;
    }

    /**
     * @param string $SelectBy
     */
    public static function setSelectBy($SelectBy)
    {
        self::$SelectBy = $SelectBy;
    }

    /**
     * @return string
     */
    public static function getSelectLastPartage()
    {
        return self::$SelectLastPartage;
    }

    /**
     * @param string $SelectLastPartage
     */
    public static function setSelectLastPartage($SelectLastPartage)
    {
        self::$SelectLastPartage = $SelectLastPartage;
    }

    /**
     * @return string
     */
    public static function getACCEPTEACTION()
    {
        return self::$ACCEPTE_ACTION;
    }

    /**
     * @param string $ACCEPTE_ACTION
     */
    public static function setACCEPTEACTION($ACCEPTE_ACTION)
    {
        self::$ACCEPTE_ACTION = $ACCEPTE_ACTION;
    }

    /**
     * @return string
     */
    public static function getLoadAll()
    {
        return self::$LoadAll;
    }

    /**
     * @param string $LoadAll
     */
    public static function setLoadAll($LoadAll)
    {
        self::$LoadAll = $LoadAll;
    }

    /**
     * @return string
     */
    public static function getLoad()
    {
        return self::$Load;
    }

    /**
     * @param string $Load
     */
    public static function setLoad($Load)
    {
        self::$Load = $Load;
    }

    /**
     * @return string
     */
    public static function getFiltre()
    {
        return self::$Filtre;
    }

    /**
     * @param string $Filtre
     */
    public static function setFiltre($Filtre)
    {
        self::$Filtre = $Filtre;
    }

    /**
     * @return string
     */
    public static function getList()
    {
        return self::$List;
    }

    /**
     * @param string $List
     */
    public static function setList($List)
    {
        self::$List = $List;
    }

    /**
     * @return string
     */
    public static function getListAll()
    {
        return self::$ListAll;
    }

    /**
     * @param string $ListAll
     */
    public static function setListAll($ListAll)
    {
        self::$ListAll = $ListAll;
    }

    /**
     * @return string
     */
    public static function getLISTBY()
    {
        return self::$LISTBY;
    }

    /**
     * @param string $LISTBY
     */
    public static function setLISTBY($LISTBY)
    {
        self::$LISTBY = $LISTBY;
    }

    /**
     * @return string
     */
    public static function getSelect()
    {
        return self::$Select;
    }

    /**
     * @param string $Select
     */
    public static function setSelect($Select)
    {
        self::$Select = $Select;
    }

    /**
     * @return string
     */
    public static function getConnect()
    {
        return self::$Connect;
    }

    /**
     * @param string $Connect
     */
    public static function setConnect($Connect)
    {
        self::$Connect = $Connect;
    }

    /**
     * @return string
     */
    public static function getConnectCl()
    {
        return self::$ConnectCl;
    }

    /**
     * @param string $ConnectCl
     */
    public static function setConnectCl($ConnectCl)
    {
        self::$ConnectCl = $ConnectCl;
    }

    /**
     * @return string
     */
    public static function getFind()
    {
        return self::$Find;
    }

    /**
     * @param string $Find
     */
    public static function setFind($Find)
    {
        self::$Find = $Find;
    }

    /**
     * @return string
     */
    public static function getStats()
    {
        return self::$Stats;
    }

    /**
     * @param string $Stats
     */
    public static function setStats($Stats)
    {
        self::$Stats = $Stats;
    }

    /**
     * @return string
     */
    public static function getStatsSuper()
    {
        return self::$StatsSuper;
    }

    /**
     * @param string $StatsSuper
     */
    public static function setStatsSuper($StatsSuper)
    {
        self::$StatsSuper = $StatsSuper;
    }

    /**
     * @return string
     */
    public static function getStatsMaint()
    {
        return self::$StatsMaint;
    }

    /**
     * @param string $StatsMaint
     */
    public static function setStatsMaint($StatsMaint)
    {
        self::$StatsMaint = $StatsMaint;
    }

    /**
     * @return string
     */
    public static function getDelete()
    {
        return self::$Delete;
    }

    /**
     * @param string $Delete
     */
    public static function setDelete($Delete)
    {
        self::$Delete = $Delete;
    }

    /**
     * @return string
     */
    public static function getDisconnect()
    {
        return self::$Disconnect;
    }

    /**
     * @param string $Disconnect
     */
    public static function setDisconnect($Disconnect)
    {
        self::$Disconnect = $Disconnect;
    }

    /**
     * @return string
     */
    public static function getUpdate()
    {
        return self::$Update;
    }

    /**
     * @param string $Update
     */
    public static function setUpdate($Update)
    {
        self::$Update = $Update;
    }

    /**
     * @return string
     */
    public static function getRemoveById()
    {
        return self::$RemoveById;
    }

    /**
     * @param string $RemoveById
     */
    public static function setRemoveById($RemoveById)
    {
        self::$RemoveById = $RemoveById;
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
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

}
