<?php

include '../models/bdd.php';

class moMedecin extends bdd
{

    public function CrudMedecin (Medecin $medecin) {
        $this -> Query = 'CALL ps_medecin (:medecinid,
                                           :nom,
                                           :prenom,
                                           :datenaissance,
                                           :email,
                                           :lieuhabitation,
                                           :photo,
                                           :createdby,
                                           :Action)';

        try {
            $this -> open();
            $this -> beginTrans();

            $PDOprepare = $this -> prepareQuery();

            $PDOprepare -> execute(
                array(
                    'medecinid' => $medecin -> getMedecinid(),
                    'nom' => $medecin -> getNom(),
                    'prenom' => $medecin -> getPrenom(),
                    'datenaissance' => $medecin -> getDatenaissance(),
                    'email' => $medecin -> getEmail(),
                    'lieuhabitation' => $medecin -> getLieuhabitation(),
                    'photo' => $medecin -> getPhoto(),
                    'createdby' => $medecin -> getCreatedBy(),
                    'Action' => $medecin -> getAction(),
                )
            );

            switch ($medecin -> getAction()) {
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
