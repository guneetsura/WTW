<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./Register/light.css">
</head>

<body>
    <?php include 'header.php' ?>
    <?php
    require 'config.php';
    set_error_handler(function (int $errno, string $errstr) {
        if ((strpos($errstr, 'Undefined array key') === false) && (strpos($errstr, 'Undefined variable') === false)) {
            return false;
        } else {
            return true;
        }
    }, E_WARNING);

    $nameErr = $emailErr = $genderErr = $passwordErr = $ageErr = "";
    $name = $email = $gender = $age = $password = "";

    $pass = sha1($_POST["password"]);
    $name1 = $_POST["name"];
    setcookie("user", $name1, time() + (86400 * 30), "/");


    $theme = $_POST["theme"];
    setcookie("theme", $theme, time() + (86400 * 30), "/");

    // $setcookie("password", $pass, time() + (86400 * 30), "/");

    if (isset($_POST['submitButton'])) {

        set_error_handler(function (int $errno, string $errstr) {
            if ((strpos($errstr, 'Undefined array key') === false) && (strpos($errstr, 'Undefined variable') === false)) {
                return false;
            } else {
                return true;
            }
        }, E_WARNING);


        $nameErr = $emailErr = $genderErr = $passwordErr = $ageErr = "";
        $name = $email = $gender = $age = $password = $medical = $wheelchair = "";


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = ($_POST["name"]);
            $email = ($_POST["email"]);
            $age = ($_POST["age"]);
            $password = ($_POST["password"]);
            $gender = ($_POST["gender"]);
            $medical = ($_POST["medical"]);
            $wheelchair = ($_POST["yes_no"]);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $name = $_POST["name"];
            if (empty($name)) {
                $nameErr = "Name is required!";
            } elseif ((!preg_match("/^[a-zA-z]*$/", $name))) {
                $nameErr = "Please insert valid name!";
            } else {
                $name = ($_POST["name"]);
            }

            $email = $_POST["email"];
            if (empty($email)) {
                $emailErr = "Email is required";
            } elseif ((!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email))) {
                $emailErr = "Enter valid email";
            } else {
                $email = ($_POST["email"]);
            }

            $password = $_POST["password"];
            if (empty($_POST["password"])) {
                $passwordErr = "Please type a password";
            } elseif (strlen($password) < 9) {
                $passwordErr = "Please keep a minimum length of 8";
            } else {
                $password = ($_POST["password"]);
            }

            $age = $_POST["age"];
            if (empty($_POST["age"])) {
                $ageErr = "Please select an age";
            } else {
                $age = ($_POST["age"]);
            }

            $gender = $_POST["gender"];
            if (empty($_POST["gender"])) {
                $genderErr = "Gender is required";
            } else {
                $gender = ($_POST["gender"]);
            }
            foreach ($medical as $med) {
                $condition .= $med . ",";
            }

            if ($nameErr == "" && $passwordErr == "" && $emailErr == "" && $genderErr == "" && $ageErr == "") {
                try {
                    $stmt = $connect->prepare('INSERT INTO registration(name,email,password,gender,age,medical,wheelchair) VALUES (:name, :email, :password, :gender,:age,:medical,:wheelchair)');
                    $stmt->execute(array(
                        ':name' => $name,
                        ':email' => $email,
                        ':password' => $password,
                        ':gender' => $gender,
                        ':age' => $age,
                        ':medical' => $condition,
                        ':wheelchair' => $wheelchair

                    ));
                    header('Location:index.php');
                    exit;
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }
    }

    ?>
    <?php //echo htmlspecialchars($_SERVER["PHP_SELF"]); 
    ?>
    <section id="sign-up-form">
        <form action="" method="POST">

            <h1>Sign Up</h1>

            <fieldset>

                <legend><span class="number">1</span> Your basic info</legend>

                <label for="name">Name: <span>* <?php echo $nameErr; ?></span></label>
                <input type="text" id="name" name="name">

                <label for="email">Email: <span>* <?php echo $emailErr; ?></span></label>
                <input type="text" id="email" name="email">

                <label for="password">Password: <span>* <?php echo $passwordErr; ?></span></label>
                <input type="password" id="password" name="password">
                <div class="flex-radio">
                    <div>
                        <label>Gender <span>* <?php echo $genderErr; ?></span></label>
                        <input type="radio" id="male" value="Male" name="gender"><label for="yes" class="light">Male</label><br>
                        <input type="radio" id="female" value="Female" name="gender"><label for="female" class="light">Female</label><br>
                        <input type="radio" id="other" value="Other" name="gender"><label for="other" class="light">Other</label>
                    </div>
                    <div>
                        <label>Age: <span>* <?php echo $ageErr; ?></span></label>
                        <input type="radio" id="under_18" value="Under 18" name="age"><label for="under_18" class="light">Under 18</label><br>
                        <input type="radio" id="over_18" value="Above 18" name="age"><label for="over_18" class="light">Adult (18 or Older)</label><br>
                        <input type="radio" id="senior" value="Above 60" name="age"><label for="senior" class="light">Senior (60 or older)</label>
                    </div>
                </div>

            </fieldset>

            <fieldset>

                <legend><span class="number">2</span> Your medical profile (optional)</legend>

                <div class="flex-radio">
                    <div>
                        <label>Check if you have any of the following conditions</label>
                        <input type="checkbox" id="asthama" value="Asthama" name="medical[]"><label class="light" for="asthama">Asthama</label><br>
                        <input type="checkbox" id="photophobia" value="Photophobia" name="medical[]"><label class="light" for="photophobia">Photophobia</label><br>
                        <input type="checkbox" id="skin_disease" value="Skin Disease" name="medical[]"><label class="light" for="skin_disease">Skin disease</label><br>
                        <input type="checkbox" id="cancer" value="Cancer" name="medical[]"><label class="light" for="cancer">Cancer</label><br>
                    </div>
                    <div>
                        <label>Are you associated with a wheelchair?</label>
                        <input type="radio" id="yes" value="Yes" name="yes_no"><label class="light" for="yes">Yes</label><br>
                        <input type="radio" id="no" value="No" name="yes_no"><label class="light" for="no">No</label>
                    </div>
                </div>
            </fieldset>

            <button type="submit" name="submitButton" class="submit-btn" id="submitButton">Sign Up</button>



        </form>
        <span class="text-muted">Already have an account? <a href="login.php">Login</a></span>
    </section>

</body>

</html>