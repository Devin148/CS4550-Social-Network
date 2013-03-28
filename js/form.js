// Is the form, with formId, not empty?
function isFormFilled(formId) {
    var valid = true;
    $("#" + formId + " :text, :password, select").each(function() {
        if ($(this).val() == null || $(this).val() == '') {
            valid = false;
        }
    });
    return valid;
}

// Is the provided string empty?
function isEmpty(string) {
    return (string == null || string == "") ? true : false;
}

// Is the provided email valid?
function isEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email) ? true : false;
}

// Add the past 100 years into a <select> element
function addYears(selectId) {
    // Generate Years
    var date = new Date();
    // Add the default "Year:"
    var defaultYear = $("<option />");
    defaultYear.text("Year:");
    defaultYear.val("");
    $("#" + selectId).append(defaultYear);
    // Loop through the past 100 years
    for (var i = 0; i <= 100; i++) {
        var yearOption = $("<option />");
        var year = date.getFullYear() - i;
        yearOption.text(year);
        yearOption.val(year);
        $('#' + selectId).append(yearOption);
    }
}