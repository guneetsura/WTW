<html>

<head>
    <title>Weather Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" media="screen" href="./styles/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,500;1,400&display=swap" rel="stylesheet">
</head>

<body>
    <?php include './header.php'; ?>

    <?php
    require 'config.php';

    $errMsg = '';

    if(isset($_POST['login'])) {
		$errMsg = '';

		// Get data from FORM
		$mail = $_POST['email'];
		$password = $_POST['password'];

		if($mail == '')
			$errMsg = 'Enter username';
		if($password == '')
			$errMsg = 'Enter password';

		if($errMsg == '') {
			try {
				$stmt = $connect->prepare('SELECT id,name,email,password,gender,age,medical,wheelchair FROM registration WHERE email = :email');
				$stmt->execute(array(
					':email' => $mail
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);

				if($data == false){
					$errMsg = "User not found.";
				}
				else {
					if($password == $data['password']) {
						$_SESSION['name'] = $data['name'];
						$_SESSION['email'] = $data['email'];
						$_SESSION['password'] = $data['password'];

						header('Location:index.php');
						exit;
					}
					else
						$errMsg = 'Invalid Password!';
				}
			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}

    ?>

    <section id="weather-login">
        <div class="form-wrap">
            <h2 class="form-title">Welcome</h2>
            <form method="POST" action="">
                <input type="email" id="email" name="email" placeholder="Email">
                <input type="password" id="password" name="password" placeholder="Password">
                <span class="err-msg"><?php echo $errMsg; ?></span>

                <button type="submit" name="login" class="btn-grad">Login</button>

            </form>
            <span class="text-muted">Don't have an account? <a href="./register.php">Sign Up</a></span>
        </div>
    </section>
</body>

</html>