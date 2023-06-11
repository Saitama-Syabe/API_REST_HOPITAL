<?php

require '../tools/tools.php';
require '../class/User.php';
require '../models/moUser.php';

$_Action = new Action();
$_User = new User();
$_ModelUser = new moUser();
$tools = new tools();
// bloc des requêtes http POST
if ($_REQUEST_METHOD == 'POST')
{

    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$Insert || $_REQUEST_ACTION == $_Action::$UpdateById || $_REQUEST_ACTION == $_Action::$Suscribe)) {
        if (
            isset($_REQUEST['nom']) && !empty($_REQUEST['nom'])
            && isset($_REQUEST['prenom']) && !empty($_REQUEST['prenom'])
            && isset($_REQUEST['contact']) && !empty($_REQUEST['contact'])
            && isset($_REQUEST['datenaissance']) && !empty($_REQUEST['datenaissance'])
            && isset($_REQUEST['email']) && !empty($_REQUEST['email'])
            && isset($_REQUEST['lieuhabitation']) && !empty($_REQUEST['lieuhabitation'])
            && isset($_REQUEST['codeuser']) && !empty($_REQUEST['codeuser'])
            // && isset($_REQUEST['photo']) && !empty($_REQUEST['photo'])
            && isset($_REQUEST['createdby']) && !empty($_REQUEST['createdby']))
        {
            $_RESPONSE = PostOrPutUser($_REQUEST_ACTION, $_User, $_ModelUser, $tools);
        } else {
            $_RESPONSE = $tools::getMessageEmpty();
        }
    }
}



// Bloc des requêtes http DELETE
if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$DeleteById || $_REQUEST_ACTION == $_Action::$Delete) && $_REQUEST_METHOD == 'DELETE') {
    if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) {

        $_User->setAction($_REQUEST_ACTION);
        $_User->setUserid($_REQUEST['userid']);
        $_User -> setCreatedby($_REQUEST['createdby']);
        $_Response = $_ModelUser->CrudUser($_User);
        $_RESPONSE = $tools::getMessageSuccess($_Response);
    } else {
        $_RESPONSE = $tools::getMessageEmpty();
    }
}



// Bloc des requêtes http GET
if ($_REQUEST_METHOD == 'GET') {
    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$SelectAll || $_REQUEST_ACTION == $_Action::$SelectById)) {
        $_RESPONSE = GET_User($_REQUEST_ACTION, $_User, $_ModelUser, $tools);
    }
}


// Liste des fonctions
function GET_User($_ACTION, User $_User, moUser $_ModelUser, $tools)
{

    $_User->setAction($_ACTION);
    $_User->setUserid((isset($_REQUEST['userid']) &&
        !empty($_REQUEST['userid']) && $_REQUEST['userid'] != 'undefined') ?  $_REQUEST['userid'] : '');
    $_Response = $_ModelUser->CrudUser($_User);
    return $tools::getMessageResult($_Response != null && $_Response != 1 && sizeof($_Response) > 0 ? $_Response : array());
}

function PostOrPutUser($_ACTION, User $_User, moUser $_ModelUser, $tools)
{
    // Traitement de l'image
    $_fileName = (isset($_FILES['photo']) ? (substr($tools::generateGuid(), 0, 8) . strrchr($_FILES['photo']['name'], '.')) : $_REQUEST['oldfilename']);
    isset($_FILES['photo']) ? move_uploaded_file($_FILES['photo']['tmp_name'], ('../files/'.$_fileName)) : null;
    (isset($_FILES['photo']) && $_ACTION == 'UpdateById' && !empty($_REQUEST['oldfilename']) && $_REQUEST['oldfilename'] !== null) ? unlink('../../files/'.$_REQUEST['oldfilename']) : null;
    $_User->setAction($_ACTION);
    $_User->setUserid((isset($_REQUEST['userid']) && !empty($_REQUEST['userid']) && ($_REQUEST['userid'] != 'undefined') && ($_REQUEST['userid'] != null) && ($_REQUEST['userid'] != 'null')) ? $_REQUEST['userid'] : $tools::generateGuid());
    $_User->setNom($_REQUEST['nom']);
    $_User -> setPrenom($_REQUEST['prenom']);
    $_User->setPhoto($_fileName);
    $_User -> setPassword((isset($_REQUEST['password']) && !empty($_REQUEST['password']) && ($_REQUEST['password'] != 'undefined') && ($_REQUEST['password'] != null) && ($_REQUEST['password'] != 'null')) ? $_REQUEST['password'] : '');
    $_User -> setContact($_REQUEST['contact']);
    $_User -> setDatenaissance($_REQUEST['datenaissance']);
    $_User -> setEmail($_REQUEST['email']);
    $_User -> setLieuhabitation($_REQUEST['lieuhabitation']);
    $_User->setCodeuser($_REQUEST['codeuser']);
    $_User->setCreatedBy($_REQUEST['createdby']);

    $_Response = $_ModelUser->CrudUser($_User);
    return $tools::getMessageSuccess($_Response);
}


echo json_encode($_RESPONSE);


