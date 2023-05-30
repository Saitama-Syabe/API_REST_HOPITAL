<?php

include '../models/bdd.php';

class moUser extends bdd
{

    public function CrudUser (User $user) {
        $this -> Query = 'CALL ps_user (:userid,
                                        :nom,
                                        :prenom,
                                        :datenaissance,
                                        :contact,
                                        :email,
                                        :lieuhabitation,
                                        :photo,
                                        :codeuser,
                                        :createdby,
                                        :Action)';

        try {
            $this -> open();
            $this -> beginTrans();

            $PDOprepare = $this -> prepareQuery();

            $PDOprepare -> execute(
                array(
                    'userid' => $user -> getUserid(),
                    'nom' => $user -> getNom(),
                    'prenom' => $user -> getPrenom(),
                    'datenaissance' => $user -> getDatenaissance(),
                    'contact' => $user -> getContact(),
                    'email' => $user -> getEmail(),
                    'lieuhabitation' => $user -> getLieuhabitation(),
                    'photo' => $user -> getPhoto(),
                    'codeuser' => $user -> getCodeuser(),
                    'createdby' => $user -> getCreatedBy(),
                    'Action' => $user -> getAction(),
                )
            );

            switch ($user -> getAction()) {
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
