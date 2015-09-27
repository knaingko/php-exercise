<?php
function display_breadcrumb($breadcrumb){
    $olHtml = "";
    $olHtml = $olHtml . "<ol class='breadcrumb'>" ." \n";
    foreach($breadcrumb as $row)
    {
        if($row['active'] == 'true'){
            $active = "class='active'";
        }else{
            $active = "";
        }
        $olHtml = $olHtml . "<li href='". $row['url'] ."'". $active .">". $row['label'] ."</li>\n";
    }
    $olHtml = $olHtml . "</ol>" . "\n";
    return $olHtml;
}
?>


