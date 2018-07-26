<?php

function total($array, $columName) 
{   
    $valor = floatval(array_sum(array_column($array, $columName)));
    return strval($valor);
}

function validationSetNullDual($var1, $var2)
{
    if (isset($var1) && $var1 != "" && isset($var2) && $var2 != ""){
        return true;
    }
    else{
        return false;        
    }
}

function validationSetNullSimple($var1)
{
    if (isset($var1) && $var1 != ""){
        return true;
    }
    else{
        return false;        
    }
}

function validar($array1, $array2)
{

    if ($array1 != []){
        json_encode($array1);
        $Id = $array1[0]['lOEEConfigWorkCellId'] ;
        $shortName = $array1[0]['sShortName'] ;
        $partId = $array1[0]['sPartId'] ;
        $fechaI = substr($array1[0]['tStart']->date, 0, 19);
        $fechaF = substr(end($array1)['tEnd']->date, 0, 19);
        $dTotalParts = (strpos(total($array1, 'dTotalParts'), '.')) ?
                        substr(total($array1, 'dTotalParts'), 0 , strpos(total($array1, 'dTotalParts'), '.'))
                        .substr(total($array1, 'dTotalParts'), strrpos (total($array1, 'dTotalParts', ".") , 3)) : 
                        total($array1, 'dTotalParts');
        $dScrapParts = (strpos(total($array1, 'dScrapParts'), '.')) ?
                        substr(total($array1, 'dScrapParts'), 0 , strpos(total($array1, 'dScrapParts'), '.'))
                        .substr(total($array1, 'dScrapParts'), strrpos (total($array1, 'dScrapParts', ".") , 3)) : 
                        total($array1, 'dScrapParts');
        $dPartCount = (strpos(total($array1, 'dPartCount'), '.')) ? 
                        substr(total($array1, 'dPartCount'), 0 , strpos(total($array1, 'dPartCount'), '.'))
                        .substr(total($array1, 'dPartCount'), strrpos (total($array1, 'dPartCount', ".") , 3)) : 
                        total($array1, 'dPartCount') ;
        $array = array( 'lOEEConfigWorkCellId' => $Id, 
                        'sShortName' => $shortName,
                        'sPartId' =>  $partId,
                        'tStart' => $fechaI,
                        'tEnd' => $fechaF,
                        'dTotalParts' => $dTotalParts,
                        'dScrapParts' =>  $dScrapParts,
                        'dPartCount' =>  $dPartCount
                    );

        return $array;

    } 
    elseif ($array2 != []){

        json_encode($array2);
        $Id = $array2[0]['lOEEConfigWorkCellId'] ;
        $shortName = $array2[0]['sShortName'] ;
        $partId = $array2[0]['sPartId'] ;
        $fechaI = substr($array2[0]['tStart']->date, 0, 19);
        $fechaF = substr(end($array2)['tEnd']->date, 0, 19);
        $dTotalParts = (strpos(total($array2, 'dTotalParts'), '.')) ?
                        substr(total($array2, 'dTotalParts'), 0 , strpos(total($array2, 'dTotalParts'), '.'))
                        .substr(total($array2, 'dTotalParts'), strrpos (total($array2, 'dTotalParts', ".") , 3)) : 
                        total($array2, 'dTotalParts');
        $dScrapParts = (strpos(total($array2, 'dScrapParts'), '.')) ?
                        substr(total($array2, 'dScrapParts'), 0 , strpos(total($array2, 'dScrapParts'), '.'))
                        .substr(total($array2, 'dScrapParts'), strrpos (total($array2, 'dScrapParts', ".") , 3)) : 
                        total($array2, 'dScrapParts');
        $dPartCount = (strpos(total($array2, 'dPartCount'), '.')) ?
                        substr(total($array2, 'dPartCount'), 0 , strpos(total($array2, 'dPartCount'), '.'))
                        .substr(total($array2, 'dPartCount'), strrpos (total($array2, 'dPartCount', ".") , 3)) : 
                        total($array2, 'dPartCount'); 
        $array = array( 'lOEEConfigWorkCellId' => $Id, 
                        'sShortName' => $shortName,
                        'sPartId' =>  $partId,
                        'tStart' => $fechaI,
                        'tEnd' => $fechaF,
                        'dTotalParts' => $dTotalParts,
                        'dScrapParts' =>  $dScrapParts,
                        'dPartCount' =>  $dPartCount
                    );

        return $array;
    }
}
?>