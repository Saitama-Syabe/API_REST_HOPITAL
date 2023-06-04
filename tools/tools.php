<?php

/**
 * Created by PhpStorm.
 * User: Syabe_MJ
 * Date: 11/26/2021
 * Time: 10:16 AM
 */
session_cache_limiter(10);
session_cache_expire(10);

session_start();

// Autorisation des requêtes http multi origins
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

// Declaration des variables globales
$_RESPONSE = array(
    'status'=>true,
    'donnees'=>array(),
    'message'=>'Aucune action réconnue demandé par la requete ajax',
);
class tools
{
    /**
     * Récupération du domaine
     */
    public static function getDomaine() {
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/API_REST_GMAO/";
    }
    public static function getMessageEmpty(){
        $_RESPONSE['message'] = 'veuillez remplir tous les champs avec * SVP...';
        $_RESPONSE['status'] = true;
        $_RESPONSE['donnes'] = null;
        return $_RESPONSE;
    }

    /**
     * function to call if the insert or update operation is successful
     *
     * if $response = 1; the operation is successful otherwise failed
     * @param $response string
     * @return array
     */
    public static function getMessageSuccess($response){
        if($response == 1)
        {
            $_RESPONSE['message'] = 'Opération éffectuée avec succès';
            $_RESPONSE['status'] = false;
        }
        else{
            $_RESPONSE['message'] = 'Erreur lors de l\'opération. Veuillez contacter l\'administrateur.';
            $_RESPONSE['status'] = true;
        }
        $_RESPONSE['donnes'] = null;
        return $_RESPONSE;
    }

    /**
     * function to be called if the selection operation is successful
     * @param array $response
     * @return array
     */
    public static function getMessageResult(array $response){

        if(sizeof($response) <= 0)
        {
            $_RESPONSE['message'] = 'Aucun élement trouvé dans le système';
            $_RESPONSE['status'] = true;
            $_RESPONSE['donnes'] = null;
        }
        elseif (sizeof($response)== 1)
        {
            //One Item result
            $_RESPONSE['donnees'] = $response;
            $_RESPONSE['message'] = '01 élement(s) trouvé(s) dans le système';
            $_RESPONSE['status'] = false;
        }elseif (sizeof($response)> 1)
        {
            $_RESPONSE['status'] = false;
            $_RESPONSE['donnees'] = $response;
            $_RESPONSE['message'] = (sizeof($response) < 9 ? '0'.sizeof($response) : sizeof($response)) .' élement(s) trouvée(s) dans le système';
        }
        else
        {
            $_RESPONSE['message'] = 'Opération éffectuée avec succès';
            $_RESPONSE['status'] = false;
            $_RESPONSE['donnes'] = null;
        }
        return $_RESPONSE;
    }

    /**
     * function to generate a unique id of type uuid
     * @return string
     */
    public static function generateGuid() {
        $uuid = array(
            'time_low' => 0,
            'time_mid' => 0,
            'time_hi' => 0,
            'clock_seq_hi' => 0,
            'clock_seq_low' => 0,
            'node' => array()
        );

        $uuid['time_low'] = mt_rand(0, 0xffff) + (mt_rand(0, 0xffff) << 16);
        $uuid['time_mid'] = mt_rand(0, 0xffff);
        $uuid['time_hi'] = (4 << 12) | (mt_rand(0, 0x1000));
        $uuid['clock_seq_hi'] = (1 << 7) | (mt_rand(0, 128));
        $uuid['clock_seq_low'] = mt_rand(0, 255);

        for ($i = 0; $i < 6; $i++) {
            $uuid['node'][$i] = mt_rand(0, 255);
        }
        $toReturn = sprintf('%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x', $uuid['time_low'], $uuid['time_mid'], $uuid['time_hi'], $uuid['clock_seq_hi'], $uuid['clock_seq_low'], $uuid['node'][0], $uuid['node'][1], $uuid['node'][2], $uuid['node'][3], $uuid['node'][4], $uuid['node'][5]);
        return $toReturn;
    }


    /**
     * function to format the date and time in French short format (01/01/2001 12:00:00)
     * @return string
     */
    public static function dateformatFrenchLong($initialdate) {
        $outdate = date_create($initialdate);
        return date_format($outdate, 'd/m/Y H:i:s');
    }

    /**
     * function to format the date in French short format (01-01-2001)
     * @param string
     * @return string
     */
    public static function dateformatFrenchShort($initialdate) {
        $outdate = date_create($initialdate);
        return date_format($outdate, 'd-m-Y');
    }


    public static function getMessageError(array $response){
        //print_r(sizeof($response));
        if(sizeof($response) <= 0)
        {
            //Nothing Item result
            $_RESPONSE['message'] = 'Aucun élement trouvé dans le système';
            $_RESPONSE['status'] = true;
            $_RESPONSE['donnes'] = null;
        }
        elseif (sizeof($response)== 1)
        {
            //One Item result
            $_RESPONSE['donnees'] = $response;
            $_RESPONSE['message'] = '01 élement(s) trouvé(s) dans le système';
            $_RESPONSE['status'] = false;

        }elseif (sizeof($response)> 1)
        {
            $_RESPONSE['status'] = false;
            $_RESPONSE['donnees'] = $response;
            $_RESPONSE['message'] = (sizeof($response) < 9 ? '0'.sizeof($response) : sizeof($response)) .' élement(s) trouvée(s) dans le système';
        }
        else
        { //Nothing Item result
            $_RESPONSE['message'] = 'Opération éffectuée avec succès';
            $_RESPONSE['status'] = false;
            $_RESPONSE['donnes'] = null;
        }
        // print_r($_RESPONSE);
        return $_RESPONSE;
    }


    /**
     * function to get the user's IP address
     * @return string
     */
    public static function getIpAddresse() {

        $http_x = 'HTTP_X_FORWARDED_FOR';
        $http_client = 'HTTP_CLIENT_IP';
        $remote = 'REMOTE_ADDR';

        if (getenv($http_x)) {
            return getenv($http_x);
        } elseif (getenv($http_client)) {
            return getenv($http_client);
        } else {
            return getenv($remote);
        }
    }

    /**
     * function to format the date from English format to French format
     * @param string $englishdate date au format anglais
     * @return string
     */
    public static function dateEnglishToFrench($englishdate = '0000-00-00')
    {
        if ($englishdate != '0000-00-00') {
            list($year, $month, $day) = explode('-', $englishdate);
            return $day . '-' . $month . '-' . $year;
        }
    }

    /**
     * function to format the date from French format to English long format
     * @param string $frenchdate date au format anglais
     * @return string
     */
    public static function dateFrenchToEnglish($frenchdate= '00-00-0000 00:00:00')
    {
        if ($frenchdate != '00-00-0000 00:00:00') {
            list($dateAnnee, $dateHeure) = explode(' ', $frenchdate);
            list($jour, $mois, $annee) = explode('-', $dateAnnee);
            //print_r($annee);
            return $annee . '-' . $mois . '-' .$jour.' '.$dateHeure;
        }
    }
}

/** Function pour gérer les uploads multiple de fichiers
 * @param array $_files
 * @param bool $top
 * @return array
 */
function multiple(array $_files, bool $top = TRUE): array
{
    $files = array();
    foreach($_files as $name=>$file){
        if($top) $sub_name = $file['name'];
        else    $sub_name = $name;

        if(is_array($sub_name)){
            foreach(array_keys($sub_name) as $key){
                $files[$name][$key] = array(
                    'name'     => $file['name'][$key],
                    'type'     => $file['type'][$key],
                    'tmp_name' => $file['tmp_name'][$key],
                    'error'    => $file['error'][$key],
                    'size'     => $file['size'][$key],
                );
                $files[$name] = multiple($files[$name], FALSE);
            }
        }
        else{
            $files[$name] = $file;
        }
    }
    return $files;
}

global $_REQUEST_BDENAME;
$tools = new tools();
$_REQUEST_ACTION =  isset($_REQUEST['Action']) ? $_REQUEST['Action'] : null;
$_REQUEST_BDENAME = isset($_REQUEST['bdname']) ? $_REQUEST['bdname'] : null;
$_REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
$_newuuid = $tools::generateGuid();
