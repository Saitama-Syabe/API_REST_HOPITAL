<?php

include '../models/bdd.php';

class moSpecialite extends bdd
{

    public function CrudSpecialite (Specialite $specialite) {
        $this -> Query = 'CALL ps_specialite (:specialiteid,
                                              :libelle,
                                              :description,
                                              :createdby,
                                              :Action)';

        try {
            $this -> open();
            $this -> beginTrans();

            $PDOprepare = $this -> prepareQuery();

            $PDOprepare -> execute(
                array(
                    'specialiteid' => $specialite -> getspecialiteid(),
                    'libelle' => $specialite -> getLibelle(),
                    'description' => $specialite -> getDescription(),
                    'createdby' => $specialite -> getCreatedBy(),
                    'Action' => $specialite -> getAction(),
                )
            );

            switch ($specialite -> getAction()) {
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
