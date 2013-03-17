<?php
 /**
   * printdebug for this class
   *
   * @return string
   */
   function printecho( $msg ) {
    echo $msg;
    return null;
  }
 	function printdebug( $msg ) {
    //echo $msg."</br>";
    return null;
  }
  function printhtml( $msg ) {
    echo htmlentities($msg)."</br>";
    return null;
  }
	function printhtmlentities( $msg ) {
		//string htmlentities ( string $string [, int $flags = ENT_COMPAT | ENT_HTML401 [, string $encoding = 'UTF-8' [, bool $double_encode = true ]]] )
    echo htmlentities($msg);
    return null;
  }
  $arge_dlog_counter=0;
function arge_dlog($msg)
{
	global $arge_dlog_counter;
	$ip = getenv ("REMOTE_ADDR"); // get the ip number of the user
	$mynow = date("Ymd-His");                           
	$somecontent=$mynow." ".$ip." ".$arge_dlog_counter." ".$msg;
	//echo "arge_dlog ".$somecontent."<br />\n";
	if(1){
		error_log(somecontent);
	}
  if( 0 )
  {
	  $arge_dlog_counter=$arge_dlog_counter+1;
	  $filename=dirname(__FILE__)."/dlog.log";
		$fp=fopen($filename,"a+");
		
		//echo  $filename."-".$somecontent."<br />\n";
		// Write $somecontent to our opened file. 
	  if (!fwrite($fp, $somecontent."\n")) 
	  { 
			print "Cannot write to file ($filename)"; 
	    // exit; 
	  } 
	  fclose($fp);
	} 
}

?>