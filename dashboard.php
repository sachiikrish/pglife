<?php
session_start();
require "includes/database_connect.php";
if(!isset($_SESSION['user_id'])){
header("location: index.php");
die();
}
$user_id = $_SESSION['user_id'];
$sql_1 = "SELECT * FROM users where id = '$user_id'";
$result_1 = mysqli_query($conn, $sql_1);
if(!$result_1){
echo "Something went wrong!";
return;
}
$user = mysqli_fetch_assoc($result_1);
if(!$user){
echo "Something went wrong!";
return;
}
$sql_2 = "SELECT * 
            FROM interested_users_properties iup
            INNER JOIN properties p ON iup.property_id = p.id
            WHERE iup.user_id = $user_id";
$result_2 = mysqli_query($conn,$sql_2);
if(!$result_2){
echo "Something went wrong!";
return;
}      
$interested_properties = mysqli_fetch_all($result_2, MYSQLI_ASSOC);
?>      




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | PG Life</title>
   <?php 
   include "includes/head_links.php";
   ?>
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <?php
    include "includes/header.php";
    ?>
   
    <div id="loading"></div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>

    <div class="page-container profile-content">
        <div class="my-profile">
            <div id="heading">
                <h1>My Profile</h1>
            </div>
            <div class="profile-card">
                <div class="row justify-content-between">
                    <div class="col-md-3">
                        <div class="profile-img">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row justify-content-evenly">
                            <div class="col-sm-6">
                                <div id="name"><?= $user['full_name'] ?></div>
                                <div id="email"><?= $user['email'] ?></div>
                                <div id="phone"><?= $user['phone']?></div>
                                <div id="college"><?= $user['college_name']?></div>
                            </div>
                            <div class="col-sm-6 align-self-end">
                                <div id="edit">Edit Profile</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-interested-properties">
        <div class="property-page-container">
            <h1>My Interested Properties</h1>
<?php
if(count($interested_properties) > 0){
foreach($interested_properties as $property){
$property_images = glob("img/properties/" . $property['id'] . "/*");
?>
<div class="property-card row property-id-<?= $property['id']?>">
<div class="image-container col-md-4">
    <img src="<?= $property_images[0] ?>" />
</div>
<div class="col-md-8">
    <div class="row no-gutters justify-content-between">
        <?php
         $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3;
         $total_rating = round($total_rating, 1);
         ?>
        <div class="star-container" title="<?= $total_rating?>">
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
        <div class="interested-container">
            <i class="is-interested-image fas fa-heart" property_id ="<?= $property['id']?>"></i>
        </div>
    </div>
    <div class="detail-container">
        <div class="property-name"><?= $property['name']?></div>
        <div class="property-address"><?= $property['address']?></div>
        <div class="gender">
           <?php
           if($property['gender'] == "female"){
?> <img src="img/female.png"/>
           <?php } else if($property['gender'] == "male"){
?> <img src="img/male.png"/>
           <?php } else {
            ?> <img src="img/unisex.png"/>
           <?php } ?>
        </div>
    </div>
    <div class="row no-gutters justify-content-between">
        <div class="rent-container col-6">
            <div class="rent">₹ <?= number_format($property['rent'])?>/-</div>
            <div class="rent-unit">per month</div>
        </div>
        <div class="view-button col-6">
         <a href="property_details.php?property_id=<?= $property['id']?>">
         <button class="btn btn-primary">
                View
            </button>
         </a>  
        </div>
    </div>
</div>
</div>
<?php
}

   
}
else {
    ?>
    <div id="no-interested-properties">
       You have not marked any property as interested yet.
    </div>
    <?php
}
?>
           

        </div>
    </div>

   <?php
   include "includes/footer.php";
   ?>









    <script type="text/javascript" src="js/dashboard.js"></script>   
    
    

</body>

</html>