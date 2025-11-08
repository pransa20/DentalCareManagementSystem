<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    $specilization = $_POST['Doctorspecialization'];
    $doctorid = $_POST['doctor'];
    $userid = $_SESSION['id'];
    $fees = $_POST['fees'];
    $appdate = $_POST['appdate'];
    $time = $_POST['apptime'];
    $userstatus = 1;
    $docstatus = 1;

       // Validate the appointment date
    if (DateTime::createFromFormat('Y-m-d', $appdate) === false) {
        echo "<script>alert('Invalid date format. Please use YYYY-MM-DD.');</script>";
    } else {
        // Check if the selected date is in the past
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i'); // Get current time in 24-hour format

        if ($appdate < $currentDate || ($appdate == $currentDate && $time < $currentTime)) {
            echo "<script>alert('You cannot book an appointment for a past date or time. Please select a valid date and time.');</script>";
        } else {
            // Check if the time slot is already booked
            $checkQuery = $con->prepare("SELECT * FROM appointment WHERE appointmentDate = ? AND appointmentTime = ?");
            $checkQuery->bind_param("ss", $appdate, $time);
            $checkQuery->execute();
            $result = $checkQuery->get_result();

            if ($result->num_rows > 0) {
                echo "<script>alert('This time slot is already booked. Please choose a different time.');</script>";
            } else {
                // Prepare and execute the SQL query
                $stmt = $con->prepare("INSERT INTO appointment (doctorSpecialization, doctorId, userId, consultancyFees, appointmentDate, appointmentTime, userStatus, doctorStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("siissssi", $specilization, $doctorid, $userid, $fees, $appdate, $time, $userstatus, $docstatus);
                
                if ($stmt->execute()) {
                    echo "<script>alert('Your appointment has been successfully booked.');</script>";
                } else {
                    echo "<script>alert('Error booking appointment. Please try again.');</script>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User | Book Appointment</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script>
        function getdoctor(val) {
            $.ajax({
                type: "POST",
                url: "get_doctor.php",
                data: 'specilizationid=' + val,
                success: function(data) {
                    $("#doctor").html(data);
                }
            });
        }

        function getfee(val) {
            $.ajax({
                type: "POST",
                url: "get_doctor.php",
                data: 'doctor=' + val,
                success: function(data) {
                    $("#fees").html(data);
                }
            });
        }
    </script>
</head>
<body>
    <div id="app">
        <?php include('include/sidebar.php'); ?>
        <div class="app-content">
            <?php include('include/header.php'); ?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">User  | Book Appointment</h1>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">Book Appointment</h5>
                                            </div>
                                            <div class="panel-body">
                                                <form role="form" name="book" method="post">
                                                    <div class="form-group">
                                                        <label for="DoctorSpecialization">Doctor Specialization</label>
                                                        <select name="Doctorspecialization" class="form-control" onChange="getdoctor(this.value);" required="required">
                                                            <option value="">Select Specialization</option>
                                                            <?php
                                                            $ret = mysqli_query($con, "select * from doctorspecilization");
                                                            while ($row = mysqli_fetch_array($ret)) {
                                                            ?>
                                                                <option value="<?php echo htmlentities($row['specilization']); ?>">
																<?php echo htmlentities($row['specilization']); ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="doctor">Doctors</label>
                                                        <select name="doctor" class="form-control" id="doctor" onChange="getfee(this.value);" required="required">
                                                            <option value="">Select Doctor</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="consultancyfees">Consultancy Fees</label>
                                                        <select name="fees" class="form-control" id="fees" readonly>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="AppointmentDate">Date</label>
                                                        <input type="date" class="form-control" name="appdate" required="required" min="<?php echo date('Y-m-d'); ?>">
                                                    </div>

                                                    <div class="form-group">
														<label for="Appointmenttime">Time</label>
														<select name="apptime" class="form-control" required="required">
															<?php
															// Generate time slots from 10 AM to 5 PM in 12-hour format
															for ($hour = 9; $hour <= 19; $hour++) {
																for ($minute = 0; $minute < 60; $minute += 30) { // 30-minute intervals
																	$time = sprintf('%02d:%02d', $hour, $minute);
																	// Convert to 12-hour format
																	$ampm = $hour < 12 ? 'AM' : 'PM';
																	$displayHour = $hour > 12 ? $hour - 12 : $hour; // Convert to 12-hour format
																	$displayTime = sprintf('%02d:%02d %s', $displayHour, $minute, $ampm);
																	echo "<option value='$time'>$displayTime</option>";
																}
															}
															?>
														</select>
                                                    </div>

                                                    <button type="submit" name="submit" class="btn btn-o btn-primary">
                                                        Submit
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
            <?php include('include/setting.php'); ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize datepicker and timepicker if needed
            // You can use a library like Bootstrap Datepicker or jQuery UI Datepicker if you want more features
            $('#timepicker1').timepicker();
        });
    </script>
</body>
</html>