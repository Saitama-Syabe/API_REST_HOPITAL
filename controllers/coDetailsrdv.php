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
            && isset($_REQUEST['isfirstrdv'])
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
        $_RESPONSE = GET_Detailsrdv($_REQUEST_ACTION, $_Detailsrdv, $_ModelDetailsrdv, $tools);
    }
}


// Liste des fonctions
function GET_Detailsrdv($_ACTION, Detailsrdv $_Detailsrdv, moDetailsrdv $_ModelDetailsrdv, $tools)
{

    $_Detailsrdv->setAction($_ACTION);
    $_Detailsrdv->setDetailsrdvid((isset($_REQUEST['detailsrdvid']) &&
        !empty($_REQUEST['detailsrdvid']) && $_REQUEST['detailsrdvid'] != 'undefined') ?  $_REQUEST['detailsrdvid'] : '');
    $_Response = $_ModelDetailsrdv->CrudDetailsrdv($_Detailsrdv);
    return $tools::getMessageResult($_Response != null && $_Response != 1 && sizeof($_Response) > 0 ? $_Response : array());
}

function PostOrPutDetailsrdv($_ACTION, Detailsrdv $_Detailsrdv, moDetailsrdv $_ModelDetailsrdv, $tools)
{

    $_Detailsrdv->setAction($_ACTION);
    $_Detailsrdv->setDetailsrdvid((isset($_REQUEST['detailsrdvid']) && !empty($_REQUEST['detailsrdvid']) && ($_REQUEST['detailsrdvid'] != 'undefined') && ($_REQUEST['detailsrdvid'] != null) && ($_REQUEST['detailsrdvid'] != 'null')) ? $_REQUEST['detailsrdvid'] : $tools::generateGuid());
    $_Detailsrdv->setRdvid($_REQUEST['rdvid']);
    $_Detailsrdv -> setDate($_REQUEST['date']);
    $_Detailsrdv->setIsfirstrdv($_REQUEST['isfirstrdv']);
    $_Detailsrdv->setCreatedBy($_REQUEST['createdby']);

    $_Response = $_ModelDetailsrdv->CrudDetailsrdv($_Detailsrdv);
    return $tools::getMessageSuccess($_Response);
    
}


echo json_encode($_RESPONSE);


