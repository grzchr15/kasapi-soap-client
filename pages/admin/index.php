<?php
/**
 * Admin Interface
 *
 * @author christian.bretterhofer@andritz.com
 * 
 */
 
 
//Donot delete the next line, this causes a big security issue ( only try it a a local copy of this programm and not on a public exposed webserver 
die("Access denied");

require_once dirname( __FILE__ ) . '/../lib/SplClassLoader.php';
require_once dirname( __FILE__ ) . '/' . 'config.php';

$classLoader = new SplClassLoader( 'allinkl\Kasserver', dirname( __FILE__ ) . '/../lib/' );
$classLoader->register();
//$classLoader->setNamespaceSeparator('/');

use allinkl\Kasserver\KasserverAuth;
$KasserverAuth = new KasserverAuth(
	$WSDL_AUTH,
	$kas_user,  // KAS-Logon
	$kas_pass,  // KAS-Passwort
	$session_lifetime,  // Gültigkeit des Tokens in Sek. bis zur neuen Authentifizierung
	$session_update_lifetime

);
//print_r($KasserverAuth);
//$CredentialToken;

echo "KasserverAuth->getCredentialToken(".$KasserverAuth->getCredentialToken();

$kf = new allinkl\Kasserver\KasserverFunctions(
	$WSDL_API,
	$KasserverAuth->getCredentialToken()
	);

$Params = array(  'param_name' => 'param_value');

$req=$kf->get_accounts($kas_user,$Params);
echo "<pre>accounts\n";
  print_r($req);
  echo "</pre?>";




$req=$kf->get_mailaccounts($kas_user,null,$Params);
echo "<pre>mailaccounts:\n";
  print_r($req);
  echo "</pre?>";

?>
