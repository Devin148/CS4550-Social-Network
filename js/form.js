function isFormFilled(formId) {
    var valid = true;
    $("#" + formId + " :text, :password").each(function() {
        if ($(this).val() == null || $(this).val() == '') {
            valid = false;
        }
    });
    return valid;
}

function isEmpty(string) {
    return (string == null || string == "") ? true : false;
}

function isEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email) ? true : false;
}