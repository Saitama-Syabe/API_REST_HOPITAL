<?php

include '../models/bdd.php';

class moSpecialitemedecin extends bdd
{

    public function CrudSpecialitemedecin (Specialitemedecin $specialitemedecin) {
        $this -> Query = 'CALL ps_specialitemedecin (:specialitemedecinid,
                                                     :medecinid,
                                                     :specialiteid,
                                                     :date,
                                                     :createdby,
                                                     :Action)';

        try {
            $this -> open();
            $this -> beginTrans();

            $PDOprepare = $this -> prepareQuery();

            $PDOprepare -> execute(
                array(
                    'specialitemedecinid' => $specialitemedecin -> getSpecialitemedecin(),
                    'medecinid' => $specialitemedecin -> getMedecinid(),
                    'specialiteid' => $specialitemedecin -> getSpecialiteid(),
                    'date' => $specialitemedecin -> getDate(),
                    'createdby' => $specialitemedecin -> getCreatedBy(),
                    'Action' => $specialitemedecin -> getAction(),
                )
            );

            switch ($specialitemedecin -> getAction()) {
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
