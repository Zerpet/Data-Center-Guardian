<?php
require 'check_if_logged.php';
require '../includes/connect_DB.php';

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


//Be ready for burrarum filter
$validate_filters = array
    (
        "name" => array 
            (
                "filter" => FILTER_SANITIZE_STRING
            ),
        "rack" => array 
            (
                "filter" => FILTER_CALLBACK,
                "options" => "validate_rack"
            ),
        "ip1" => array 
            (
                "filter" => FILTER_CALLBACK,
                "options" => "sanitize_ip"
            ),
        "ip2" => array 
            (
                "filter" => FILTER_CALLBACK,
                "options" => "sanitize_ip"
            ),
        "ip3" => array 
            (
                "filter" => FILTER_CALLBACK,
                "options" => "sanitize_ip"
            ),
    
        "iface1" => array 
            (
                "filter" => FILTER_CALLBACK,
                "options" => "sanitize_iface"
            ),
        "iface2" => array 
            (
                "filter" => FILTER_CALLBACK,
                "options" => "sanitize_iface"
            ),
        "iface3" => array 
            (
                "filter" => FILTER_CALLBACK,
                "options" => "sanitize_iface"
            ),
        "connected" => array 
            (
                "filter" => FILTER_VALIDATE_INT,
                "options" => array 
                    (
                        "min_range" => 1,
                        "max_range" => 11
                    )
            )
    );

$post = filter_input_array(INPUT_POST, $validate_filters);

if(in_array(FALSE, $post, TRUE) === TRUE) {
    //Send error TODO
    echo "WE FAILED HARD!";
    die(1);
}

$sql = "UPDATE `wardrobe` SET `name`=?, `iface1`=?, `iface2`=?, `iface3`=?, `ip1`=?, `ip2`=?, `ip3`=?, `phase`=? WHERE `wardrobe`.`position`=?";
$stm = $dbh->prepare($sql);

$params = array
    (
        $post['name'], $post['iface1'], $post['iface2'], $post['iface3'], $post['ip1'], $post['ip2'], $post['ip3'], $post['connected'], $post['rack']
    );

$stm->execute($params);

print $post['rack'];

$dbh = NULL;
unset($post);
?>
