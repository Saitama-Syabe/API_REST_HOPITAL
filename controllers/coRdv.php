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
            && isset($_REQUEST['daterdv']) && !empty($_REQUEST['daterdv'])
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
        $_RESPONSE = GET_Rdv($_REQUEST_ACTION, $_Rdv, $_ModelRdv, $tools);
    }
}


// Liste des fonctions
function GET_Rdv($_ACTION, Rdv $_Rdv, moRdv $_ModelRdv, $tools)
{

    $_Rdv->setAction($_ACTION);
    $_Rdv->setRdvid((isset($_REQUEST['rdvid']) &&
        !empty($_REQUEST['rdvid']) && $_REQUEST['rdvid'] != 'undefined') ?  $_REQUEST['rdvid'] : '');
    $_Rdv->setUserid((isset($_REQUEST['userid']) &&
        !empty($_REQUEST['userid']) && $_REQUEST['userid'] != 'undefined') ?  $_REQUEST['userid'] : '');
    $_Response = $_ModelRdv->CrudRdv($_Rdv);
    return $tools::getMessageResult($_Response != null && $_Response != 1 && sizeof($_Response) > 0 ? $_Response : array());
}

function PostOrPutRdv($_ACTION, Rdv $_Rdv, moRdv $_ModelRdv, $tools)
{
    $_Rdv->setAction($_ACTION);
    $_Rdv->setRdvid((isset($_REQUEST['rdvid']) && !empty($_REQUEST['rdvid']) && ($_REQUEST['rdvid'] != 'undefined') && ($_REQUEST['rdvid'] != null) && ($_REQUEST['rdvid'] != 'null')) ? $_REQUEST['rdvid'] : $tools::generateGuid());
    $_Rdv->setUserid($_REQUEST['userid']);
    $_Rdv->setDaterdv($_REQUEST['daterdv']);
    $_Rdv -> setSpecialitemedecinid($_REQUEST['specialitemedecinid']);
    $_Rdv->setCreatedBy($_REQUEST['createdby']);

    $_Response = $_ModelRdv->CrudRdv($_Rdv);
    return $tools::getMessageSuccess($_Response);
}


echo json_encode($_RESPONSE);


