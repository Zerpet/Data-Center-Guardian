<?php

function validate_rack($rack) {

    $tmp = intval($rack);
    
    if(is_int($tmp) === FALSE)
        return FALSE;
    
    if($tmp >= 101 && $tmp <= 106)
        return $tmp;
    
    if($tmp >= 201 && $tmp <= 205)
        return $tmp;
    
    return FALSE;
}

function sanitize_iface($iface) {
    if($iface === "") 
        return NULL;
    
    $tmp = intval($iface);
    
    if(is_int($tmp) === FALSE)
        return FALSE;
    
    if($tmp < 0 || $tmp > 50)
        return FALSE;
    
    return $tmp;
}

function sanitize_ip($ip) {
    if($ip === "" || $ip === "___") 
        return "___";
    
    $tmp = intval($ip);
    
    if(is_int($tmp) === FALSE)
        return FALSE;
    
    if($tmp < 0 || $tmp > 255)
        return FALSE;
    
    return $tmp;
}

?>
