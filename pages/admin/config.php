<?php

// URIs zu den WSDL-Dateien
$WSDL_AUTH = 'https://kasserver.com/schnittstelle/soap/wsdl/KasAuth.wsdl';
$WSDL_API = 'https://kasserver.com/schnittstelle/soap/wsdl/KasApi.wsdl';

// Logindaten
$kas_user = 'wxxxxxx';  // KAS-Logon
$kas_pass = 'xxxxxxxxx';  // KAS-Passwort
$session_lifetime = 1800;  // Gültigkeit des Tokens in Sek. bis zur neuen Authentifizierung
$session_update_lifetime = 'Y'; // Soll bei jeder Aktion die Sessionlifetime wieder auf den
                                //   Wert in "$session_lifetime" gesetzt werden? ('Y' / 'N')

//Override default config with per sever creditentials								
$extra_config_file=dirname(__FILE__)."/"."config_".$_SERVER["SERVER_NAME"].".php";
include_once ($extra_config);
?>