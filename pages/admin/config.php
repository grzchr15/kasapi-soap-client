<?php

// URIs zu den WSDL-Dateien
$WSDL_AUTH = 'https://kasserver.com/schnittstelle/soap/wsdl/KasAuth.wsdl';
$WSDL_API = 'https://kasserver.com/schnittstelle/soap/wsdl/KasApi.wsdl';

// Logindaten
$kas_account = 'wxxxxxx';  // KAS-Logon ( main account or sub account)
$kas_user = 'wxxxxxx';  // KAS-Logon
$kas_pass = 'xxxxxxxxx';  // KAS-Passwort
$session_lifetime = 1800;  // Gültigkeit des Tokens in Sek. bis zur neuen Authentifizierung
$session_update_lifetime = 'Y'; // Soll bei jeder Aktion die Sessionlifetime wieder auf den
                                //   Wert in "$session_lifetime" gesetzt werden? ('Y' / 'N')

								//Not yet supported from thunderbird
$documentation_url="http://domain/webmail-einstellungen/";
$documentation_url2="http://domain/webmail-einstellungen//webmail-einstellungen/imap";


//Override default config with per sever creditentials								
$extra_config_file=dirname(__FILE__)."/"."config_".$_SERVER["SERVER_NAME"].".php";
if( is_readable ( $extra_config_file )){
	include_once ($extra_config_file);
}else{
	die("you need to config your ".dirname(__FILE__)."/"."config_".$_SERVER["SERVER_NAME"].".php");
}

?>