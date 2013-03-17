<?php

// URIs zu den WSDL-Dateien
$WSDL_AUTH = 'https://kasserver.com/schnittstelle/soap/wsdl/KasAuth.wsdl';
$WSDL_API = 'https://kasserver.com/schnittstelle/soap/wsdl/KasApi.wsdl';

$HTTP_HOST=$_SERVER["HTTP_HOST"];

$pieces = explode(".", $HTTP_HOST);

$maildomain="";
for( $ii =1  ; $ii < sizeof($pieces) ; $ii++ ){
	$maildomain.=$pieces[$ii];
	if( $ii < sizeof($pieces)-1) 	$maildomain.=".";
	
}
// Domain is calculated dynamic to remove autoconfig.maildomain part
// Logindaten
$kas_account = 'wxxxxxx';  // KAS-Logon ( main account or sub account)
$kas_user = 'wxxxxxx';  // KAS-Logon
$kas_pass = 'xxxxxxxxx';  // KAS-Passwort
$session_lifetime = 1800;  // Gültigkeit des Tokens in Sek. bis zur neuen Authentifizierung
$session_update_lifetime = 'Y'; // Soll bei jeder Aktion die Sessionlifetime wieder auf den
                                //   Wert in "$session_lifetime" gesetzt werden? ('Y' / 'N')

								//Not yet supported from thunderbird
$documentation_url="http://$maildomain./webmail-einstellungen/";
$documentation_url2="http://$maildomain./webmail-einstellungen//webmail-einstellungen/imap";

$config_search_for_mail_login=0;  //if you want to unhide mail_login then add $search_for_mail_login=1; to your local config
//This is a information disclosure as it make more information visible. ( Only Passwords protect then your Mail accounts, so use strong ones

//Override default config with per sever creditentials								
$extra_config_file=dirname(__FILE__)."/"."config_".$_SERVER["SERVER_NAME"].".php";
if( is_readable ( $extra_config_file )){
	include_once ($extra_config_file);
}else{
	die("you need to config your ".dirname(__FILE__)."/"."config_".$_SERVER["SERVER_NAME"].".php");
}

?>