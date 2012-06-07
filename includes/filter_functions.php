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
    
    $tmp = preg_match("/^163\\.117\\.(?:25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]|[0-9])\\.(?:X|x)$/", $ip, $tmp);
    
    if($tmp === 1)
        return $ip;
    
    return FALSE;
}

?>
