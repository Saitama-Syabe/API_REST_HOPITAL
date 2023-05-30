<?php

require '../tools/tools.php';
require '../class/Specialitemedecin.php';
require '../models/moSpecialitemedecin.php';

$_Action = new Action();
$_Specialitemedecin = new Specialitemedecin();
$_ModelSpecialitemedecin = new moSpecialitemedecin();
$tools = new tools();
// bloc des requêtes http POST
if ($_REQUEST_METHOD == 'POST')
{

    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$Insert || $_REQUEST_ACTION == $_Action::$UpdateById)) {
        if (
            isset($_REQUEST['medecinid']) && !empty($_REQUEST['medecinid'])
            && isset($_REQUEST['specialiteid']) && !empty($_REQUEST['specialiteid'])
            && isset($_REQUEST['date']) && !empty($_REQUEST['date'])
            && isset($_REQUEST['createdby']) && !empty($_REQUEST['createdby']))
        {
            $_RESPONSE = PostOrPutSpecialitemedecin($_REQUEST_ACTION, $_Specialitemedecin, $_ModelSpecialitemedecin, $tools);
        } else {
            $_RESPONSE = $tools::getMessageEmpty();
        }
    }
}



// Bloc des requêtes http DELETE
if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$DeleteById || $_REQUEST_ACTION == $_Action::$Delete) && $_REQUEST_METHOD == 'DELETE') {
    if (isset($_REQUEST['specialitemedecinid']) && !empty($_REQUEST['specialitemedecinid'])) {

        $_Specialitemedecin->setAction($_REQUEST_ACTION);
        $_Specialitemedecin->setSpecialitemedecinid($_REQUEST['specialitemedecinid']);
        $_Specialitemedecin -> setCreatedby($_REQUEST['createdby']);
        $_Response = $_ModelSpecialitemedecin->CrudSpecialitemedecin($_Specialitemedecin);
        $_RESPONSE = $tools::getMessageSuccess($_Response);
    } else {
        $_RESPONSE = $tools::getMessageEmpty();
    }
}



// Bloc des requêtes http GET
if ($_REQUEST_METHOD == 'GET') {
    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$SelectAll || $_REQUEST_ACTION == $_Action::$SelectById)) {
        $_RESPONSE = GET_Specialitemedecin($_REQUEST_ACTION, $_Specialitemedecin, $_ModelSpecialitemedecin, $tools);
    }
}


// Liste des fonctions
function GET_Specialitemedecin($_ACTION, Specialitemedecin $_Specialitemedecin, moSpecialitemedecin $_ModelSpecialitemedecin, $tools)
{

    $_Specialitemedecin->setAction($_ACTION);
    $_Specialitemedecin->setSpecialitemedecinid((isset($_REQUEST['specialitemedecinid']) &&
        !empty($_REQUEST['specialitemedecinid']) && $_REQUEST['specialitemedecinid'] != 'undefined') ?  $_REQUEST['specialitemedecinid'] : '');
    $_Response = $_ModelSpecialitemedecin->CrudSpecialitemedecin($_Specialitemedecin);
    return $tools::getMessageResult($_Response != null && $_Response != 1 && sizeof($_Response) > 0 ? $_Response : array());
}

function PostOrPutSpecialitemedecin($_ACTION, Specialitemedecin $_Specialitemedecin, moSpecialitemedecin $_ModelSpecialitemedecin, $tools)
{

    // Traitement de l'image
    $_fileName = (isset($_FILES['photo']) ? (substr($tools::generateGuid(), 0, 8) . strrchr($_FILES['photo']['name'], '.')) : $_REQUEST['oldfilename']);
    isset($_FILES['photo']) ? move_uploaded_file($_FILES['photo']['tmp_name'], ('../../files/'.$_fileName)) : null;
    (isset($_FILES['photo']) && $_ACTION == 'UpdateById' && !empty($_REQUEST['oldfilename']) && $_REQUEST['oldfilename'] !== null) ? unlink('../../files/'.$_REQUEST['oldfilename']) : null;

    $_Specialitemedecin->setAction($_ACTION);
    $_Specialitemedecin->setSpecialitemedecinid((isset($_REQUEST['specialitemedecinid']) && !empty($_REQUEST['specialitemedecinid']) && ($_REQUEST['specialitemedecinid'] != 'undefined') && ($_REQUEST['specialitemedecinid'] != null) && ($_REQUEST['specialitemedecinid'] != 'null')) ? $_REQUEST['specialitemedecinid'] : $tools::generateGuid());
    $_Specialitemedecin->setmedecinid($_REQUEST['medecinid']);
    $_Specialitemedecin -> setspecialiteid($_REQUEST['specialiteid']);
    $_Specialitemedecin->setCreatedBy($_REQUEST['createdby']);

    $_Response = $_ModelSpecialitemedecin->CrudSpecialitemedecin($_Specialitemedecin);
    return $tools::getMessageSuccess($_Response);
}


echo json_encode($_RESPONSE);


