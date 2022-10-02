<?php

 
// define the root path session_start(); to the admin folder
define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/DecoBz/back-hydrex/');
session_start();
// define the root URL to the admin section
define('ROOT_URL', '/DecoBz/back-hydrex/');

define('ROOT_WEB', $_SERVER['DOCUMENT_ROOT'].'/DecoBz/back-hydrex/');
// define the root URL to the admin section
define('ROOT_WEB_URL', '/DecoBz/back-hydrex/');
// Authentication SALT
define('SALT', 'Ku23ao+(f%bxh|k?4ee4<+?%B$-<2_#%IpwU4]+o2l+xmXGHL0_h}+1m$QnL.pIu');

define("GOOGLE_API_KEY", "AIzaSyCJv1rcp27x4fIozXjFOUT7u-s-sk-oZqk");


/*config
*************/
$ConfigDefault = array('filedefnum'=>10);

include_once ROOT.'language/'.htmlspecialchars("fr_FR").'.php';
// include common file
include_once ROOT.'includes/library.php';
// include database class
include_once ROOT.'includes/class.database.php';
 
define('HOSTNAME','Localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','hydrexin_hy');

// admin email address
define('ADMINISTRATOR_EMAIL','');


define('TEXT_TYPE','text');
define('INT_TYPE','int');
define('FLOAT_TYPE','float');
define('BUTTON_TYPE','bouton');




/*defaut langue*/
$db = db_connect(); 
$lang_default = $db->get_row("SELECT lang.* FROM lang WHERE lang.id_lang='1'");