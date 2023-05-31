<?php

require '../tools/tools.php';
require '../class/Detailsrdv.php';
require '../models/moDetailsrdv.php';

$_Action = new Action();
$_Detailsrdv = new Detailsrdv();
$_ModelDetailsrdv = new moDetailsrdv();
$tools = new tools();
// bloc des requêtes http POST
if ($_REQUEST_METHOD == 'POST')
{

    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$Insert || $_REQUEST_ACTION == $_Action::$UpdateById)) {
        if (
            isset($_REQUEST['rdvid']) && !empty($_REQUEST['rdvid'])
            && isset($_REQUEST['date']) && !empty($_REQUEST['date'])
            && isset($_REQUEST['isfirstrdv']) && !empty($_REQUEST['isfirstrdv'])
            && isset($_REQUEST['createdby']) && !empty($_REQUEST['createdby']))
        {
            $_RESPONSE = PostOrPutDetailsrdv($_REQUEST_ACTION, $_Detailsrdv, $_ModelDetailsrdv, $tools);
        } else {
            $_RESPONSE = $tools::getMessageEmpty();
        }
    }
}



// Bloc des requêtes http DELETE
if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$DeleteById || $_REQUEST_ACTION == $_Action::$Delete) && $_REQUEST_METHOD == 'DELETE') {
    if (isset($_REQUEST['detailsrdvid']) && !empty($_REQUEST['detailsrdvid'])) {

        $_Detailsrdv->setAction($_REQUEST_ACTION);
        $_Detailsrdv->setDetailsrdvid($_REQUEST['detailsrdvid']);
        $_Detailsrdv -> setCreatedby($_REQUEST['createdby']);
        $_Response = $_ModelDetailsrdv->CrudDetailsrdv($_Detailsrdv);
        $_RESPONSE = $tools::getMessageSuccess($_Response);
    } else {
        $_RESPONSE = $tools::getMessageEmpty();
    }
}



// Bloc des requêtes http GET
if ($_REQUEST_METHOD == 'GET') {
    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$SelectAll || $_REQUEST_ACTION == $_Action::$SelectById)) {
        $_RESPONSE = GET_Detailsrdvid($_REQUEST_ACTION, $_Detailsrdvid, $_ModelDetailsrdvid, $tools);
    }
}


// Liste des fonctions
function GET_Detailsrdv($_ACTION, Detailsrdv $_Detailsrdv, moDetailsrdv $_ModelDetailsrdv, $tools)
{

    $_Detailsrdvid->setAction($_ACTION);
    $_Detailsrdvid->setDetailsrdvid((isset($_REQUEST['detailsrdvid']) &&
        !empty($_REQUEST['detailsrdvid']) && $_REQUEST['detailsrdvid'] != 'undefined') ?  $_REQUEST['detailsrdvid'] : '');
    $_Response = $_ModelDetailsrdv->CrudDetailsrdv ;($_Detailsrdv);
    return $tools::getMessageResult($_Response != null && $_Response != 1 && sizeof($_Response) > 0 ? $_Response : array());
}

function PostOrPutDetailsrdv($_ACTION, Detailsrdv $_Detailsrdv, moDetailsrdv $_ModelDetailsrdv, $tools)
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


