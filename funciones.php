<?php

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

function total($array, $columName) {
    return array_sum(array_column($array, $columName));
}

function validar($array1, $array2){

    if ($array1 != []){ 
        $Id = $array1[0]['lOEEConfigWorkCellId'] ;
        $partId = $array1[0]['sPartId'] ;
        $fechaI = $array1[0]['tStart']->date;
        $fechaF = end($array1)['tEnd']->date;
        $dTotalParts = total($array1, 'dTotalParts');
        $dPartCount = total($array1, 'dScrapParts');
        $dScrapParts = total($array1, 'dPartCount');
        $array = array($Id, $partId, $fechaI, $fechaF, $dTotalParts, $dPartCount, $dScrapParts);
        return $array;
    } elseif ($array2 != []){
        $Id = $array2[0]['lOEEConfigWorkCellId'] ;
        $partId = $array2[0]['sPartId'] ;
        $fechaI = $array2[0]['tStart']->date;
        $fechaF = end($array2)['tEnd']->date;
        $dTotalParts = total($array2, 'dTotalParts');
        $dPartCount = total($array2, 'dScrapParts');
        $dScrapParts = total($array2, 'dPartCount');
        $array = array($Id, $partId, $fechaI, $fechaF, $dTotalParts, $dPartCount, $dScrapParts);
        return $array;
    }
}
?>