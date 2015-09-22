<?php

function FileWriter($_file, $_content)
{
    if(!file_exists($_file) || !is_writable($_file))
        return FALSE;
    
    $data = implode(',', $_content) . "\r\n";
    if((file_put_contents($_file, $data, FILE_APPEND))!== FALSE){
        return FALSE;
    }else{
        return TRUE;
    }
}

?>