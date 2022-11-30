<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        WTW - Cities
    </title>
    <link rel="stylesheet" type="text/css" href="./styles/cities.css">
</head>

<body>
    <?php include './header.php' ?>
    <?php
    set_error_handler(function (int $errno, string $errstr) {
        if ((strpos($errstr, 'Undefined array key') === false) && (strpos($errstr, 'Undefined variable') === false)) {
            return false;
        } else {
            return true;
        }
    }, E_WARNING);

    ?>
    <section id="dashboard">
        <form method="POST" action="">
            <div class="search">
                <input type="text" class="search-bar" placeholder="Search Location" name="city" id="city">
                <button class="search-btn" type="submit"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M909.6 854.5L649.9 594.8C690.2 542.7 712 479 712 412c0-80.2-31.3-155.4-87.9-212.1-56.6-56.7-132-87.9-212.1-87.9s-155.5 31.3-212.1 87.9C143.2 256.5 112 331.8 112 412c0 80.1 31.3 155.5 87.9 212.1C256.5 680.8 331.8 712 412 712c67 0 130.6-21.8 182.7-62l259.7 259.6a8.2 8.2 0 0 0 11.6 0l43.6-43.5a8.2 8.2 0 0 0 0-11.6zM570.4 570.4C528 612.7 471.8 636 412 636s-116-23.3-158.4-65.6C211.3 528 188 471.8 188 412s23.3-116.1 65.6-158.4C296 211.3 352.2 188 412 188s116.1 23.2 158.4 65.6S636 352.2 636 412s-23.3 116.1-65.6 158.4z"></path>
                    </svg></button>
            </div>
        </form>
        <div class="w-dashboard">
            <?php
            // error_reporting(0);
            // ini_set('display_errors', 0);
            
            $background = "";
            $weather = "";
            $error = "";
            $city = $_POST['city'];
            $station = $_SESSION['city'];

            if (isset($_POST['city'])) {
                $station = $_POST['city'];
            }

            if ($_POST['city'] or $station) {

                $urlContents = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($station) . ",&units=metric&appid=074d5c5ffeea065ccae7fd29942036c0");

                $weatherArray = json_decode($urlContents, true);

                if ($weatherArray['cod'] == 200) {

                    // $weather = "The weather in " . $_POST['city'] . " is currently '" . $weatherArray['weather'][0]['description'] . "'. ";

                    $tempInCelcius = intval($weatherArray['main']['temp']);
                    $humid = intval($weatherArray['main']['humidity']);
                    $weatherType = $weatherArray['weather'][0]['main'];
                    $desc = $weatherArray['weather'][0]['description'];
                    $speed = $weatherArray['wind']['speed'];
                    $weather = $tempInCelcius . "° C";
                    $lat = $weatherArray['coord']['lat'];
                    $lon = $weatherArray['coord']['lon'];

                    //$aqiURL = file_get_contents("http://api.openweathermap.org/data/2.5/air_pollution?lat=" . urlencode($lat) . "&lon=" . urlencode($lon) . "&appid=074d5c5ffeea065ccae7fd29942036c0");
                    $aqiURL = file_get_contents("https://api.waqi.info/feed/" . $station . "/?token=f642564d9b7aa62e934760cbaf36933754d50956");
                    $aqiContents = json_decode($aqiURL, true);
                    //$aqi = $aqiContents['list'][0]['main']['aqi'];
                    $aqi = $aqiContents['data']['aqi'];

                    // and the wind speed is " . $weatherArray['wind']['speed'] . "m/s."

                    $uvURL = file_get_contents("https://api.openweathermap.org/data/2.5/uvi?lat=" . urlencode($lat) . "&lon=" . urlencode($lon) . "&appid=074d5c5ffeea065ccae7fd29942036c0");
                    $uvContents = json_decode($uvURL, true);

                    $uvi = $uvContents['value'];

                    if ($weatherType == "Rain") {
                        $background = "../assets/rain.jpg";
                    } else if ($weatherType == "Snow") {
                        $background = "../assets/winter.jpg";
                    } else {
                        $background = "../assets/spring.jpg";
                    }

                } else {

                    $error = "That city does not exist! Please try again";
                }
            }

            ?>
            <div class="safety">
                <h2>Recommendations</h2>
                <div class="safety-info umbrella">
                    <img src="https://img.icons8.com/external-photo3ideastudio-gradient-photo3ideastudio/64/null/external-umbrella-spring-photo3ideastudio-gradient-photo3ideastudio.png" />Umbrella
                    <?php if (!$station) {
                        echo ("<span class='recommend'>N/A</span>");
                    } else if ($weatherType == 'Rain') {
                        echo ("<span class='recommend'>Yes</span>");
                    } else {
                        echo ("<span class='recommend'>No</span>");
                    }
                    ?>
                </div>
                <div class="safety-info sunscreen">
                    <img src="https://img.icons8.com/external-icongeek26-outline-gradient-icongeek26/64/null/external-sunscreen-cosmetics-icongeek26-outline-gradient-icongeek26.png" />Sunscreen
                    <?php if (!$station) {
                        echo ("<span class='recommend'>N/A</span>");
                    } else if ($uvi > 2) {
                        echo "<span class='recommend'>Yes</span>";
                    } else {
                        echo ("<span class='recommend'>No</span>");
                    } ?>
                </div>
                <div class="safety-info clothing">
                    <img src="https://img.icons8.com/nolan/64/clothes.png" />Clothing
                    <?php if (!$station) {
                        echo ("<span class='recommend'>N/A</span>");
                    } else if ($weather > 20) {
                        echo ("<span class='recommend'>Shorts</span>");
                    } else {
                        echo ("<span class='recommend'>Winter Clothes</span>");
                    } ?>
                </div>
                <div class="safety-info heat-stroke">
                    <img src="https://img.icons8.com/nolan/64/temperature.png" />Heat Stroke
                    <?php if (!$station) {
                        echo ("<span class='recommend'>N/A</span>");
                    } else if ($weather > 34) {
                        echo ("<span class='recommend'>Possible</span>");
                    } else {
                        echo ("<span class='recommend'>No</span>");
                    } ?>
                </div>
                <div class="safety-info mask">
                    <img src="https://img.icons8.com/external-xnimrodx-lineal-gradient-xnimrodx/64/null/external-mask-virus-xnimrodx-lineal-gradient-xnimrodx-2.png" />Mask
                    <?php if (!$station) {
                        echo ("<span class='recommend'>N/A</span>");
                    } else if ($aqi > 150) {
                        echo ("<span class='recommend'>Yes</span>");
                    } else {
                        echo ("<span class='recommend'>No</span>");
                    } ?>
                </div>
            </div>
            <div class="weather-details">
                <div class="city-details" style="background: url($background) no-repeat center center fixed;">
                    <h2>
                        <?php
                        if ($station) {
                            echo "Weather in " . $station . " " . $weatherType;
                        }
                        ?>
                    </h2>
                    <h1>
                        <?php
                        if ($station) {
                            echo $weather;
                        }
                        ?>
                    </h1>
                    <p>
                        <?php
                        if ($humid) {
                            echo "Humidity: " . $humid . "%";
                        }
                        ?>
                    </p>
                    <p>
                        <?php
                        if ($speed) {
                            echo "Wind Speed: " . $speed . " m/s";
                        }
                        ?>
                    </p>
                    <p>
                        <?php
                        if ($aqi) {
                            echo "Air Quality: " . $aqi;
                        } else {
                            echo "N/A";
                        }
                        ?>
                    </p>
                    <p>
                        <?php
                        if ($uvi) {
                            echo "UV Index: " . $uvi;
                        }
                        ?>
                    </p>

                </div>
                <div class="user-details">

                </div>
            </div>
        </div>
    </section>
</body>

</html>