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
            $_Access->setAction($_ACTION);
            $_Access->setUserid($_REQUEST['username']);
            $_Access->setNom($_REQUEST['password']);
            $_Response = $_ModelUser->CrudUser($_Access);
            return $tools::getMessageSuccess($$_Response != null && $_Response != 1 && sizeof($_Response) > 1 ? $_Response : array());
        } else {
            $_RESPONSE = $tools::getMessageEmpty();
        }
    }
}


echo json_encode($_RESPONSE);


