<?php

require '../tools/tools.php';
require '../class/Rdv.php';
require '../models/moRdv.php';

$_Action = new Action();
$_Rdv = new Rdv();
$_ModelRdv = new moRdv();
$tools = new tools();
// bloc des requêtes http POST
if ($_REQUEST_METHOD == 'POST')
{

    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$Insert || $_REQUEST_ACTION == $_Action::$UpdateById)) {
        if (
            isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])
            && isset($_REQUEST['specialitemedecinid']) && !empty($_REQUEST['specialitemedecinid'])
            && isset($_REQUEST['createdby']) && !empty($_REQUEST['createdby']))
        {
            $_RESPONSE = PostOrPutRdv($_REQUEST_ACTION, $_Rdv, $_ModelRdv, $tools);
        } else {
            $_RESPONSE = $tools::getMessageEmpty();
        }
    }
}



// Bloc des requêtes http DELETE
if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$DeleteById || $_REQUEST_ACTION == $_Action::$Delete) && $_REQUEST_METHOD == 'DELETE') {
    if (isset($_REQUEST['rdvid']) && !empty($_REQUEST['rdvid'])) {

        $_Rdv->setAction($_REQUEST_ACTION);
        $_Rdv->setRdvid($_REQUEST['rdvid']);
        $_Rdv -> setCreatedby($_REQUEST['createdby']);
        $_Response = $_ModelRdv->CrudRdv($_Rdv);
        $_RESPONSE = $tools::getMessageSuccess($_Response);
    } else {
        $_RESPONSE = $tools::getMessageEmpty();
    }
}



// Bloc des requêtes http GET
if ($_REQUEST_METHOD == 'GET') {
    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$SelectAll || $_REQUEST_ACTION == $_Action::$SelectById)) {
        $_RESPONSE = GET_Rdv($_REQUEST_ACTION, $_Rdv, $_Model_Rdv, $tools);
    }
}


// Liste des fonctions
function GET_Rdv($_ACTION, Rdv $_Rdv, moRdv $_ModelRdv, $tools)
{

    $_Rdv->setAction($_ACTION);
    $_Rdv->setRdvid((isset($_REQUEST['rdvid']) &&
        !empty($_REQUEST['rdvid']) && $_REQUEST['rdvid'] != 'undefined') ?  $_REQUEST['rdvid'] : '');
    $_Response = $_ModelRdv->CrudRdv($_Rdv);
    return $tools::getMessageResult($_Response != null && $_Response != 1 && sizeof($_Response) > 0 ? $_Response : array());
}

function PostOrPutRdv($_ACTION, Rdv $_Rdv, moRdv $_ModelRdv, $tools)
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


