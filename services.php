<?php
include_once('dc/include/config.php'); // Include your database configuration

// Fetch services from the database
$query = mysqli_query($con, "SELECT * FROM tblservices");
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Our Services - SmileCare Dental Home</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<header id="menu-jk">
    <div id="nav-head" class="header-nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-12" style="color:black;font-weight:bold; font-size:42px; margin-top: 1% !important;">SmileCare
                    <a data-toggle="collapse" data-target="#menu" href="#menu"><i class="fas d-block d-md-none small-menu fa-bars"></i></a>
                </div>
                <div id="menu" class="col-lg-8 col-md-9 d-none d-md-block nav-item">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="index.php#about_us">About Us</a></li>
                        <li><a href="#contact_us">Contact Us</a></li>
                        <li><a href="#logins">Logins</a></li>
                    </ul>
                </div>
                <div class="col-sm-2 d-none d-lg-block appoint">
                    <button class="btn btn-success">
                        <a href="dc/user-login.php" target="_blank">Book an Appointment</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<section id="services" class="key-features department">
    <div class="container">
        <div class="inner-title">
            <h2 style="color: #895129">Our Services</h2>
        </div>

        <div class="row" style="color:black">
            <?php while ($row = mysqli_fetch_array($query)) { ?>
                <div class="col-lg-4 col-md-6">
                    <div class="single-key">
                        <h2 style="color:blue"><?php echo $row['service_name']; ?></h2>
                        <p><?php echo $row['description']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>


<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h2>Useful Links</h2>
                <ul class="list-unstyled link-list">
                    <li><a href="index.php">Home</a><i class="fa fa-angle-right"></i></li>
                    <li><a href="index.php#about_us">About us</a><i class="fa fa-angle-right"></i></li>
                    <li><a href="#contact_us">Contact us</a><i class="fa fa-angle-right"></i></li>
                </ul>
            </div>
            <div class="col-md-6 col-sm-12">
                <h2>Contact Us</h2>
                <address class="md-margin-bottom-40">
                <?php
$ret=mysqli_query($con,"select * from tblpage where PageType='contactus' ");
while ($row=mysqli_fetch_array($ret)) {
?>


                        <?php  echo $row['PageDescription'];?> <br>
                        Phone: <?php  echo $row['MobileNumber'];?> <br>
                        Email: <a href="mailto:<?php  echo $row['Email'];?>" class=""><?php  echo $row['Email'];?></a><br>
                        Timing: <?php  echo $row['OpenningTime'];?>
                    </address>

        <?php } ?>
                    
                </address>
            </div>
        </div>
    </div>
</footer>

<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>