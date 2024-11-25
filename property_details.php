<?php
session_start();
require "includes/database_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$property_id = $_GET["property_id"];

$sql_1 = "SELECT *, p.id AS property_id, p.name AS property_name, c.name AS city_name 
            FROM properties p
            INNER JOIN cities c ON p.city_id = c.id 
            WHERE p.id = $property_id";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
    echo "Something went wrong!";
    return;
}
$property = mysqli_fetch_assoc($result_1);
if (!$property) {
    echo "Something went wrong!";
    return;
}
$sql_2 = "SELECT * FROM testimonials where property_id = '$property_id'";
$result_2 = mysqli_query($conn, $sql_2);
if (!$result_2) {
    echo "Something went wrong!";
    return;
}
$testimonials = mysqli_fetch_all($result_2, MYSQLI_ASSOC);

$sql_3 = "SELECT a.* 
            FROM amenities a
            INNER JOIN properties_amenities pa ON a.id = pa.amenity_id
            WHERE pa.property_id = $property_id";
$result_3 = mysqli_query($conn, $sql_3);
if (!$result_3) {
    echo "Something went wrong!";
    return;
}
$amenities = mysqli_fetch_all($result_3, MYSQLI_ASSOC);

$sql_4 = "SELECT * FROM interested_users_properties where property_id = '$property_id'";
$result_4 = mysqli_query($conn, $sql_4);
if (!$result_4) {
    echo "Something went wrong!";
    return;
}
$interested_users = mysqli_fetch_all($result_4, MYSQLI_ASSOC);
$interested_users_count = mysqli_num_rows($result_4);
?>









<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $property['property_name'] ?> | PG Life</title>
    <?php
    include "includes/head_links.php";
    ?>
    <link rel="stylesheet" href="css/property_details.css">
</head>

<body>
    <?php
    include "includes/header.php";
    ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="property_list.php?city=<?= $property['city_name'] ?>"><?= $property['city_name'] ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $property['property_name'] ?></li>
        </ol>
    </nav>

    <div id="property-images" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            $property_images = glob("img/properties/" . $property['property_id'] . "/*");
            foreach ($property_images as $index => $property_image) {
            ?>
                <li data-target="#property-images" data-slide-to="<?= $index ?>" class="<?= $index == 0 ? "active" : ""; ?>"></li>
            <?php
            }
            ?>
        </ol>
        <div class="carousel-inner">
            <?php
            foreach ($property_images as $index => $property_image) {
            ?>
                <div class="carousel-item <?= $index == 0 ? "active" : ""; ?>">
                    <img class="d-block w-100" src="<?= $property_image ?>" alt="slide">
                </div>
            <?php
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#property-images" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#property-images" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="page-container">
        <div class="property-details">
            <div class="property-card">
                <div class="row">
                    <div class="col-12">
                        <div class="row justify-content-between stars-heart">
                            <?php
                            $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3;
                            $total_rating = round($total_rating, 1);
                            ?>
                            <div class="col-4" id="stars-container" title="<?= $total_rating ?>">
                                <?php
                                $rating = $total_rating;
                                for ($i = 0; $i < 5; $i++) {
                                    if ($rating >= $i + 0.8) {
                                ?>
                                        <i class="fas fa-star"></i>
                                    <?php
                                    } elseif ($rating >= $i + 0.3) {
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
                            <div class="col-4" id="heart-container">
                                <div id="heart-box">
                                    <?php
                                    $is_interested = false;
                                    foreach ($interested_users as $interested_user) {
                                        if ($interested_user['user_id'] == $user_id) {
                                            $is_interested = true;
                                        }
                                    }

                                    if ($is_interested) {
                                    ?>
                                        <i class="is-interested-image fas fa-heart"></i>
                                    <?php
                                    } else {
                                    ?>
                                        <i class="is-interested-image far fa-heart"></i>
                                    <?php
                                    }
                                    ?>
                                    <div><span class="interested-user-count"><?= $interested_users_count ?></span> interested</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div id="PG-name"><?= $property['property_name'] ?></div>
                        <div id="PG_address"><?= $property['address'] ?></div>
                    </div>
                    <div class="col-12">
                        <div>
                            <?php
                            if ($property['gender'] == "male") {
                            ?>
                                <img src="img/male.png" />
                            <?php
                            } else if ($property['gender'] == "female") {
                            ?>
                                <img src="img/female.png" />
                            <?php
                            } else {
                            ?>
                                <img src="img/unisex.png" />
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-12 price-view">
                        <div class="col-5 price">
                            <div id="price">₹ <?= number_format($property['rent']) ?>/-</div>
                            <div id="unit">per month</div>
                        </div>
                        <div class="col-5 view">
                            <a href="<?= $property['map_location'] ?>" target="_blank"><img src="img/map.png" /></a>
                            <button class="btn btn-primary">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="amenities_details">
            <div class="amenities_card">
                <div class="row">
                    <div class="col-12">
                        <h1>Amenities</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-auto">
                        <div>Building</div>
                        <?php
                        foreach ($amenities as $amenity) {
                            if ($amenity['type'] == "Building") {
                        ?>
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg" /> <?= $amenity['name'] ?> <br />
                        <?php
                            }
                        }
                        ?>

                    </div>
                    <div class="col-md-auto">
                        <div>Common Area</div>
                        <?php
                        foreach ($amenities as $amenity) {
                            if ($amenity['type'] == "Common Area") {
                        ?>
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg" /> <?= $amenity['name'] ?> <br />
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="col-md-auto">
                        <div>Bedroom</div>
                        <?php
                        foreach ($amenities as $amenity) {
                            if ($amenity['type'] == "Bedroom") {
                        ?>
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg" /> <?= $amenity['name'] ?> <br />
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="col-md-auto">
                        <div>Washroom</div>
                        <?php
                        foreach ($amenities as $amenity) {
                            if ($amenity['type'] == "Washroom") {
                        ?>
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg" /> <?= $amenity['name'] ?> <br />
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="about_property">
        <div class="about_card">
            <div class="row">
                <div class="col-md-12">
                    <div>About the Property</div>
                    <p><?= $property['description'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="rating_container">
        <div class="rating_card">
            <div class="row">
                <div class="col-12">
                    <div id="heading">Property Rating</div>
                </div>
                <div class="col-12 content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row items-rating">
                                <div class="col-12">
                                    <div id="items"><i class="fas fa-broom"></i> Cleanliness</div>
                                    <div id="stars-container" title="<?= $property['rating_clean'] ?>">
                                        <?php
                                        $rating = $property['rating_clean'];
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($rating >= $i + 0.8) {
                                        ?>
                                                <i class="fas fa-star"></i>
                                            <?php
                                            } elseif ($rating >= $i + 0.3) {
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
                                </div>
                                <div class="col-12">
                                    <div id="items"><i class="fas fa-utensils"></i> Food Quality</div>
                                    <div id="stars-container" title="<?= $property['rating_food'] ?>">
                                        <?php
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

                                </div>
                                <div class="col-12">
                                    <div id="items"><i class="fa fa-lock"></i> Safety</div>
                                    <div id="stars-container" title="<?= $property['rating_safety'] ?>">
                                        <?php
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

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 round-container">
                            <div class="rounded-circle">
                                <div class="round-card">
                                    <div>
                                        <div id="total-rating" title="<?= $total_rating ?>"><?= $total_rating ?></div>
                                        <div>
                                            <?php
                                            $rating = $total_rating;
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="review-container">
        <div class="review-content">

            <div class="review-heading">
                <div id="review-heading">What people say</div>
            </div>

            <div class="testimonial-block">

                <?php
                foreach ($testimonials as $testimonial) {
                ?>
                    <div class="img-block">
                        <div class="img-container">
                            <img src="img/man.png" />
                        </div>
                    </div>
                    <div class="text-block">
                        <div class="text-container">
                            <i class="fas fa-quote-left"></i>
                            <p><?= $testimonial['content'] ?></p>
                        </div>
                    </div>
                    <div class="text-name-block">
                        <div>- <?= $testimonial['user_name'] ?></div>
                    </div>
                <?php
                }
                ?>



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
    <script type="text/javascript" src="js/property_details.js"></script>
</body>

</html>