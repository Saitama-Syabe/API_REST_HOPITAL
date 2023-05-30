<?php

require '../tools/tools.php';
require '../class/Medecin.php';
require '../models/moMedecin.php';

$_Action = new Action();
$_Medecin = new Medecin();
$_ModelMedecin = new moMedecin();
$tools = new tools();
// bloc des requêtes http POST
if ($_REQUEST_METHOD == 'POST')
{

    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$Insert || $_REQUEST_ACTION == $_Action::$UpdateById)) {
        if (
            isset($_REQUEST['nom']) && !empty($_REQUEST['nom'])
            && isset($_REQUEST['prenom']) && !empty($_REQUEST['prenom'])
            && isset($_REQUEST['datenaissance']) && !empty($_REQUEST['datenaissance'])
            && isset($_REQUEST['email']) && !empty($_REQUEST['email'])
            && isset($_REQUEST['lieuhabitation']) && !empty($_REQUEST['lieuhabitation'])
            && isset($_REQUEST['photo']) && !empty($_REQUEST['photo'])
            && isset($_REQUEST['createdby']) && !empty($_REQUEST['createdby']))
        {
            $_RESPONSE = PostOrPutMedecin($_REQUEST_ACTION, $_Medecin, $_ModelMedecin, $tools);
        } else {
            $_RESPONSE = $tools::getMessageEmpty();
        }
    }
}



// Bloc des requêtes http DELETE
if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$DeleteById || $_REQUEST_ACTION == $_Action::$Delete) && $_REQUEST_METHOD == 'DELETE') {
    if (isset($_REQUEST['medecinid']) && !empty($_REQUEST['medecinid'])) {

        $_Medecin->setAction($_REQUEST_ACTION);
        $_Medecin->setMedecinid($_REQUEST['medecinid']);
        $_Medecin -> setCreatedby($_REQUEST['createdby']);
        $_Response = $_ModelMedecin->CrudMedecin($_Medecin);
        $_RESPONSE = $tools::getMessageSuccess($_Response);
    } else {
        $_RESPONSE = $tools::getMessageEmpty();
    }
}



// Bloc des requêtes http GET
if ($_REQUEST_METHOD == 'GET') {
    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$SelectAll || $_REQUEST_ACTION == $_Action::$SelectById)) {
        $_RESPONSE = GET_Medecin($_REQUEST_ACTION, $_Medecin, $_ModelMedecin, $tools);
    }
}


// Liste des fonctions
function GET_Medecin($_ACTION, Medecin $_Medecin, moMedecin $_ModelMedecin, $tools)
{

    $_Medecin->setAction($_ACTION);
    $_Medecin->setMedecinid((isset($_REQUEST['medecin']) &&
        !empty($_REQUEST['medecin']) && $_REQUEST['medecin'] != 'undefined') ?  $_REQUEST['medecin'] : '');
    $_Response = $_ModelMedecin->CrudMedecin($_Medecin);
    return $tools::getMessageResult($_Response != null && $_Response != 1 && sizeof($_Response) > 0 ? $_Response : array());
}

function PostOrPutMedecin($_ACTION, Medecin $_Medecin, moMedecin $_ModelMedecin, $tools)
{

    // Traitement de l'image
    $_fileName = (isset($_FILES['photo']) ? (substr($tools::generateGuid(), 0, 8) . strrchr($_FILES['photo']['name'], '.')) : $_REQUEST['oldfilename']);
    isset($_FILES['photo']) ? move_uploaded_file($_FILES['photo']['tmp_name'], ('../../files/'.$_fileName)) : null;
    (isset($_FILES['photo']) && $_ACTION == 'UpdateById' && !empty($_REQUEST['oldfilename']) && $_REQUEST['oldfilename'] !== null) ? unlink('../../files/'.$_REQUEST['oldfilename']) : null;

    $_Medecin->setAction($_ACTION);
    $_Medecin->setMedecinid((isset($_REQUEST['medecinid']) && !empty($_REQUEST['medecinid']) && ($_REQUEST['medecinid'] != 'undefined') && ($_REQUEST['medecinid'] != null) && ($_REQUEST['medecinid'] != 'null')) ? $_REQUEST['medecinid'] : $tools::generateGuid());
    $_Medecin->setNom($_REQUEST['nom']);
    $_Medecin -> setPrenom($_REQUEST['prenom']);
    $_Medecin->setPhoto($_fileName);
    $_Medecin -> setDatenaissance($_REQUEST['datenaissance']);
    $_Medecin -> setEmail($_REQUEST['email']);
    $_Medecin -> setLieuhabitation($_REQUEST['lieuhabitation']);
    $_Medecin->setCreatedBy($_REQUEST['createdby']);

    $_Response = $_ModelMedecin->CrudMedecin($_Medecin);
    return $tools::getMessageSuccess($_Response);
}


echo json_encode($_RESPONSE);


