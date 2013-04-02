function validate(formId) {
    // If the form isn't filled out, return false
    if (!isFormFilled(formId)) {
        return false;
    }

    // If it is filled, validate all emails
    var valid = true;
    $("#" + formId + " #email").each(function() {
        valid = isEmail($(this).val());
    });

    // Then validate all dates

}

// Is the form, with formId, not empty?
// Returns  true if the form is completely filled out
//          false if any element is left blank
function isFormFilled(formId) {
    var valid = true;
    var query = "#" + formId + " :text," +
                "#" + formId + " :password," + 
                "#" + formId + " select";
    $(query).each(function() {
        if ($(this).val() == null || $(this).val() == '') {
            valid = false;
            // Alter background to signify there's an error
            $(this).css("background-color", "#F00");
            $(this).stop().animate({
                backgroundColor: "#FFF"
            });
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