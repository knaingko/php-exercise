<?php 

class menu { 
    var $name; 
    var $items; 
    var $open; 
    var $closed; 
    var $indent; 

    function menu($name, 
                  $open = '(-)', 
                  $closed = '(+)', 
                  $indent = '&nbsp; &nbsp; ' 
                 ) 
    { 
        $this->items  = array(); 
        $this->name   = $name; 
        $this->open   = $open; 
        $this->closed = $closed; 
        $this->indent = $indent; 
    } 

    function add($name, $href = "", $target = "") { 
        $n = count($this->items); 

        if (is_object($name)) { 
            $this->items[$n] = $name; 
        } else { 
            $this->items[$n]['name'] = $name; 
            $this->items[$n]['href'] = $href; 
            $this->items[$n]['target'] = $target; 
        } 
    } 

    function show($nest = 0) { 
        $urlname = strtr($this->name, ' ', '_'); 
        $indent = ''; 
        global $$urlname; 
        global $PHP_SELF; 
        global $QUERY_STRING; 

        if ($nest) { 
            $indent = str_repeat($this->indent, $nest); 
        } 

        if (isset($$urlname)) { 
            printf('%s<a href="%s?%s">%s</a><br>', 
                   $indent . $this->open, 
                   $PHP_SELF, 
                   ereg_replace("{$urlname}=&", '', $QUERY_STRING), 
                   $this->name); 
            echo "n"; 

            while (list(,$item) = each($this->items)) { 
                if (is_object($item)) { 
                    $item->show($nest + 1); 
                } else { 
                    printf('%s<a href="%s"%s>%s</a><br>', 
                           $indent . $this->indent, 
                           $item['href'], 
                           (!empty($item['target']) ? ' target="' . 
                                                      $item['target'] . '"' 
                                                    : ''), 
                           $item['name']); 
                    echo "n"; 
                } 
            } 
        } else { 
            printf('%s<a href="%s?%s=&%s">%s</a><br>', 
                   $indent . $this->closed, 
                   $PHP_SELF, 
                   $urlname, $QUERY_STRING, 
                   $this->name); 
            echo "n"; 
        } 
    } 
} 

?> 
