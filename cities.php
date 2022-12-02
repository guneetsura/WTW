<!DOCTYPE html>
<html>

<head>
    <title>
        WTW - Cities
    </title>
    <link rel="stylesheet" type="text/css" href="./styles/cities.css">
</head>
<?php
error_reporting(0);
ini_set('display_errors', 0);
require 'config.php';
$s = $_SESSION['email'];
?>

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
            $background = "";
            $weather = "";
            $error = "";
            $city = $_POST['city'];
            $station = $_SESSION['city'];

            if (isset($_POST['city'])) {
                $station = $_POST['city'];
            }

            if ($station) {

                $urlContents = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($station) . "&units=metric&appid=074d5c5ffeea065ccae7fd29942036c0");

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

                    $background = "https://source.unsplash.com/1600x900/?" . $weatherType;

                    // if ($weatherType == "Rain") {
                    //     $background = "./assets/rain.jpg";
                    // } else if ($weatherType == "Snow") {
                    //     $background = "./assets/winter.jpg";
                    // } else if ($weatherType == 'Sunny') {
                    //     $background = "./assets/summer.jpg";
                    // } else {
                    //     $background = "./assets/spring.jpg";
                    // }
                } else {

                    $error = "That city does not exist! Please try again";
                }
            }

            $advise = "No travel restrictions required.";
            $medcon = "";
            $alertIcon = "";

            if (!empty($s)) {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $conn = new PDO("mysql:host=$servername;dbname=weather-sign-up", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT medical FROM registration WHERE email='$s' ";
                $result = $conn->query($sql);
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $m = $row["medical"];
                    $strm = explode(',', $m);

                    foreach ($strm as $val) {
                        // echo $val . " ";
                        if ($val == 'Asthama' && $aqi > 150 || $val == 'Skin Disease' && $uvi > 7 || $val == 'Cancer' && $uvi > 7 || $val == 'Photophobia' && $weatherType == 'Sunny') {
                            $medcon .= $val . ",";
                            $alertIcon = "<img class='alert-img' src='./assets/icons/warning.png' alt='alert' />";
                            $advise = "Not Advised to travel!";
                        } else {
                            $medcon .= $val . ",";
                        }
                    }
                }
            }

            ?>
            <div class="weather-details">
                <div class="city-details" style="background: url(<?php if ($background) {
                                                                        echo $background;
                                                                    } else if(empty($background)) {
                                                                        $background = './assets/quote.png';
                                                                        echo $background;
                                                                    } ?>) no-repeat center center; 
                                                                    background-size: 100% 100%;
                                                                     background-color: rgba(0,0,0,0.2);">
                    <div class="city-overlay">
                        <h2>
                            <?php
                            if ($station) {
                                echo "Weather in " . ucfirst($station);
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
                        <div class="city-info">
                            <div class="city-info-1">
                                <p>
                                    <?php
                                    if ($humid) {
                                        echo "<img src='./assets/icons/humidity.png' alt='humidity' alt='humidity' /> " . $humid . "%";
                                    }
                                    ?>
                                </p>
                                <p>
                                    <?php
                                    if ($speed) {
                                        echo "<img src='./assets/icons/wind.png' alt='wind' /> " . $speed . " m/s";
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="city-info-2">
                                <p>
                                    <?php
                                    if ($aqi) {
                                        echo "<img src='./assets/icons/air-quality.png' alt='air quality' /> " . $aqi;
                                    }
                                    ?>
                                </p>
                                <p>
                                    <?php
                                    if ($uvi) {
                                        echo "<img src='./assets/icons/uvi.png' alt='uv index' /> " . $uvi;
                                    }
                                    ?>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="user-details">
                    <p class="med-alert">Alerts <?php if ($alertIcon) {
                                                    echo $alertIcon;
                                                } ?></p>
                    <?php
                    if ($medcon) {
                        $correctMedical = "";
                        $medi = explode(',', $m);
                        foreach ($medi as $medval) {
                            if (!empty($medval)) {
                                echo "<p class='med-alert-msg'>For " . $medval . ": " . $advise . "</p>";
                            }
                        }
                    } else {
                        echo "<p class='med-alert-msg'>" . $advise . "</p>";
                    }
                    ?>
                    </p>
                </div>
            </div>
            <div class="safety">
                <h2>Recommendations</h2>
                <div class="safety-info umbrella">
                    <img src="./assets/icons/umbrella.png" />Umbrella
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
                    <img src="./assets/icons/sunscreen.png" />Sunscreen
                    <?php if (!$station) {
                        echo ("<span class='recommend'>N/A</span>");
                    } else if ($uvi > 2) {
                        echo "<span class='recommend'>Yes</span>";
                    } else {
                        echo ("<span class='recommend'>No</span>");
                    } ?>
                </div>
                <div class="safety-info clothing">
                    <img src="./assets/icons/clothes.png" />Clothing
                    <?php if (!$station) {
                        echo ("<span class='recommend'>N/A</span>");
                    } else if ($weather > 20) {
                        echo ("<span class='recommend'>Shorts</span>");
                    } else {
                        echo ("<span class='recommend'>Winter Clothes</span>");
                    } ?>
                </div>
                <div class="safety-info heat-stroke">
                    <img src="./assets/icons/temperature.png" />Heat Stroke
                    <?php if (!$station) {
                        echo ("<span class='recommend'>N/A</span>");
                    } else if ($weather > 34) {
                        echo ("<span class='recommend'>Possible</span>");
                    } else {
                        echo ("<span class='recommend'>No</span>");
                    } ?>
                </div>
                <div class="safety-info mask">
                    <img src="./assets/icons/mask.png" />Mask
                    <?php if (!$station) {
                        echo ("<span class='recommend'>N/A</span>");
                    } else if ($aqi > 150) {
                        echo ("<span class='recommend'>Yes</span>");
                    } else {
                        echo ("<span class='recommend'>No</span>");
                    } ?>
                </div>
            </div>
        </div>
    </section>
</body>

</html>