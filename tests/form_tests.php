<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>QUnit Form Unit-Tests</title>
    <link rel="stylesheet" href="resources/qunit-1.11.0.css">
    <script src="resources/qunit-1.11.0.js" type="text/javascript"></script>
    <script src="form_tests.js" type="text/javascript"></script>

    <script src="../js/form.js" type="text/javascript"></script>
    <script src="../js/jquery-1.9.0.min.js" type="text/javascript"></script>
</head>
<body>
    <div id="qunit"></div>
    <div id="qunit-fixture"></div>

    <?php include ("../login_form.php"); ?>
    <?php include ("../registration_form.php"); ?>

    <script>
    // Add years to the registration form
    addYears("year");

    // Clear all values in the login form
    function clearLoginForm() {
        $("#login_form #email").val("");
        $("#login_form #password").val("");
    }

    // Test isFormFilled on the login_form
    test("isFormFilled login_form", function() {
        // Verify the empty form is viewed as empty
        equal(isFormFilled("login_form"), false, "Form is empty." );

        // Fill out the email, form is still not filled
        $("#login_form #email").val("email");
        equal(isFormFilled("login_form"), false, "Email is filled.")

        // Fill out the password and complete form
        $("#login_form #password").val("pass");
        equal(isFormFilled("login_form"), true, "Form is filled.")

        // Remove the email, form is no longer filled
        $("#login_form #email").val("");
        equal(isFormFilled("login_form"), false, "Password is filled.")

        clearLoginForm();
    });

    // Test isEmail on the login_form
    test("isEmail login_form", function() {
        // Empty email should be invalid
        equal(isEmail($("#login_form #email").val()), false, "Email is empty.");

        // Invalid email 1
        $("#login_form #email").val("email");
        equal(isEmail($("#login_form #email").val()), false, "'email' is invalid.");

        // Invalid email 2
        $("#login_form #email").val("name@domain");
        equal(isEmail($("#login_form #email").val()), false, "'name@domain' is invalid.");

        // Invalid email 3
        $("#login_form #email").val("domain.com");
        equal(isEmail($("#login_form #email").val()), false, "'domain.com' is invalid.");

        // Valid email 1
        $("#login_form #email").val("name@domain.com");
        equal(isEmail($("#login_form #email").val()), true, "'name@domain.com' is valid.");

        // Valid email 2
        $("#login_form #email").val("name@domain.net");
        equal(isEmail($("#login_form #email").val()), true, "'name@domain.net' is valid.");

        // Valid email 3
        $("#login_form #email").val("name@domain.org");
        equal(isEmail($("#login_form #email").val()), true, "'name@domain.org' is valid.");

        clearLoginForm();
    });
    </script>

</body>
</html>