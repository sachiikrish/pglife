<?php
session_start();
require "includes/database_connect.php";


$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$city_name = $_GET["city"];
$sql_1 = "SELECT * FROM cities where name = '$city_name'";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
    echo "Something went wrong!";
    return;
}
$city = mysqli_fetch_assoc($result_1);
if (!$city) {
    echo "Sorry! We do not have any PG listed in this city.";
    return;
}
$city_id = $city['id'];

$properties = [];
$gender_filter = isset($_GET['gender']) ? $_GET['gender'] : NULL;

if (isset($_GET['filter'])) {
    if ($_GET['filter'] == "rent_desc") {
        $sql_2 = "SELECT * FROM properties WHERE city_id = '$city_id' ORDER BY rent DESC";
    } elseif ($_GET['filter'] == "rent_asc") {
        $sql_2 = "SELECT * FROM properties WHERE city_id = '$city_id' ORDER BY rent ASC";
    }
} elseif ($gender_filter) {
    if ($gender_filter == "male") {
        $sql_2 = "SELECT * FROM properties WHERE city_id='$city_id' AND gender = 'male'";
    } elseif ($gender_filter == 'female') {
        $sql_2 = "SELECT * FROM properties WHERE city_id='$city_id' AND gender = 'female'";
    } elseif ($gender_filter == "unisex") {
        $sql_2 = "SELECT * FROM properties WHERE city_id='$city_id' AND gender = ''";
    }
} else {
    $sql_2 = "SELECT * FROM properties WHERE city_id = '$city_id'";
}


$result_2 = mysqli_query($conn, $sql_2);
if (!$result_2) {
    echo "Something went wrong!";
    return;
}
$properties = mysqli_fetch_all($result_2, MYSQLI_ASSOC);


$sql_3 =  "SELECT * 
FROM interested_users_properties iup
INNER JOIN properties p ON iup.property_id = p.id
WHERE p.city_id = $city_id";
$result_3 = mysqli_query($conn, $sql_3);
if (!$result_3) {
    echo "Something went wrong!";
    return;
}
$interested_users_properties = mysqli_fetch_all($result_3, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best PG's in Mumbai | PG Life</title>
    <?php
    include "includes/head_links.php";
    ?>
    <link rel="stylesheet" href="css/property_list.css">
</head>

<body>
    <?php
    include "includes/header.php";
    ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $city['name'] ?></li>
        </ol>
    </nav>

    <div class="page-container">
        <div class="cards_box">
            <div class="icons_card">
                <div class="icons_card_box">
                    <div class="row justify-content-evenly">
                        <div class="col-sm-4">
                            <div class="rounded-circle">
                                <a href="" data-bs-toggle="modal" data-bs-target="#FilterModal"><img class="icon-img"
                                        src="img/filter.png" /></a>
                            </div>
                            <a data-bs-toggle="modal" data-bs-target="#FilterModal" class="icon-text" href="">Filter</a>
                        </div>
                        <div class="col-sm-4">
                            <div class="rounded-circle">
                                <div class="sort-btn" data-sort="DESC">
                                    <img class="icon-img" src="img/desc.png" alt="sort-desc" />
                                </div>

                            </div>
                            <a class="icon-text" href="property_list.php?city=<?= $city_name ?>&filter=rent_desc">Highest rent first</a>
                        </div>
                        <div class="col-sm-4">
                            <div class="rounded-circle">
                                <div class="sort-btn" data-sort="ASC">
                                    <img class="icon-img" src="img/asc.png" alt="sort-asc" />
                                </div>
                            </div>
                            <a class="icon-text" href="property_list.php?city=<?= $city_name ?>&filter=rent_asc">Lowest rent first</a>
                        </div>
                    </div>
                </div>

            </div>

            <?php
            foreach ($properties as $property) {
                $property_images = glob("img/properties/" . $property['id'] . "/*");
            ?>
                <div id="properties_cards_box">
                    <div class="property_card property-id-<?= $property['id'] ?>">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="image-container">
                                    <img src="<?= $property_images[0] ?>" />
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row justify-content-between" id="stars-heart">
                                    <?php
                                    $total_ratings = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3;
                                    $total_ratings = round($total_ratings, 1);
                                    ?>
                                    <div class="col-4 stars-container" title="<?= $total_ratings ?>">
                                        <?php
                                        $rating = $total_ratings;
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($rating >= $i + 0.8) {
                                        ?>
                                                <i class="fas fa-star"></i>
                                            <?php
                                            } else if ($rating >= $i + 0.3) {
                                            ?>
                                                <i class="fas fa-star-half-alt"></i>
                                            <?php
                                            } else {
                                            ?>
                                                <i class="far fa-star"></i>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="col-4 heart-container">



                                        <div>
                                            <?php
                                            $interested_users_count = 0;
                                            $is_interested = false;
                                            foreach ($interested_users_properties as $interested_user_property) {
                                                if ($interested_user_property['property_id'] == $property['id']) {
                                                    $interested_users_count++;
                                                    if ($interested_user_property['user_id'] == $user_id) {
                                                        $is_interested = true;
                                                    }
                                                }
                                            }
                                            if ($is_interested) {
                                            ?>
                                                <i class="is-interested-image fas fa-heart" property_id="<?= $property['id'] ?>"></i>
                                            <?php
                                            } else {
                                            ?>
                                                <i class="is-interested-image far fa-heart" property_id="<?= $property['id'] ?>"></i>
                                            <?php
                                            }
                                            ?>
                                            <div>
                                                <span class="interested-user-count"><?= $interested_users_count ?></span> interested
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="address-card">
                                    <div class="col-md-9">
                                        <div id="PG-name">
                                            <?= $property['name'] ?>
                                        </div>
                                        <div id="address">
                                            <?= $property['address'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="gender">
                                        <?php
                                        if ($property['gender'] == "male") {
                                        ?>
                                            <img src="img/male.png" />
                                        <?php                                    } else if ($property['gender'] == "female") {
                                        ?>
                                            <img src="img/female.png" />
                                        <?php } else {
                                        ?>
                                            <img src="img/unisex.png" />
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 price">
                                        <div id="price">₹ <?= number_format($property['rent']) ?>/-</div>
                                        <div id="per-month">per month</div>
                                    </div>
                                    <div class="col-6 view">
                                        <div class="row">
                                            <div class="col-2">
                                                <a target="_blank" href="<?= $property['map_location'] ?>"><img src="img/map.png" /></a>
                                            </div>
                                            <div class="col-10">
                                                <button id="view-btn" class="btn btn-primary">
                                                    <a href="property_details.php?property_id= <?= $property['id'] ?>">View</a>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            if (count($properties) == 0) {
            ?>
                <div class="no-property-container">
                    <p>No PG to list</p>
                </div>
            <?php
            }
            ?>

            <div class="modal fade" id="FilterModal" aria-labelledby="filter_modal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Filters</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Gender
                            <div id="button-box">

                                <a href="property_list.php?city=<?= $city_name ?>"><button class="btn btn-dark">No Filter</button></a>
                                <a href="property_list.php?city=<?= $city_name ?>&gender=unisex"><button class="btn btn-outline-dark"><i class="fas fa-venus-mars"></i>
                                        Unisex</button></a>
                                <a href="property_list.php?city=<?= $city_name ?>&gender=male"><button class="btn btn-outline-dark"><i class="fas fa-mars"></i> Male</button></a>
                                <a href="property_list.php?city=<?= $city_name ?>&gender=female"><button class="btn btn-outline-dark"><i class="fas fa-venus"></i>
                                        Female</button></a>
                            </div>
                        </div>
                        <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Okay</button>
                        </div> -->
                    </div>
                </div>
            </div>





            <div id="space"></div>



            <?php
            include "includes/signup_modal.php";
            include "includes/login_modal.php";
            include "includes/footer.php";
            ?>







            <script type="text/javascript" src="js/bootstrap.min.js"></script>
            <script type="text/javascript" src="js/property_list.js"></script>



</body>

</html>