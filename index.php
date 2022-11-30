
<?php
	require 'config.php';
    $nameErr = $emailErr = $genderErr = $passwordErr = $ageErr = "";
    $name = $email = $gender = $age = $password = "";

	if(isset($_POST['submitButton'])) {

        set_error_handler(function (int $errno, string $errstr) {
            if ((strpos($errstr, 'Undefined array key') === false) && (strpos($errstr, 'Undefined variable') === false)) {
                return false;
            } else {
                return true;
            }
        }, E_WARNING);
    
        
            $nameErr = $emailErr = $genderErr = $passwordErr = $ageErr = "";
            $name = $email = $gender = $age = $password = "";


            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name =($_POST["name"]);
                $email =($_POST["email"]);
                $age =($_POST["age"]);
                $password =($_POST["password"]);
                $gender =($_POST["gender"]);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $name = $_POST["name"];
                    if (empty($name)) {
                        $nameErr = "Name is required!";
                    } elseif ((!preg_match("/^[a-zA-z]*$/", $name))) {
                        $nameErr = "Please insert valid name!";
                    } else {
                        $name =($_POST["name"]);
                    }
            
                    $email = $_POST["email"];
                    if (empty($email)) {
                        $emailErr = "Email is required";
                    } elseif ((!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email))) {
                        $emailErr = "Enter valid email";
                    } else {
                        $email =($_POST["email"]);
                    }
            
                    $password = $_POST["password"];
                    if (empty($_POST["password"])) {
                        $passwordErr = "Please type a password";
                    } elseif (strlen($password) < 9) {
                        $passwordErr = "Please keep a minimum length of 8";
                    } else {
                        $password =($_POST["password"]);
                    }
            
                    $age = $_POST["age"];
                    if (empty($_POST["age"])) {
                        $ageErr = "Please select an age";
                    } else {
                        $age =($_POST["age"]);
                    }
            
                    $gender = $_POST["gender"];
                    if (empty($_POST["gender"])) {
                        $genderErr = "Gender is required";
                    } else {
                        $gender =($_POST["gender"]);
                    }

		if($nameErr == "" && $passwordErr == "" && $emailErr == "" && $genderErr == "" && $ageErr == ""){
			try {
				$stmt = $connect->prepare('INSERT INTO registration(name,email,password,gender,age) VALUES (:name, :email, :password, :gender,:age)');
				$stmt->execute(array(
					':name' => $name,
					':email' => $email,
                    ':password' => $password,
                    ':gender'=>$gender,
					':age' => $age
                    
					));
				header('Location:weather.php');
				exit;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	}
}
?>




<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="./styles/light.css">
</head>



<body>

    <form action="" method="post">

        <h1>Sign Up</h1>

        <fieldset>

            <legend><span class="number">1</span> Your basic info</legend>

            <label for="name">Name: <span class="error">* <?php echo $nameErr; ?></span></label>
            <input type="text" id="name" name="name">

            <label for="email">Email: <span class="error">* <?php echo $emailErr; ?></span></label>
            <input type="text" id="email" name="email">

            <label for="password">Password: <span class="error">* <?php echo $passwordErr; ?></span></label>
            <input type="password" id="password" name="password">
            
            <div class="flex-radio">
                <div>
                    <label>Gender <span class="error">* <?php echo $genderErr; ?></span></label>
                    <input type="radio" id="male" value="Male" name="gender"><label for="yes" class="light">Male</label><br>
                    <input type="radio" id="female" value="Female" name="gender"><label for="female" class="light">Female</label><br>
                    <input type="radio" id="other" value="Other" name="gender"><label for="other" class="light">Other</label>
                </div>
                <div>
                    <label>Age: <span class="error">* <?php echo $ageErr; ?></span></label>
                    <input type="radio" id="under_18" value="under_18" name="age"><label for="under_18" class="light">Under 18</label><br>
                    <input type="radio" id="over_18" value="over_18" name="age"><label for="over_18" class="light">Adult (18 or Older)</label><br>
                    <input type="radio" id="senior" value="senior" name="age"><label for="senior" class="light">Senior (60 or older)</label>
                </div>
            </div>

        </fieldset>

        <fieldset>

        <legend><span class="number">2</span> Your go to weather:</legend>
        <div class="flex-radio">
                <div>
                    <label>Check the types of weather you'd like to travel:</label><br>
                    <input type="checkbox" id="summer" value="summer" name="summer"><label class="light" for="summer">Summer</label></tab>
                    <input type="checkbox" id="winter" value="winter" name="winter"><label class="light" for="winter">Winter</label></tab>
                    <input type="checkbox" id="rainy" value="rainy" name="rainy"><label class="light" for="rainy">Rainy</label></tab>
                    <input type="checkbox" id="fall" value="fall" name="fall"><label class="light" for="fall">Fall</label><br>
                </div>

    </fieldset>

        <fieldset>

            <legend><span class="number">3</span> Your medical profile (optional)</legend>

            <div class="flex-radio">
                <div>
                    <label>Check if you have any of the following conditions</label><br>
                    <input type="checkbox" id="asthama" value="asthama" name="asthama"><label class="light" for="asthama">Breathing problems (Asthama,Dust Allergy etc)</label><br>
                    <input type="checkbox" id="photophobia" value="photophobia" name="photophobia"><label class="light" for="photophobia">Discomfort in bright light (Photophobia,Migraine etc)</label><br>
                    <input type="checkbox" id="skin_disease" value="skin_disease" name="skin_disease"><label class="light" for="skin_disease">Skin disease</label><br>
                    <input type="checkbox" id="cancer" value="cancer" name="cancer"><label class="light" for="cancer">Cancer</label><br>
                </div>
                <div>
                    <label>Are/Do you want to be associated with a wheelchair?</label>
                    <input type="radio" id="yes" value="yes" name="yes_no"><label class="light" for="yes">Yes</label><br>
                    <input type="radio" id="no" value="no" name="yes_no"><label class="light" for="no">No</label>
                </div>

        </fieldset>

        <button type="submit" name="submitButton" id="submitButton">Sign Up</button>

    </form>

</body>

</html>