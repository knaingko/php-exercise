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

function DeleteData($_file, $_value)
{
    //Create Temp file
    $fptemp = fopen('./data/temp.csv', "a+");
 
    if (($handle = fopen($_file, "r")) !== FALSE) {
        while (($data= fgetcsv($handle)) !== FALSE) {
            
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            if ($data[0] != $_value ){
                $list = array($data);
                fputcsv($fptemp, $list);
            }
        }
    }
    fclose($handle);
    fclose($fptemp);
    //unlink($_file);
    //rename('./data/temp.csv',$_file);
}
?>