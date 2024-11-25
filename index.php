<?php
session_start();
require "includes/database_connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | PG Life</title>
    <?php
    include "includes/head_links.php"
    ?>
    <link rel="stylesheet" href="css/home.css">
</head>

<body>

    <?php
    include "includes/header.php";
    ?>

    <div class="bg-container">
        <div class="content">
            <h2 class="text-white pd-3">Happiness per Square Foot</h2>

            <div id="search-bar">
                <div class="row justify-content-center">
                    <div class="col-5">
                        <form id="search-form" action="property_list.php" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city to search for PGs" aria-label="city" aria-describedby="addon-wrapping">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary btn-md"><i class="fa fa-search"></i></button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-container">
        <div class="cities-content">
            <h1>Major Cities</h1>
            <div id="cards-content">
                <div class="cards-box">
                    <div class="row">
                        <div class="col-md">
                            <a href="property_list.php?city=Delhi">
                                <div class="rounded-circle cards-container">
                                    <img src="img/delhi.png" class="city-img" />
                                </div>
                            </a>
                        </div>
                        <div class="col-md">
                            <a href="property_list.php?city=Mumbai">
                                <div class="rounded-circle cards-container">
                                    <img src="img/mumbai.png" class="city-img" />
                                </div>
                            </a>
                        </div>
                        <div class="col-md">
                            <a href="property_list.php?city=Bengaluru">
                                <div class="rounded-circle cards-container">
                                    <img src="img/bangalore.png" class="city-img" />
                                </div>
                            </a>
                        </div>
                        <div class="col-md">
                            <a href="property_list.php?city=Hyderabad">
                                <div class="rounded-circle cards-container">
                                    <img src="img/hyderabad.png" class="city-img" />
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    include "includes/signup_modal.php";
    include "includes/login_modal.php";
    include "includes/footer.php";
    ?>






    <script type="text/javascript" src="js/bootstrap.min.js"></script>

</body>

</html>