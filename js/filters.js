/**
 * This function is usefull to validate the data from rack view in editable-mode.
 * It recevies two inputs, they should be integer numbers
 */
function validate_input(iface, ip) {
    
    if(!typeof(iface) === "number" || iface < 1 || iface > 11) 
        return false;
    
    
    if(!typeof(ip) === "number" && (ip !== "___" || ip !== "")) //The interface may be open
        return false;
    
    
    if(ip < 0 || ip > 255) 
        return false;
    
    return true;
}

/*
 * Function to validate an IP address. It returns true if value is a valid IP
 * with format W.X.Y.Z where W, X, Y and Z are lower than 255 and greater or equal to 0.
 * @param value The IP to validate
 * @return True if the IP follows the patter, False otherwise.
 */
function validate_complete_ip(value) {
    var octet = '(?:25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]|[0-9])';
    var ip    = '(?:' + octet + '\\.){3}' + octet;
    var ipRE  = new RegExp( '^' + ip + '$' );
    return ipRE.test(value);
}


function validate_notes(value) {
    return value.length > 255 ? false : true;
}

function validate_starts(value) {
    var t = parseInt(value, 10);
    if(t > 0 && t <= 42)
        return true;
    
    return false;
}

function validate_us(value) {
    var t = parseInt(value, 10);
    if(t > 0 && t <= 9)
        return true;
    
    return false;
}

// Only people with Jedi knowledge to understand Regular Expressions should keep reading

/*
 * Function to validate an email address.
 */
function validate_email_address(value) {
    var patt = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i;
    return patt.test(value);
}

/*
 * Function to validate an URL address.
 */
function validate_url_address(value) {
    var patt = /^(?:https?|s?ftp|telnet|ssh|scp):\/\/(?:(?:[\w]+:)?\w+@)?(?:(?:(?:[\w-]+\.)*\w[\w-]{0,66}\.(?:[a-z]{2,6})(?:\.[a-z]{2})?)|(?:(?:25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.)(?:(?:25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(?:25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})))(?:\:\d{1,5})?(?:\/(~[\w-_.])?)?(?:(?:\/[\w-_.]*)*)?\??(?:(?:[\w-_.]+\=[\w-_.]+&?)*)?$/i;
    return patt.test(value);
}

/*
 * Returns true if color is 'Dark' or 'Bright', false otherwise.
 */
function validate_color(value) {
    var patt = /^(?:(?:Bright)?|(?:Dark)?)$/
    return patt.test(value);
}

/*
 * Returns true if type is 'UPS' or 'Switch' or 'KVM' or 'Server' or 'Storage Server', false otherwise.
 */
function validate_type(value) {
    var patt = /^(?:(?:UPS)?|(?:Switch)?|(?:KVM)?|(?:Server)?|(?:Storage Server)?)$/;
    return patt.test(value);
}
