<?php

include '../models/bdd.php';

class moDetailsrdv extends bdd
{

    public function CrudDetailsrdv (Detailsrdv $detailsrdv) {
        $this -> Query = 'CALL ps_detailsrdv (:detailsrdvid,
                                              :rdvid,
                                              :date,
                                              :isfirstrdv,
                                              :createdby,
                                              :Action)';

        try {
            $this -> open();
            $this -> beginTrans();

            $PDOprepare = $this -> prepareQuery();

            $PDOprepare -> execute(
                array(
                    'detailsrdvid' => $detailsrdv -> getDetailsrdvid(),
                    'rdvid' => $detailsrdv -> getRdvid(),
                    'date' => $detailsrdv -> getDate(),
                    'isfirstrdv' => $detailsrdv -> getIsfirstrdv(),
                    'createdby' => $detailsrdv -> getCreatedBy(),
                    'Action' => $detailsrdv -> getAction(),
                )
            );

            switch ($detailsrdv -> getAction()) {
                case $this::$SelectAll :
                    $this -> Response = $PDOprepare -> fetchAll();
                    break;
                case $this::$SelectById :
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
