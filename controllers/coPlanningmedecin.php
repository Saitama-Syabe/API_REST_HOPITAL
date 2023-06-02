<?php

require '../tools/tools.php';
require '../class/Planningmedecin.php';
require '../models/moPlanningmedecin.php';

$_Action = new Action();
$_Planningmedecin = new Planningmedecin();
$_ModelPlanningmedecin = new moPlanningmedecin();
$tools = new tools();
// bloc des requêtes http POST
if ($_REQUEST_METHOD == 'POST')
{

    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$Insert || $_REQUEST_ACTION == $_Action::$UpdateById)) {
        if (
            isset($_REQUEST['date']) && !empty($_REQUEST['date'])
            && isset($_REQUEST['heuredebut']) && !empty($_REQUEST['heuredebut'])
            && isset($_REQUEST['heurefin']) && !empty($_REQUEST['heurefin'])
            && isset($_REQUEST['createdby']) && !empty($_REQUEST['createdby']))
        {
            $_RESPONSE = PostOrPutPlanningmedecin($_REQUEST_ACTION, $_Planningmedecin, $_ModelPlanningmedecin, $tools);
        } else {
            $_RESPONSE = $tools::getMessageEmpty();
        }
    }
}



// Bloc des requêtes http DELETE
if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$DeleteById || $_REQUEST_ACTION == $_Action::$Delete) && $_REQUEST_METHOD == 'DELETE') {
    if (isset($_REQUEST['planningmedecinid']) && !empty($_REQUEST['planningmedecinid'])) {

        $_Planningmedecin->setAction($_REQUEST_ACTION);
        $_Planningmedecin->setPlanningmedecinid($_REQUEST['planningmedecinid']);
        $_Planningmedecin -> setCreatedby($_REQUEST['createdby']);
        $_Response = $_ModelPlanningmedecin->CrudPlanningmedecin($_Planningmedecin);
        $_RESPONSE = $tools::getMessageSuccess($_Response);
    } else {
        $_RESPONSE = $tools::getMessageEmpty();
    }
}



// Bloc des requêtes http GET
if ($_REQUEST_METHOD == 'GET') {
    if ($_REQUEST_ACTION != null && ($_REQUEST_ACTION == $_Action::$SelectAll || $_REQUEST_ACTION == $_Action::$SelectById)) {
        $_RESPONSE = GET_Planningmedecin($_REQUEST_ACTION, $_Planningmedecin, $_ModelPlanningmedecin, $tools);
    }
}


// Liste des fonctions
function GET_Planningmedecin($_ACTION, Planningmedecin $_Planningmedecin, moPlanningmedecin $_ModelPlanningmedecin, $tools)
{

    $_Planningmedecin->setAction($_ACTION);
    $_Planningmedecin->setPlanningmedecinid((isset($_REQUEST['planningmedecinid']) &&
        !empty($_REQUEST['planningmedecinid']) && $_REQUEST['planningmedecinid'] != 'undefined') ?  $_REQUEST['planningmedecinid'] : '');
    $_Response = $_ModelPlanningmedecin->CrudPlanningmedecin($_Planningmedecin);
    return $tools::getMessageResult($_Response != null && $_Response != 1 && sizeof($_Response) > 0 ? $_Response : array());
}

function PostOrPutPlanningmedecin($_ACTION, Planningmedecin $_Planningmedecin, moPlanningmedecin $_ModelPlanningmedecin, $tools)
{
    $_Planningmedecin->setAction($_ACTION);
    $_Planningmedecin->setPlanningmedecinid((isset($_REQUEST['planningmedecinid']) && !empty($_REQUEST['planningmedecinid']) && ($_REQUEST['planningmedecinid'] != 'undefined') && ($_REQUEST['planningmedecinid'] != null) && ($_REQUEST['planningmedecinid'] != 'null')) ? $_REQUEST['planningmedecinid'] : $tools::generateGuid());
    $_Planningmedecin->setDate($_REQUEST['date']);
    $_Planningmedecin -> setHeuredebut($_REQUEST['heuredebut']);
    $_Planningmedecin->setHeurefin($_REQUEST['heurefin']);
    $_Planningmedecin->setCreatedBy($_REQUEST['createdby']);

    $_Response = $_ModelPlanningmedecin->CrudPlanningmedecin($_Planningmedecin);
    return $tools::getMessageSuccess($_Response);


}


echo json_encode($_RESPONSE);


