function isEmpty(string) {
    return (string == null || string == "") ? true : false;
}

function isEmail(email) {
    var re = ^[-0-9A-Za-z!#$%&'*+/=?^_`{|}~.]+@[-0-9A-Za-z!#$%&'*+/=?^_`{|}~.]+;
    return re.test(email) ? true : false;
}

function validateLogin(email, password) {
    return true;
    //return !isEmpty(email) && !isEmpty(password) && isEmail(email);
}