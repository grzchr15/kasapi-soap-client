<?php

namespace allinkl\Kasserver;
class KasserverAuth {
	var $CredentialToken;

	public function __construct(
		$WSDL_AUTH = 'https://kasserver.com/schnittstelle/soap/wsdl/KasAuth.wsdl',
		$kas_user = null,  // KAS-Logon
		$kas_pass = null,  // KAS-Passwort
		$session_lifetime = 1800,  // Gültigkeit des Tokens in Sek. bis zur neuen Authentifizierung
		$session_update_lifetime = 'Y'
	) {
		$this->printdebug( "KasserverAuth __construct WSDL_AUTH=". $WSDL_AUTH );
		if ( isset( $_SESSION["CredentialToken"] ) ) {

			$CredentialToken=$_SESSION["CredentialToken"];
		}else {

			 print_r(get_loaded_extensions (false ));

			try
			{
				$SoapLogon = new \SoapClient( $WSDL_AUTH );  // url zur wsdl - Datei
				$this->CredentialToken = $SoapLogon->KasAuth(
					array( 'KasUser' => $kas_user,
						'KasAuthType' => 'sha1',
						'KasPassword' => sha1( $kas_pass ),
						'SessionLifeTime' => $session_lifetime,
						'SessionUpdateLifeTime' => $session_update_lifetime
					)
				);
			}

			// Fehler abfangen und ausgeben
			catch ( SoapFault $fault ) {
				trigger_error( "errno: {$fault->faultcode},
	                    errmsg: {$fault->faultstring},
	                    erractor: {$fault->faultactor},
	                    errdetails: {$fault->detail}", E_USER_ERROR );
			}

		}

	}
	/**
	 * printdebug for this class
	 *
	 * @return string
	 */
	public function getCredentialToken( ) {
		return $this->CredentialToken;
	}
	/**
	 * printdebug for this class
	 *
	 * @return string
	 */
	public function printdebug( $msg ) {
		//echo $msg."</br>";
		return null;
	}
	
}





?>
