<?php

require '../tools/tools.php';
require '../class/Planningmedecin.php';
require '../models/moPlanningmedecin.php';

$_Action = new Action();
$_Planningmedecin = new Planningmedecin();
$_ModelPlanningmedecin = new moPlanningmedecin();
$tools = new tools();
// bloc des requêtes http POST
if ($_REQUEST_METHOD == 'POST')
{

    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$Insert || $_REQUEST_ACTION == $_Action::$UpdateById)) {
        if (
            isset($_REQUEST['date']) && !empty($_REQUEST['date'])
            && isset($_REQUEST['heuredebut']) && !empty($_REQUEST['heuredebut'])
            && isset($_REQUEST['heurefin']) && !empty($_REQUEST['heurefin'])
            && isset($_REQUEST['createdby']) && !empty($_REQUEST['createdby']))
        {
            $_RESPONSE = PostOrPutPlanningmedecin($_REQUEST_ACTION, $_Planningmedecin, $_ModelPlanningmedecin, $tools);
        } else {
            $_RESPONSE = $tools::getMessageEmpty();
        }
    }
}



// Bloc des requêtes http DELETE
if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$DeleteById || $_REQUEST_ACTION == $_Action::$Delete) && $_REQUEST_METHOD == 'DELETE') {
    if (isset($_REQUEST['planningmedecinid']) && !empty($_REQUEST['planningmedecinid'])) {

        $_Planningmedecin->setAction($_REQUEST_ACTION);
        $_Planningmedecin->setPlanningmedecinid($_REQUEST['planningmedecinid']);
        $_Planningmedecin -> setCreatedby($_REQUEST['createdby']);
        $_Response = $_ModelPlanningmedecin->CrudPlanningmedecin($_Planningmedecin);
        $_RESPONSE = $tools::getMessageSuccess($_Response);
    } else {
        $_RESPONSE = $tools::getMessageEmpty();
    }
}



// Bloc des requêtes http GET
if ($_REQUEST_METHOD == 'GET') {
    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$SelectAll || $_REQUEST_ACTION == $_Action::$SelectById)) {
        $_RESPONSE = GET_Planningmedecin($_REQUEST_ACTION, $_Planningmedecin, $_ModelPlanningmedecin, $tools);
    }
}


// Liste des fonctions
function GET_Planningmedecin($_ACTION, Planningmedecin $_Planningmedecin, moPlanningmedecin $_ModelPlanningmedecin, $tools)
{

    $_Planningmedecin->setAction($_ACTION);
    $_Planningmedecin->setPlanningmedecinid((isset($_REQUEST['planningmedecinid']) &&
        !empty($_REQUEST['planningmedecinid']) && $_REQUEST['planningmedecinid'] != 'undefined') ?  $_REQUEST['planningmedecinid'] : '');
    $_Response = $_ModelPlanningmedecin->CrudPlanningmedecin($_Planningmedecin);
    return $tools::getMessageResult($_Response != null && $_Response != 1 && sizeof($_Response) > 0 ? $_Response : array());
}

function PostOrPutPlanningmedecin($_ACTION, Planningmedecin $_Planningmedecin, moPlanningmedecin $_ModelPlanningmedecin, $tools)
{

    // Traitement de l'image
    /*
    $_fileName = (isset($_FILES['photo']) ? (substr($tools::generateGuid(), 0, 8) . strrchr($_FILES['photo']['name'], '.')) : $_REQUEST['oldfilename']);
    isset($_FILES['photo']) ? move_uploaded_file($_FILES['photo']['tmp_name'], ('../../files/'.$_fileName)) : null;
    (isset($_FILES['photo']) && $_ACTION == 'UpdateById' && !empty($_REQUEST['oldfilename']) && $_REQUEST['oldfilename'] !== null) ? unlink('../../files/'.$_REQUEST['oldfilename']) : null;

    $_User->setAction($_ACTION);
    $_User->setUserid((isset($_REQUEST['userid']) && !empty($_REQUEST['userid']) && ($_REQUEST['userid'] != 'undefined') && ($_REQUEST['userid'] != null) && ($_REQUEST['userid'] != 'null')) ? $_REQUEST['userid'] : $tools::generateGuid());
    $_User->setNom($_REQUEST['nom']);
    $_User -> setPrenom($_REQUEST['prenom']);
    $_User->setPhoto($_fileName);
    $_User -> setContact($_REQUEST['contact']);
    $_User -> setDatenaissance($_REQUEST['datenaissance']);
    $_User -> setEmail($_REQUEST['email']);
    $_User -> setLieuhabitation($_REQUEST['lieuhabitation']);
    $_User->setCodeuser($_REQUEST['codeuser']);
    $_User->setCreatedBy($_REQUEST['createdby']);

    $_Response = $_ModelUser->CrudUser($_User);
    return $tools::getMessageSuccess($_Response);
    */

}


echo json_encode($_RESPONSE);


