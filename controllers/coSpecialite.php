<?php

require '../tools/tools.php';
require '../class/Specialite.php';
require '../models/moSpecialite.php';

$_Action = new Action();
$_Specialite = new Specialite();
$_ModelSpecialite = new moSpecialite();
$tools = new tools();
// bloc des requêtes http POST
if ($_REQUEST_METHOD == 'POST')
{

    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$Insert || $_REQUEST_ACTION == $_Action::$UpdateById)) {
        if (
            isset($_REQUEST['libelle']) && !empty($_REQUEST['libelle'])
            && isset($_REQUEST['description']) && !empty($_REQUEST['description'])
            && isset($_REQUEST['createdby']) && !empty($_REQUEST['createdby']))
        {
            $_RESPONSE = PostOrPutSpecialite($_REQUEST_ACTION, $_Specialite, $_ModelSpecialite, $tools);
        } else {
            $_RESPONSE = $tools::getMessageEmpty();
        }
    }
}



// Bloc des requêtes http DELETE
if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$DeleteById || $_REQUEST_ACTION == $_Action::$Delete) && $_REQUEST_METHOD == 'DELETE') {
    if (isset($_REQUEST['specialiteid']) && !empty($_REQUEST['specialiteid'])) {

        $_Specialite->setAction($_REQUEST_ACTION);
        $_Specialite->setSpecialite($_REQUEST['specialiteid']);
        $_Specialite -> setCreatedby($_REQUEST['createdby']);
        $_Response = $_Model_Specialite->CrudSpecialite($_Specialite);
        $_RESPONSE = $tools::getMessageSuccess($_Response);
    } else {
        $_RESPONSE = $tools::getMessageEmpty();
    }
}



// Bloc des requêtes http GET
if ($_REQUEST_METHOD == 'GET') {
    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$SelectAll || $_REQUEST_ACTION == $_Action::$SelectById)) {
        $_RESPONSE = GET_Specialite($_REQUEST_ACTION, $_Specialite, $_ModelSpecialite, $tools);
    }
}


// Liste des fonctions
function GET_Specialite($_ACTION, Specialite $_Specialite, moSpecialite $_ModelSpecialite, $tools)
{

    $_Specialite->setAction($_ACTION);
    $_Specialite->setSpecialite((isset($_REQUEST['specialiteid']) &&
        !empty($_REQUEST['specialiteid']) && $_REQUEST['specialiteid'] != 'undefined') ?  $_REQUEST['specialiteid'] : '');
    $_Response = $_ModelSpecialite->CrudSpecialite($_Specialite);
    return $tools::getMessageResult($_Response != null && $_Response != 1 && sizeof($_Response) > 0 ? $_Response : array());
}

function PostOrPutSpecialite($_ACTION, Specialite $_Specialite, moSpecialite $_ModelSpecialite, $tools)
{

    // Traitement de l'image
    $_fileName = (isset($_FILES['photo']) ? (substr($tools::generateGuid(), 0, 8) . strrchr($_FILES['photo']['name'], '.')) : $_REQUEST['oldfilename']);
    isset($_FILES['photo']) ? move_uploaded_file($_FILES['photo']['tmp_name'], ('../../files/'.$_fileName)) : null;
    (isset($_FILES['photo']) && $_ACTION == 'UpdateById' && !empty($_REQUEST['oldfilename']) && $_REQUEST['oldfilename'] !== null) ? unlink('../../files/'.$_REQUEST['oldfilename']) : null;

    $_Specialite->setAction($_ACTION);
    $_Specialite->setSpecialite((isset($_REQUEST['specialiteid']) && !empty($_REQUEST['specialiteid']) && ($_REQUEST['specialiteid'] != 'undefined') && ($_REQUEST['specialiteid'] != null) && ($_REQUEST['specialiteid'] != 'null')) ? $_REQUEST['specialiteid'] : $tools::generateGuid());
    $_Specialite->setNom($_REQUEST['libelle']);
    $_Specialite -> setPrenom($_REQUEST['description']);
    $_Specialite->setCreatedBy($_REQUEST['createdby']);

    $_Response = $_ModelSpecialite->CrudSpecialite($_Specialite);
    return $tools::getMessageSuccess($_Response);
}


echo json_encode($_RESPONSE);


