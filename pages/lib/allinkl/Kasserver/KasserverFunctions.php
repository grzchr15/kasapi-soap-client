<?php

namespace allinkl\Kasserver;
class KasserverFunctions {
  var $CredentialToken;
  var $WSDL_API;
  public function __construct(
    $WSDL_API = 'https://kasserver.com/schnittstelle/soap/wsdl/KasApi.wsdl',
    $CredentialToken
  ) {
    $this->CredentialToken=$CredentialToken;
    $this->WSDL_API=$WSDL_API;
  }
  /**
   * kas_action_ratelimited
   *
   * @param kas_user
   * @param Params  empty
   * @return string
   */
  public function kas_action_ratelimited( $kas_user, $action, $Params ) {
    if ( isset( $_SESSION[$kas_user]['flood_protection'][$action] ) ) {
      $time_to_wait = $_SESSION[$kas_user]['flood_protection'][$action] - mktime();
    }else {
      $time_to_wait = 0;
    }
    if ( $time_to_wait >= 0 ) {
      usleep( intval( $time_to_wait*1000000 ) );
    }
    try{
      $SoapRequest = new \SoapClient( $this->WSDL_API );
      $req = $SoapRequest->KasApi( array(
          'KasUser' => $kas_user,                 // KAS-User
          'CredentialToken' => $this->CredentialToken,  // Authentifizierungs-Token
          'KasRequestType' => $action,     // API-Funktion
          'KasRequestParams' => $Params           // Parameter an die API-Funktion
        ) );
      error_log( 'calling kas_action_ratelimited ret='.print_r( $req, 1 ) );
      //$_SESSION[$kas_user]['flood_protection'][$action]
      if(isset($req["KasFloodDelay"])){
        error_log( 'calling kas_action_ratelimited ret='. $req["KasFloodDelay"] );
        $kas_flood_delay=$req["KasFloodDelay"];
      }else{
        $kas_flood_delay=2;
      }
      $_SESSION[$kas_user]['flood_protection'][$action] = mktime() + $kas_flood_delay + 0.1;
      
    }
    // Fehler abfangen und ausgeben
    catch ( SoapFault $fault ) {
      /* weiterwerfen der Exception */
      throw $fault;
    }
    return $req;
  }
  /**
   * get_accounts
   *
   * @param kas_user
   * @param Params  empty
   * @return string
   */
  public function get_accounts( $kas_user, $Params ) {
    try
    {
      $Params = array(); // Parameter für die API-Funktion
      error_log( 'calling kas_action_ratelimited '.'get_accounts' );
      $req = $this->kas_action_ratelimited( $kas_user, 'get_accounts', $Params );
      error_log( 'calling kas_action_ratelimited ret='.print_r( $req, 1 ) );

    }

    // Fehler abfangen und ausgeben
    catch ( SoapFault $fault ) {
      trigger_error( " Fehlernummer: {$fault->faultcode},
                        Fehlermeldung: {$fault->faultstring},
                        Verursacher: {$fault->faultactor},
                        Details: {$fault->detail}", E_USER_ERROR );
    }

    return $req;
  }

  /**
   * add_account
   *
   * @param kas_user
   * @param Params  empty
   * @return string
   */
  public function add_account( $kas_user, $Params ) {
    $req=null;
    try
    {
      // Parameter für die API-Funktion
      $Params = array(  'account_kas_password' => 'neues_kas_password',
        'account_ftp_password' => 'neues_ftp_password',
        'hostname_art' => 'domain',
        'hostname_part1' => 'meine2domain',
        'hostname_part2' => 'de',
        'max_account' => '0',
        'max_domain' => '0',
        'max_subdomain' => '3',
        'max_webspace' => '357',
        'max_mail_account' => '2',
        'max_mail_forward' => '0',
        'max_mailinglist' => '2',
        'max_database' => '4',
        'max_ftpuser' => '0',
        'inst_htaccess' => 'N',
        'inst_fpse' => 'Y',
        'inst_software' => 'N',
        'kas_access_forbidden' => 'N',
        'logging' => 'keine',
        'account_comment' => 'kommentar',
        'max_cronjobs'  => '2' );
      $req = $this->kas_action_ratelimited( $kas_user, 'add_account', $Params );
    }

    // Fehler abfangen und ausgeben
    catch ( SoapFault $fault ) {
      trigger_error( " Fehlernummer: {$fault->faultcode},
                    Fehlermeldung: {$fault->faultstring},
                    Verursacher: {$fault->faultactor},
                    Details: {$fault->detail}", E_USER_ERROR );
    }
    return $req;
  }
  /**
   * get_mailaccounts
   *
   * @param kas_user
   * @param mail_login_user optionale Parameter
   * @return object mailaccounts
   */
  public function get_mailaccounts( $kas_user, $mail_login = null, $Params ) {
    $Params = array(  'mail_login' => $mail_login
    );
    $req=null;
    try{
      $req = $this->kas_action_ratelimited( $kas_user, 'get_mailaccounts', $Params );
    }

    // Fehler abfangen und ausgeben
    catch ( SoapFault $fault ) {
      trigger_error( " Fehlernummer: {$fault->faultcode},
                    Fehlermeldung: {$fault->faultstring},
                    Verursacher: {$fault->faultactor},
                    Details: {$fault->detail}", E_USER_ERROR );
    }

    return $req;
  }
}

?>
