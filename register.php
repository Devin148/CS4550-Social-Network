<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
session_start();
// If the session vars are set
if (isset($_SESSION["logged_in"]) && isset($_SESSION["email"])) {
    // And if logged_in is set to 1
    if ($_SESSION["logged_in"] == 1) {
        // Redirect the user to their newsfeed
        header("Location: newsfeed.php");
    }
}
// Otherwise load the page as normal
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Northeastern Social - Register</title>
    <script src="js/form.js" type="text/javascript"></script>
    <script src="js/jquery-1.9.0.min.js" type="text/javascript"></script>
</head>

<body>
    <form action="create.php" method="post" name="create" id="create">
        <table>
            <tr>
                <td>First Name:</td>
                <td><input name="first" id="first" type="text" size="15" maxlength="100" /></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input name="last" id="last" type="text" size="15" maxlength="100" /></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input name="email" id="email" type="text" size="15" maxlength="100" /></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input name="password" id="password" type="password" size="15" maxlength="100" /></td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td>
                    <select name="day" id="day" size="1">
                        <option selected value="">Day:</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select>
                    <select name="month" id="month" size="1">
                        <option selected value="">Month:</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="November">November</option>
                    </select>
                    <select name="year" id="year" size="1">
                    </select>
                </td>
            </tr>
            <tr>
                <td>Street:</td>
                <td><input name="street" id="street" type="text" size="15" maxlength="100" /></td>
            </tr>
            <tr>
                <td>City:</td>
                <td><input name="city" id="city" type="text" size="15" maxlength="100" /></td>
            </tr>
            <tr>
                <td>State:</td>
                <td>
                    <select name="state" id="state" size="1">
                        <option selected value="">State:</option>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select>
                </td>
            </tr>
            <tr>
                <!-- // TODO: Validate zip code matches state/city? -->
                <td>Zip Code:</td>
                <td><input name="zip" id="zip" type="text" size="15" maxlength="100" /></td>
            </tr>
            <tr>
                <td><input type="submit" id="submit" value="Submit" /></td>
            </tr>

        </table>
    </form>

    <script>
    // Add years to the form
    addYears("year");

    // Validate form
    $("#create").submit(function () {
        return isFormFilled("create") && isEmail($("#email").val());
    });
    </script>

</body>
</html>