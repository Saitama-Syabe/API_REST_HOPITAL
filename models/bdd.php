<?php

class bdd extends Action
{
    protected $_REQUEST_BDENAME;

    private $host ='localhost';
    private $userName= 'root';
    private $userPass= '';
    protected $dbName= 'bd_hopital';

    private $dns;
    protected $connexion;
    public $Query;
    public $Response = 190;
    public $ResponseError = 2;
    public $ResponseSuccess = 1;

    public function __construct()
    {
        $this->open();
    }

    // Ouverture d'une connexion sur la base de données
    protected function open()
    {
        $this->setDataBaseInfo();
        try {
            $this->dns = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
            $option = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO:: FETCH_ASSOC
            );

            $this->connexion = new PDO($this->dns, $this->userName, $this->userPass, $option);

            $this->connexion->exec("Set names utf8");
        } catch (PDOException $e) {
            $Msg = 'Erreur PDO dans ' . $e->getFile() . ' Ligne ' . $e->getLine() . ' : ' . $e->getMessage();
            die($Msg);
        }
    }

    private function setDataBaseInfo(){
        if(!isset($this->_REQUEST_BDENAME) || (isset($this->_REQUEST_BDENAME) &&  empty($this->_REQUEST_BDENAME)) ) {
            $this->dbName = 'bd_hopital';
            return;
        }
        // Récuperation des informations de la base primare suivant la clé
        $this->dbName = !empty($this->_REQUEST_BDENAME) ? $this->_REQUEST_BDENAME : 'bd_hopital';

    }

    /// Gestion des transactions
    public function beginTrans()
    {
        return $this -> connexion -> beginTransaction();
    }

    public function commitTrans()
    {
        return $this -> connexion -> commit();
    }

    public function rollbackTrans()
    {
        return $this -> connexion -> rollBack();
    }

    public function prepareQuery()
    {
        return $this -> connexion -> prepare($this->Query);
    }

    public function setDataBaseName($_REQUEST_BDENAME)
    {
        $this -> _REQUEST_BDENAME = $_REQUEST_BDENAME;
        // print_r($this -> _REQUEST_BDENAME);
    }

    public function errorMsg(PDOException $error) {
        $Msg = 'ERREUR PDO dans ' . $error->getFile() . ' Ligne. ' . $error->getLine() . ' : ' . $error->getMessage();
        die($Msg);
        // return $Msg;
    }
}
