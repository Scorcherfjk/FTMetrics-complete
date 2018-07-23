<?php

function defaultQuery()
{
    $query = "SELECT 							
            TOP 1000						
            cwc.sShortName
            ,wc.sPartId
            ,SUM(wc.dPartCount) AS dPartCount
            ,SUM(wc.dTotalParts) AS dTotalParts
            ,SUM(wc.dScrapParts) AS dScrapParts
        FROM FTMetrics.dbo.OEEWorkCell as wc
            ,FTMetrics.dbo.OEEConfigWorkCell as cwc
        WHERE wc.lOEEConfigWorkCellId = cwc.lOEEConfigWorkCellId
        GROUP BY cwc.sShortName, wc.sPartId
        ORDER BY cwc.sShortName";

    return $query;
}

function primaryQuery($opcion,$inicio,$final)
{
    $query = "SELECT wc.lOEEWorkCellId,
            cwc.sShortName,
            wc.sPartId,
            wc.tStart,
            wc.tEnd,
            wc.dPartCount,
            wc.dTotalParts,
            wc.dScrapParts
        FROM FTMetrics.dbo.OEEWorkCell as wc
        ,FTMetrics.dbo.OEEConfigWorkCell as cwc
        WHERE wc.lOEEConfigWorkCellId = cwc.lOEEConfigWorkCellId
            AND wc.lOEEConfigWorkCellId = $opcion
            AND (wc.tStart >= '$inicio' OR wc.tEnd <= '$final')
            AND NOT (wc.tStart < '$inicio' OR wc.tEnd > '$final')
        ORDER BY wc.tStart";

    return $query;
}

function dropDown(){
    $query ="SELECT cwc.sShortName as ssn, wc.lOEEConfigWorkCellId as icwc
            FROM FTMetrics.dbo.OEEWorkCell as wc, 
                FTMetrics.dbo.OEEConfigWorkCell as cwc
            WHERE wc.lOEEConfigWorkCellId = cwc.lOEEConfigWorkCellId
            GROUP BY cwc.sShortName, wc.lOEEConfigWorkCellId 
            ORDER BY cwc.sShortName ";

    return $query;   
}
    

?>