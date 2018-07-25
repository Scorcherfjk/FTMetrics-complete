<?php
	//conexion a la base de datos MsSQL
	$serverName = "W2K12XPOC";
	$connectionInfo = array( "Database"=>"FTMetrics", "UID"=>"FTMUser", "PWD"=>"FTMUser");
	if (sqlsrv_connect( $serverName, $connectionInfo)){
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
	}
?>