<?php

include '../models/bdd.php';

class moPlanningmedecin extends bdd
{

    public function CrudPlanningmedecin (Planningmedecin $planningmedecin) {
        $this -> Query = 'CALL ps_planningmedecin (:planningmedecinid,
                                                   :date,
                                                   :heuredebut,
                                                   :heurefin,
                                                   :createdby,
                                                   :Action)';

        try {
            $this -> open();
            $this -> beginTrans();

            $PDOprepare = $this -> prepareQuery();

            $PDOprepare -> execute(
                array(
                    'planningmedecinid' => $planningmedecin -> getPlanningmedecinid(),
                    'date' => $planningmedecin -> getDate(),
                    'heuredebut' => $planningmedecin -> getHeuredebut(),
                    'heurefin' => $planningmedecin -> getHeurefin(),
                    'createdby' => $planningmedecin -> getCreatedBy(),
                    'Action' => $planningmedecin -> getAction(),
                )
            );

            switch ($planningmedecin -> getAction()) {
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
