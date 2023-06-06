<?php

require '../tools/tools.php';
require '../class/Access.php';
require '../models/moAccess.php';

$_Action = new Action();
$_Access = new Access();
$_ModelAccess = new moAccess();
$tools = new tools();
// bloc des requêtes http POST
if ($_REQUEST_METHOD == 'POST')
{

    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$Connect)) {
        
        if (
            isset($_REQUEST['username']) && !empty($_REQUEST['username'])
            && isset($_REQUEST['password']) && !empty($_REQUEST['password']))
        {
            $_Access->setAction($_REQUEST['Action']);
            $_Access->setUsername($_REQUEST['username']);
            $_Access->setPassword($_REQUEST['password']);
            $_Response = $_ModelAccess->CrudAccess($_Access);
            
            $_RESPONSE = $tools::getMessageResult($_Response != null && $_Response != 1 && sizeof($_Response) > 1 ? $_Response : array());
        } else {
            $_RESPONSE = $tools::getMessageEmpty();
        }
    } else if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$Insert || $_REQUEST_ACTION == $_Action::$UpdateById)) {
        if (
            isset($_REQUEST['username']) && !empty($_REQUEST['username'])
            && isset($_REQUEST['password']) && !empty($_REQUEST['password'])
            && isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])
            && isset($_REQUEST['expiredon']) && !empty($_REQUEST['expiredon'])
            && isset($_REQUEST['createdby']) && !empty($_REQUEST['createdby']))
        {
            $_RESPONSE = PostOrPutAccess($_REQUEST_ACTION, $_Access, $_ModelAccess, $tools);
        } else {
            $_RESPONSE = $tools::getMessageEmpty();
        }
    }
}

// Bloc des requêtes http DELETE
if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$DeleteById || $_REQUEST_ACTION == $_Action::$Delete) && $_REQUEST_METHOD == 'DELETE') {
    if (isset($_REQUEST['accessid']) && !empty($_REQUEST['accessid'])) {

        $_Access->setAction($_REQUEST_ACTION);
        $_Access->setAccessid($_REQUEST['accessid']);
        $_Access -> setCreatedby($_REQUEST['createdby']);
        $_Response = $_ModelAccess->CrudAccess($_Access);
        $_RESPONSE = $tools::getMessageSuccess($_Response);
    } else {
        $_RESPONSE = $tools::getMessageEmpty();
    }
}



// Bloc des requêtes http GET
if ($_REQUEST_METHOD == 'GET') {
    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$SelectAll || $_REQUEST_ACTION == $_Action::$SelectById)) {
        $_RESPONSE = GET_Access($_REQUEST_ACTION, $_Access, $_ModelAccess, $tools);
    }
}


// Liste des fonctions
function GET_Access($_ACTION, Access $_Access, moAccess $_ModelAccess, $tools)
{

    $_Access->setAction($_ACTION);
    $_Access->setAccessid((isset($_REQUEST['accessid']) &&
        !empty($_REQUEST['accessid']) && $_REQUEST['accessid'] != 'undefined') ?  $_REQUEST['accessid'] : '');
    $_Response = $_ModelAccess->CrudAccess($_Access);
    return $tools::getMessageResult($_Response != null && $_Response != 1 && sizeof($_Response) > 0 ? $_Response : array());
}

function PostOrPutAccess($_ACTION, Access $_Access, moAccess $_ModelAccess, $tools)
{
    $_Access->setAction($_ACTION);
    $_Access->setAccessid((isset($_REQUEST['accessid']) && !empty($_REQUEST['accessid']) && ($_REQUEST['accessid'] != 'undefined') && ($_REQUEST['accessid'] != null) && ($_REQUEST['accessid'] != 'null')) ? $_REQUEST['accessid'] : $tools::generateGuid());
    $_Access->setUserid($_REQUEST['userid']);
    $_Access -> setUsername($_REQUEST['username']);
    $_Access->setPassword($_REQUEST['password']);
    $_Access->setExperedon($_REQUEST['expiredon']);
    $_Access->setCreatedBy($_REQUEST['createdby']);


    $_Response = $_ModelAccess->CrudAccess($_Access);
    return $tools::getMessageSuccess($_Response);
}


echo json_encode($_RESPONSE);


