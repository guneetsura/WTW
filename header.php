<?php
error_reporting(0);
ini_set('display_errors', 0);
set_error_handler(function (int $errno, string $errstr) {
    if ((strpos($errstr, 'Undefined array key') === false) && (strpos($errstr, 'Undefined variable') === false)) {
        return false;
    } else {
        return true;
    }
}, E_WARNING);
$s = $_SESSION['email'];

// if (isset($_POST['logout'])){

//     if ($_SERVER['REQUEST_METHOD']=='POST'){
//         session_destroy();
//         header('Location:myaccount.php');
//         exit();
//     }

?>

<html>

<head>
    <link rel="stylesheet" type="text/css" media="screen" href="styles/header.css">
</head>

<body>
    <section id="navbar">
        <header>
            <img class="logo" src="assets/Logo.svg" alt="logo">
            <nav>
                <ul class="nav-links">
                    <li><a href="weather.php">Home</a></li>
                    <li><a href="cities.php">Cities</a></li>
                    <li><a href="about.php">Contact</a></li>
                </ul>
            </nav>
            <div class="btn-ln">
                <?php
                if ($s) {

                    echo "
                    <a href='logout.php' class='login'><button type='submit' class='login-btn btn'>Logout</button></a>
                    <a href='account.php'><button class='signup-btn btn'>My Account</button></a>";
                } else {
                    echo "<a class='login' href='login.php'><button class='login-btn btn'>Login</button></a>
                            <a href='register.php'><button class='signup-btn btn'>Sign Up</button></a>";
                }
                ?>
                <!-- <a class="login" href="login.php"><button class="login-btn btn">Login</button></a>
                        <a href="register.php"><button class="signup-btn btn">Sign Up</button></a> -->
            </div>
        </header>
    </section>
</body>

</html>