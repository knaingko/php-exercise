<?php
function redirect($url)
{
    if (!headers_sent())
    {
        //if (ob_get_contents()) while (@ob_end_clean()); // clear output buffer if one exists
        header('Location: '.$url);
    }else{
        echo '<script type="text/javascript" language="javascript">';
        echo 'window.document.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
    }
}
?>