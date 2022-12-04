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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="cities.php">Cities</a></li>
                    <li><a href="about.php">Contact</a></li>
                </ul>
            </nav>
            <div class="btn-ln">
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
                if (isset($_SESSION['email'])) {

                    echo "
                    <a href='account.php'><button class='account-btn'><img src='./assets/icons/account.png'/></button></a>
                    <a href='logout.php' class='login'><button type='submit' class='account-btn logout'><img src='./assets/icons/logout.png'/></button></a>";
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