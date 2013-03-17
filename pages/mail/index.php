<?php

require_once dirname( __FILE__ ) . '/../lib/SplClassLoader.php';
require_once dirname( __FILE__ ) . '/../admin/' . 'config.php';
require_once dirname( __FILE__ ) . '/../admin/' . 'printutils.php';


 
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

//echo "KasserverAuth->getCredentialToken(".$KasserverAuth->getCredentialToken();

$kf = new allinkl\Kasserver\KasserverFunctions(
	$WSDL_API,
	$KasserverAuth->getCredentialToken()
	);

$Params = array(  'param_name' => 'param_value');

///mail/config-v1.1.xml?emailaddress=somemail@somedomain.com

$emailaddress="undefined";
$mail_login="search at your  account data"; // "%EMAILADDRESS%";

if ( isset( $_GET["emailaddress"] ) ) {
	$emailaddress=$_GET["emailaddress"];
	$req=$kf->get_mailaccounts( $kas_user, $emailaddress, $Params );
	if(0){
	  printecho ("<hr><pre>mailaccounts:\n");
	  printecho (print_r($req,1));
	  printecho ("</pre?>");
	}
 $found_emailaddress=0;
	if ( isset( $req["Response"] ) ) {
		if ( isset( $req["Response"]["ReturnInfo"] ) ) {
			 $req_lenght=$max = sizeof( $req["Response"]["ReturnInfo"] );
				printdebug ("ReturnInfo cnt=".$req_lenght." emailaddress=".$emailaddress);
				for ( $ii=0;$ii<$req_lenght;$ii++ ) {
					$search_emailaddress=$req["Response"]["ReturnInfo"][$ii]["mail_adresses"];		
					//printdebug "mail_login=".$req["Response"]["ReturnInfo"][$ii]["mail_login"]."</br>";
					//printdebug "mail_adresses=".$req["Response"]["ReturnInfo"][$ii]["mail_adresses"]."</br>";
					if($emailaddress == $search_emailaddress){
						printdebug ("found search_emailaddress for ".$req["Response"]["ReturnInfo"][$ii]["mail_login"]);
						$mail_login=$req["Response"]["ReturnInfo"][$ii]["mail_login"];
						$found_emailaddress=1;
					}
				}
				if(!$found_emailaddress)
				{
					
					//printdebug ("response from kasserver emailaddress=".$emailaddress." Not found. Please contact your sysadmin ");
				}
		}
		else {
			printecho ("response from kasserver underclear.".print_r($req,1));
		}
	}
	else {
			printecho ("response from kasserver underclear.".print_r($req,1));
	}
	


}else {
	printhtml ("missing emailaddress");
}



$HTTP_HOST=$_SERVER["HTTP_HOST"];
$HTTP_USER_AGENT=$_SERVER["HTTP_USER_AGENT"];
$DOCUMENT_ROOT=$_SERVER["DOCUMENT_ROOT"];
$SERVER_ADMIN=$_SERVER["SERVER_ADMIN"];
$SCRIPT_FILENAME=$_SERVER["SCRIPT_FILENAME"];
$REQUEST_URI=$_SERVER["REQUEST_URI"];





$str = <<<EODEOD
<?xml version="1.0" encoding="UTF-8"?>

<clientConfig version="1.1">
  <emailProvider id="volkstanz.st">
    <domain>volkstanz.st</domain>
    <displayName>volkstanz.st Mail</displayName>
    <displayShortName>volkstanz.st</displayShortName>
    <incomingServer type="imap">
      <hostname>$kas_account.kasserver.com</hostname>
      <port>993</port>
      <socketType>SSL</socketType>
      <authentication>password-encrypted</authentication>
      <username>$mail_login</username>
    </incomingServer>
    <incomingServer type="imap">
      <hostname>$kas_account.kasserver.com</hostname>
      <port>143</port>
      <socketType>STARTTLS</socketType>
      <authentication>password-encrypted</authentication>
      <username>$mail_login</username>
    </incomingServer>
    <incomingServer type="pop3">
      <hostname>$kas_account.kasserver.com</hostname>
      <port>995</port>
      <socketType>SSL</socketType>
      <authentication>password-cleartext</authentication>
      <username>$mail_login</username>
    </incomingServer>
    <incomingServer type="pop3">
      <hostname>$kas_account.kasserver.com</hostname>
      <port>110</port>
      <socketType>STARTTLS</socketType>
      <authentication>password-cleartext</authentication>
      <username>$mail_login</username>
    </incomingServer>
    <outgoingServer type="smtp">
      <hostname>$kas_account.kasserver.com</hostname>
      <port>465</port>
      <socketType>SSL</socketType>
      <authentication>password-encrypted</authentication>
      <username>$mail_login</username>
    </outgoingServer>
    <outgoingServer type="smtp">
      <hostname>$kas_account.kasserver.com</hostname>
      <port>587</port>
      <socketType>STARTTLS</socketType>
      <authentication>password-encrypted</authentication>
      <username>$mail_login</username>
    </outgoingServer>
    <documentation url="$documentation_url">
      <descr lang="de">Allgemeine Beschreibung der Einstellungen</descr>
      <descr lang="en">Generic settings page</descr>
    </documentation>
    <documentation url="$documentation_url2">
      <descr lang="de">TB 2.0 IMAP-Einstellungen</descr>
      <descr lang="en">TB 2.0 IMAP settings</descr>
    </documentation>
  </emailProvider>
</clientConfig>



EODEOD;


  

if(isset($_GET["file"]))
{
	if(isset($_GET["emailaddress"]))
	{
	  if(!$found_emailaddress)
		{
			
			printhtml ("response from kasserver emailaddress=".$emailaddress." Not found. Please contact your sysadmin ");
		}else{
			header('Content-type: application/xml');
			echo $str;
		}
	}else{
		//header('Content-type: application/xml');
		printhtml ("missing ?emailaddress");
		
		printhtml ($str);
	
	}
}else{
	$str="Usage: Thunderbird autoconfiguration ".$_SERVER["HTTP_HOST"]."/mail/config-v1.1.xml?emailaddress=someemail@".$_SERVER["HTTP_HOST"];
	printhtml ($str);
	phpinfo();
}


?>
