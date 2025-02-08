<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background: linear-gradient(to bottom, #eaf4fc, #ffffff);
        }
        .error {
            color: #FF0000;
        }
        .form-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: inline-block;
            width: 150px;
            text-align: right;
            margin-right: 10px;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="number"],
        .form-group input[type="tel"],
        .form-group input[type="radio"] {
            width: 200px;
        }
        .form-group input[type="radio"] {
            width: auto;
        }
        .submit-container {
            text-align: center;
        }
        .image-container {
            margin-left: 10px;
        }
        .image-container img {
            max-width: 600px;
            height: auto;
            align-self: center;
        }
    </style>
    <title>Application Form</title>
</head>
<body>
<?php
        $firstnameErr = $lastnameErr = $emailErr = $genderErr = $ageErr = $qualificationErr = $contactErr = $countryErr = $stateErr = "";
        $firstname = $lastname = $email = $gender = $age = $qualification = $contact = $country = $state = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = mysqli_connect('localhost', 'root', '', 'test1') or die("Connection Failed: " . mysqli_connect_error());

            if (empty($_POST["firstname"])) {
                $firstnameErr = "Please enter a valid name";
            } else {
                $firstname = test_input($_POST["firstname"]);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $firstname)) {
                    $firstnameErr = "Only letters and white spaces allowed";
                }
            }

            if (empty($_POST["lastname"])) {
                $lastnameErr = "Please enter a valid last name";
            } else {
                $lastname = test_input($_POST["lastname"]);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
                    $lastnameErr = "Only letters and white spaces allowed";
                }
            }

            if (empty($_POST["email"])) {
                $emailErr = "Please enter a valid email address";
            } else {
                $email = test_input($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                }
            }

            if (empty($_POST["gender"])) {
                $genderErr = "Please select a gender";
            } else {
                $gender = test_input($_POST["gender"]);
            }

            if (empty($_POST["age"])) {
                $ageErr = "Please enter your age";
            } else {
                $age = test_input($_POST["age"]);
                if (!preg_match("/^[0-9]+$/", $age) || $age < 18 || $age > 50) {
                    $ageErr = "Please enter a valid age";
                }
            }

            if (empty($_POST["qualification"])) {
                $qualificationErr = "Please enter your qualification";
            } else {
                $qualification = test_input($_POST["qualification"]);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $qualification)) {
                    $qualificationErr = "Only letters and white spaces allowed";
                }
            }

            if (empty($_POST["contact"])) {
                $contactErr = "Please enter a valid contact number";
            } else {
                $contact = test_input($_POST["contact"]);
                if (!preg_match("/^[0-9]{10}$/", $contact)) {
                    $contactErr = "Invalid contact number";
                }
            }

            if (empty($_POST["country"])) {
                $countryErr = "Please enter a valid country";
            } else {
                $country = test_input($_POST["country"]);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $country)) {
                    $countryErr = "Only letters and white spaces allowed";
                }
            }

            if (empty($_POST["state"])) {
                $stateErr = "Please enter a valid state";
            } else {
                $state = test_input($_POST["state"]);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $state)) {
                    $stateErr = "Only letters and white spaces allowed";
                }
            }

            if (!$firstnameErr && !$lastnameErr && !$emailErr && !$genderErr && !$ageErr && !$qualificationErr && !$contactErr && !$countryErr && !$stateErr) {
                // Check if email or contact number already exists in the database
                $check_query = "SELECT * FROM applicants WHERE email = '$email' OR contact = '$contact'";
                $result = mysqli_query($conn, $check_query);
        
                if (mysqli_num_rows($result) > 0) {
                    // Record exists
                    echo "<p class='error'>You are already registered with this email or contact number.</p>";
                } else {
                    // Insert data into the database
                    $sql = "INSERT INTO applicants (firstname, lastname, email, gender, age, qualification, contact, country, state) 
                            VALUES ('$firstname', '$lastname', '$email', '$gender', '$age', '$qualification', '$contact', '$country', '$state')";
        
                    if (mysqli_query($conn, $sql)) {
                        // Redirect to another page
                        header("Location: success.php");
                        exit();
                    } else {
                        echo "<p>Error: " . mysqli_error($conn) . "</p>";
                    }
                }
            }
        
            mysqli_close($conn);
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
    <h2>Application Form</h2>
    <div class="form-container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="firstname">FirstName:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo $firstname;?>">
                <span class="error">* <?php echo $firstnameErr;?></span>
            </div>
            <div class="form-group">
                <label for="lastname">LastName:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo $lastname;?>">
                <span class="error">* <?php echo $lastnameErr;?></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email;?>">
                <span class="error">* <?php echo $emailErr;?></span>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <input type="radio" id="gender-female" name="gender" value="female" <?php if (isset($gender) && $gender=="female") echo "checked";?>>Female
                <input type="radio" id="gender-male" name="gender" value="male" <?php if (isset($gender) && $gender=="male") echo "checked";?>>Male
                <input type="radio" id="gender-others" name="gender" value="others" <?php if (isset($gender) && $gender=="others") echo "checked";?>>Others
                <span class="error">* <?php echo $genderErr;?></span>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $age;?>">
                <span class="error">* <?php echo $ageErr;?></span>
            </div>
            <div class="form-group">
                <label for="qualification">Qualification:</label>
                <input type="text" id="qualification" name="qualification" value="<?php echo $qualification;?>">
                <span class="error">* <?php echo $qualificationErr;?></span>
            </div>
            <div class="form-group">
                <label for="contact">Contact:</label>
                <input type="tel" id="contact" name="contact" value="<?php echo $contact;?>">
                <span class="error">* <?php echo $contactErr;?></span>
            </div>
            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" id="country" name="country" value="<?php echo $country;?>">
                <span class="error">* <?php echo $countryErr;?></span>
            </div>
            <div class="form-group">
                <label for="state">State:</label>
                <input type="text" id="state" name="state" value="<?php echo $state;?>">
                <span class="error">* <?php echo $stateErr;?></span>
            </div>
            <div class="form-group submit-container">
                <input type="submit" name="submit" value="Submit">
            </div>
        </form>
        <div class="image-container">
            <img src="php validation.jpg" alt="Description of image">
        </div>
    </div>
</body>
</html>
