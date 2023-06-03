<?php

include '../models/bdd.php';

class moAccess extends bdd
{

    public function Connexion (Access $access) {
        $this -> Query = 'CALL ps_Access (
                                        :accessid,
                                        :userid,
                                        :username,
                                        :password,
                                        :experedon,
                                        :createdby,
                                        :Action)';

        try {
            $this -> open();
            $this -> beginTrans();

            $PDOprepare = $this -> prepareQuery();

            $PDOprepare -> execute(
                array(
                    'accessid' => $access -> getAccessid(),
                    'userid' => $access -> getUserid(),
                    'username' => $access -> getUsername(),
                    'password' => $access -> getPassword(),
                    'experedon' => $access -> getExperedon(),
                    'createdby' => $access -> getCreatedby(),
                    'Action' => $access -> getAction(),
                )
            );

            switch ($user -> getAction()) {
                case $this::$SelectAll :
                    $this -> Response = $PDOprepare -> fetchAll();
                    break;
                case $this::$SelectById :
                case $this::$Connect :
                    $this -> Response = $PDOprepare -> fetch();
                    break;
                case $this::$Insert :
                case $this::$UpdateById :
                case $this::$DeleteById :
                    $this -> Response = $this -> ResponseSuccess;
                    break;
            }

            $PDOprepare->closecursor();

            $this->commitTrans();

            return $this->Response;
        }
        catch (PDOException $e) {
            $this->rollbackTrans();

            $Msg = $this->errorMsg($e);

            return $this->ResponseError;

        }
    }

}
