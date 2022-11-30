<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" media="screen" href="style.php">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,500;1,400&display=swap" rel="stylesheet">
    <title>What's The Weather</title>
    <?php
    set_error_handler(function (int $errno, string $errstr) {
        if ((strpos($errstr, 'Undefined array key') === false) && (strpos($errstr, 'Undefined variable') === false)) {
            return false;
        } else {
            return true;
        }
    }, E_WARNING);
    $city = $_POST['city'];
    $background = "https://source.unsplash.com/1600x900/?" . $city;
    if (!$city) {
        $background = "https://source.unsplash.com/1600x900/?greece";
    }
    ?>
    <style>
        body {
            background: url(<?php echo $background; ?>) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
</head>

<body>
    <section id="navbar">
        <header>
            <img class="logo" src="Logo.svg" alt="logo">
            <nav>
                <ul class="nav-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Cities</a></li>
                    <li><a href="#">About</a></li>
                </ul>
            </nav>
            <div class="btn-ln">
                <a class="login" href="#"><button class="login-btn btn">Login</button></a>
                <a href="#"><button class="signup-btn btn">Sign Up</button></a>
            </div>
        </header>
    </section>
    <?php

    $weather = "";
    $error = "";

    if ($_POST['city']) {

        $urlContents = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($_POST['city']) . ",&units=metric&appid=074d5c5ffeea065ccae7fd29942036c0");

        $weatherArray = json_decode($urlContents, true);

        if ($weatherArray['cod'] == 200) {

            // $weather = "The weather in " . $_POST['city'] . " is currently '" . $weatherArray['weather'][0]['description'] . "'. ";

            $tempInCelcius = intval($weatherArray['main']['temp']);
            $humid = intval($weatherArray['main']['humidity']);
            $desc = $weatherArray['weather'][0]['description'];
            $speed = $weatherArray['wind']['speed'];
            $weather = $tempInCelcius . "° C";


            // and the wind speed is " . $weatherArray['wind']['speed'] . "m/s."


        } else {

            $error = "Could not find city - please try again.";
        }
    }


    ?>
    <section id="search-page">
        <div class="card">
            <form method="POST">
                <div class="search">
                    <input type="text" class="search-bar" placeholder="Search Location" name="city" id="city" value="<?php echo $_POST['city']; ?>">
                    <button class="search-btn" type="submit"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M909.6 854.5L649.9 594.8C690.2 542.7 712 479 712 412c0-80.2-31.3-155.4-87.9-212.1-56.6-56.7-132-87.9-212.1-87.9s-155.5 31.3-212.1 87.9C143.2 256.5 112 331.8 112 412c0 80.1 31.3 155.5 87.9 212.1C256.5 680.8 331.8 712 412 712c67 0 130.6-21.8 182.7-62l259.7 259.6a8.2 8.2 0 0 0 11.6 0l43.6-43.5a8.2 8.2 0 0 0 0-11.6zM570.4 570.4C528 612.7 471.8 636 412 636s-116-23.3-158.4-65.6C211.3 528 188 471.8 188 412s23.3-116.1 65.6-158.4C296 211.3 352.2 188 412 188s116.1 23.2 158.4 65.6S636 352.2 636 412s-23.3 116.1-65.6 158.4z"></path>
                        </svg></button>
                </div>
            </form>
            <div class="weather">
                <h2 class="city">
                    <?php
                    if ($weather) {
                        echo "Weather in " . $_POST['city'];
                    } else if ($error) {
                        echo $error;
                    }
                    ?>
                </h2>
                <h1 class="temp">
                    <?php
                    if ($weather) {
                        echo $weather;
                    } else if ($error) {
                        echo $error;
                    }
                    ?>
                </h1>
                <div class="flex">
                    <?php
                    if ($weather) {
                        echo '<img src="https://openweathermap.org/img/wn/04n.png" alt="" class="icon">';
                    } else if ($error) {
                        echo $error;
                    }
                    ?>
                    <div class="description"><?php if ($weather) {
                                                    echo $desc;
                                                } ?>
                    </div>
                </div>
                <div class="humidity"><?php if ($weather) {
                                            echo "Humidity: " . $humid . "%";
                                        } ?></div>
                <div class="windy"><?php if ($weather) {
                                        echo "Wind Speed: " . $speed . "m/s";
                                    } ?>

                </div>
            </div>

        </div>
        <div>
            <?php
            // if ($weather >20) {
            //     echo "its hot!";
            // }
            // if ($humid > 50) {
            //     echo "quite humid :(";
            // }

            // if ($speed > 75) {
            //     echo "Hurricane!";
            // }
            ?>
        </div>
    </section>
</body>

</html>