<?php

include('./conexion.php');
include('./consultas.php');

/*$query = "SELECT TOP 10 
	[dTotalParts]
	,[dGoodParts]
	,[dScrapParts]
  FROM [FTMetrics].[dbo].[OEEStateData]
  WHERE [lOEEConfigWorkCellId]= 1000031";*/

$query = "  SELECT						
TOP 10						
cwc.sShortName
,wc.sPartId
,wc.tStart
,wc.tEnd
,wc.dPartCount
,wc.dTotalParts
,wc.dScrapParts
FROM FTMetrics.dbo.OEEWorkCell as wc
,FTMetrics.dbo.OEEConfigWorkCell as cwc
WHERE wc.lOEEConfigWorkCellId = cwc.lOEEConfigWorkCellId
ORDER BY cwc.sShortName";

$prep = sqlsrv_prepare($conn,$query);
//echo "prep ".$prep;

//echo "<br>";

$resultado = sqlsrv_execute($prep);
//echo "resultado ".$resultado;

echo "<br>";

$fila = sqlsrv_fetch_array($prep);
echo json_encode($fila);

echo "<br>";

echo($fila['tStart']->date);

echo $_POST['id'];

