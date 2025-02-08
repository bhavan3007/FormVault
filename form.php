<!DOCTYPE html>
<html>
<head>
    <title>Form Validation</title>
</head>
<body>
    <?php
        $firstname = $lastname = $email = $gender = $age = $qualification = $contact = $country = $state = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $firstname = test_input($_POST["firstname"]);
            $lastname = test_input($_POST["lastname"]);
            $email = test_input($_POST["email"]);
            $gender = test_input($_POST["gender"]);
            $age = test_input($_POST["age"]);
            $qualification = test_input($_POST["qualification"]);
            $contact = test_input($_POST["contact"]);
            $country = test_input($_POST["country"]);
            $state = test_input($_POST["state"]);
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
    <h2>Form Validation</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        FirstName: <input type="text" name="firstname" required>
        <br><br>
        LastName: <input type="text" name="lastname" required>
        <br><br>
        Email: <input type="email" name="email" required>
        <br><br>
        Gender:
        <input type="radio" name="gender" value="male"> Male
        <input type="radio" name="gender" value="female"> Female
        <br><br>
        Age: <input type="number" name="age" required>
        <br><br>
        Qualification: <input type="text" name="qualification" required>
        <br><br>
        Contact: <input type="tel" name="contact" required>
        <br><br>
        Country: <input type="text" name="country" required>
        <br><br>
        State: <input type="text" name="state" required>
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php
        echo "<h2> Your input</h2>";
        echo $firstname;
        echo "<br>";
        echo $lastname;
        echo "<br>";
        echo $email;
        echo "<br>";
        echo $gender;
        echo "<br>";
        echo $age;
        echo "<br>";
        echo $qualification;
        echo "<br>";
        echo $contact;
        echo "<br>";
        echo $country;
        echo "<br>";
        echo $state;
    ?>
</body>
</html>
