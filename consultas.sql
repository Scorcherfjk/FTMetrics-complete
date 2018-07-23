SELECT TOP 1000
	   [OEEWorkCell].[lOEEConfigWorkCellId]
	  ,[OEEConfigWorkCell].[sShortName]
      ,[OEEWorkCell].[sPartId]
      ,[OEEWorkCell].[tStart]
      ,[OEEWorkCell].[tEnd]
      ,[OEEWorkCell].[dPartCount]
      ,[OEEWorkCell].[dTotalParts]
      ,[OEEWorkCell].[dScrapParts]
  FROM [FTMetrics].[dbo].[OEEWorkCell]
  JOIN [FTMetrics].[dbo].[OEEConfigWorkCell] 
  ON (	OEEWorkCell.lOEEConfigWorkCellId = 
		OEEConfigWorkCell.lOEEConfigWorkCellId)


SELECT TOP 10 
	[dTotalParts]
	,[dGoodParts]
	,[dScrapParts]
FROM [FTMetrics].[dbo].[OEEStateData]
WHERE [lOEEConfigWorkCellId]= 1000031

SELECT TOP 1000
	   OEEWorkCell.lOEEConfigWorkCellId
	  ,OEEConfigWorkCell.sShortName
      ,OEEWorkCell.sPartId
      ,OEEWorkCell.tStart
      ,OEEWorkCell.tEnd
      ,OEEWorkCell.dPartCount
      ,OEEWorkCell.dTotalParts
      ,OEEWorkCell.dScrapParts
  FROM [FTMetrics].[dbo].[OEEWorkCell], [FTMetrics].[dbo].[OEEConfigWorkCell]
  WHERE OEEWorkCell.lOEEConfigWorkCellId = OEEConfigWorkCell.lOEEConfigWorkCellId



SELECT top 10
	  OEEConfigWorkCell.sShortName
      ,OEEWorkCell.sPartId
      ,OEEWorkCell.tStart
      ,OEEWorkCell.tEnd
      ,OEEWorkCell.dPartCount
      ,OEEWorkCell.dTotalParts
      ,OEEWorkCell.dScrapParts
  FROM FTMetrics.dbo.OEEWorkCell, FTMetrics.dbo.OEEConfigWorkCell
  WHERE OEEWorkCell.lOEEConfigWorkCellId = 
		OEEConfigWorkCell.lOEEConfigWorkCellId


SELECT						
		TOP 1000						
		cwc.sShortName
		,wc.sPartId
        ,wc.tStart
        ,wc.tEnd
		,SUM(wc.dPartCount) AS dPartCount
		,SUM(wc.dTotalParts) AS dTotalParts
		,SUM(wc.dScrapParts) AS dScrapParts
	FROM FTMetrics.dbo.OEEWorkCell as wc
		,FTMetrics.dbo.OEEConfigWorkCell as cwc
	WHERE wc.lOEEConfigWorkCellId = cwc.lOEEConfigWorkCellId
	GROUP BY cwc.sShortName, wc.sPartId
	ORDER BY cwc.sShortName


SELECT 	
	cwc.sShortName
	,wc.sPartId
FROM FTMetrics.dbo.OEEWorkCell as wc
	,FTMetrics.dbo.OEEConfigWorkCell as cwc
WHERE wc.lOEEConfigWorkCellId = cwc.lOEEConfigWorkCellId
GROUP BY cwc.sShortName, wc.sPartId
ORDER BY cwc.sShortName



SELECT wc.lOEEWorkCellId,
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
						ORDER BY cwc.sShortName