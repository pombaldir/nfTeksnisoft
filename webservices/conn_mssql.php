<?php if (basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__)) {
    header('HTTP/1.0 403 Forbidden');
    exit('Forbidden');
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$serverName = "192.168.1.95"; //serverName\instanceName
$database="Emp_NFER";
$dbuser="sa";
$dbpass="platinum";

$tokenAPI="5f[Y?z?*LkmgJ[R*";
/*$arrexcluir=array();


$link = mssql_connect("$serverName:1433", "$dbuser", "$dbpass");

if (!$link) {
    die('Erro ao ligar ao servidor MSSQL');
}
mssql_select_db($database, $link);

#  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  
function query($sQuery, $hDb_conn, $sError, $bDebug)
{
    if(!$rQuery = @mssql_query($sQuery, $hDb_conn))
    {
        $sMssql_get_last_message = mssql_get_last_message();
        $sQuery_added  = "BEGIN TRY\n";
        $sQuery_added .= "\t".$sQuery."\n";
        $sQuery_added .= "END TRY\n";
        $sQuery_added .= "BEGIN CATCH\n";
        $sQuery_added .= "\tSELECT 'Error: '  + ERROR_MESSAGE()\n";
        $sQuery_added .= "END CATCH";
        $rRun2= @mssql_query($sQuery_added, $hDb_conn);
        $aReturn = @mssql_fetch_assoc($rRun2);
        if(empty($aReturn))
        {
            return $sError.'. MSSQL returned: '.$sMssql_get_last_message.'.<br>Executed query: '.nl2br($sQuery);
        }
        elseif(isset($aReturn['computed']))
        {
            return $sError.'. MSSQL returned: '.$aReturn['computed'].'.<br>Executed query: '.nl2br($sQuery);
        }
        return FALSE;
    }
    else
    {
        return $rQuery;
    }
}


*/


 
##########################################################################################################
require_once dirname(__DIR__) . '/vendors/autoload.php';
 
// Using Medoo namespace
use Medoo\Medoo;

$database = new Medoo([
	'database_type' => 'mssql',
	'database_name' => ''.$database.'',
	'server' => ''.$serverName.'',
	'username' => ''.$dbuser.'',
	'password' => ''.$dbpass.'',
	'driver' => 'php_pdo_sqlsrv',
	"charset" => "utf8",
	"port" => "1433",
	"logging" => true
	]);
  
?> 