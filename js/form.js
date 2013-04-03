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

// Is the provided zip code valid?
function isZip(zip) {
    var valid = true;
    for (var i = 0; i < zip.length; i++) {
        if (isNaN(zip.charAt(i))) {
            valid = false;
        }
    }
    return valid && (zip.length == 5);
}

// Does the provided date make the user old enough to sign
// up for the site? (18 years or older)
function isOldEnough(day, month, year) {
    var currentTime = new Date();
    var currentYear = currentTime.getFullYear();
    var diff = currentYear - year;

    if (diff > 18) {
        return true;
    } else if (diff < 18) {
        return false;
    } else { // difference is 18
        var currentMonth = currentTime.getMonth() + 1;
        month = getNumberMonth(month);
        if (month > currentMonth) {
            return false;
        } else if (month < currentMonth) {
            return true;
        } else { // Months are the same
            var currentDay = currentTime.getDate();
            if (day > currentDay) {
                return false;
            } else if (day < currentDay || day == currentDay) {
                return true;
            }
        }
    }

    //Some sort of fall through
    return false;
}

// Given the name of a month, return the number
function getNumberMonth(month) {
    switch (month) {
        case "January":
            return 1;
        case "February":
            return 2;
        case "March":
            return 3;
        case "April":
            return 4;
        case "May":
            return 5;
        case "June":
            return 6;
        case "July":
            return 7;
        case "August":
            return 8;
        case "September":
            return 9;
        case "October":
            return 10;
        case "November":
            return 11;
        case "December":
            return 12;
    }
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