<?php
    function GetAllData($file){
        $result = array();
        $delimiter = ',';
        $header = NULL;

        if(!file_exists($file) || !is_readable($file)) return FALSE;
        if (($handle = fopen($file, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $result[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $result;
    }

    function GetDataByKey($file, $Key, $Value){
        $result = array();
        $delimiter = ',';
        $headerIndex = 0;
        $header = NULL;

        if(!file_exists($file) || !is_readable($file)) return FALSE;
        if (($handle = fopen($file, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header) {
                    $header = $row;
                    $headerIndex= array_search($Key,$header);
                }else{
                    if($row[$headerIndex] == $Value)
                    {
                        $result= array_combine($header, $row);
                    }
                }
            }
            fclose($handle);
        }
        return $result;
    }

    function InsertData($file, $_data)
    {
        if(!file_exists($file) || !is_writable($file))
            return FALSE;

        $data = implode(',', $_data) . "\r\n";
        if((file_put_contents($file, $data, FILE_APPEND))!== FALSE){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function UpdateDataByKey($file, $Key, $value, $data)
    {
        $delimiter = ',';
        $headerIndex = 0;
        $header = NULL;
        $TempFile = tempnam("./data/", "UPD");
        if(!file_exists($file) || !is_readable($file)) return FALSE;
        if(!file_exists($TempFile) || !is_writable($TempFile)) return FALSE;

        if (($handle = fopen($file, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (!$header) {
                    $header = $row;
                    $headerIndex = array_search($Key, $header);

                    $line = implode(',', $header) . "\r\n";
                    file_put_contents($TempFile, $line);
                    //if((file_put_contents($TempFile, $line)) !== FALSE) return FALSE;
                } else {
                    if ($row[$headerIndex] == $value) {
                        $line = implode(',', $data) . "\r\n";
                    } else {
                        $line = implode(',', $row) . "\r\n";
                    }
                    file_put_contents($TempFile, $line, FILE_APPEND);
                }
            }
            fclose($handle);
        }
        unlink($file);
        rename($TempFile, $file);
        return TRUE;
    }

    function DeleteDataByKey($file, $Key, $value)
    {
        $delimiter = ',';
        $line = '';

        $header = NULL;
        $headerIndex = 0;

        $TempFile = tempnam("./data/", "DEL");

        if(!file_exists($file) || !is_readable($file)) return FALSE;
        if(!file_exists($TempFile) || !is_writable($TempFile)) return FALSE;

        if (($handle = fopen($file, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (!$header) {
                    $header = $row;
                    $headerIndex = array_search($Key, $header);

                    $line = implode(',', $header) . "\r\n";
                    file_put_contents($TempFile, $line);
                } else {
                    if ($row[$headerIndex] != $value) {
                        $line = implode(',', $row) . "\r\n";
                        file_put_contents($TempFile, $line, FILE_APPEND);
                    }
                }
            }
            fclose($handle);
        }
        unlink($file);
        rename($TempFile, $file);
        return TRUE;
    }

    function TotalRows($file){
        $result = 0;

        return $result;
    }

    function TotalPages($file, $_pagesize){
        $result = 0;

        return $result;
    }
?>

