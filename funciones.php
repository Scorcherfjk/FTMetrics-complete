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

?>