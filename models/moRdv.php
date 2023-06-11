<?php

include '../models/bdd.php';

class moRdv extends bdd
{

    public function CrudRdv (Rdv $rdv) {
        $this -> Query = 'CALL ps_rdv (:rdvid,
                                       :userid,
                                       :daterdv,
                                       :specialitemedecinid,
                                       :createdby,
                                       :Action)';

        try {
            $this -> open();
            $this -> beginTrans();

            $PDOprepare = $this -> prepareQuery();

            $PDOprepare -> execute(
                array(
                    'rdvid' => $rdv -> getRdvid(),
                    'userid' => $rdv -> getUserid(),
                    'daterdv' => $rdv -> getDaterdv(),
                    'specialitemedecinid' => $rdv -> getSpecialitemedecinid(),
                    'createdby' => $rdv -> getCreatedBy(),
                    'Action' => $rdv -> getAction(),
                )
            );

            switch ($rdv -> getAction()) {
                case $this::$SelectAll :
                case $this::$SelectById :
                    $this -> Response = $PDOprepare -> fetchAll();
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
