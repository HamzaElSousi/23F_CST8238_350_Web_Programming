<?php

// Handle form submission for adding appointments
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointmentTitle']) && isset($_POST['appointmentDate'])) {
    $appointmentTitle = $_POST['appointmentTitle'];
    $appointmentDate = $_POST['appointmentDate'];

    // Save appointment details to a text file
    file_put_contents('TextFiles/appointments.txt', "$appointmentTitle|$appointmentDate\n", FILE_APPEND | LOCK_EX);
}

// Function to get the first day of the month
function getFirstDayOfMonth($year, $month) {
    return date('N', strtotime("$year-$month-01"));
}

// Function to get the last day of the month
function getLastDayOfMonth($year, $month) {
    return date('t', strtotime("$year-$month-01"));
}

// Function to get appointments from the file for a specific month
function getAppointments($year, $month) {
    $appointments = [];
    $appointmentsFile = 'TextFiles/appointments.txt';

    if (file_exists($appointmentsFile)) {
        $appointmentsData = file($appointmentsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES | FILE_TEXT);
        foreach ($appointmentsData as $appointment) {
            list($title, $date) = explode('|', $appointment);
            $appointmentYear = date('Y', strtotime($date));
            $appointmentMonth = date('m', strtotime($date));

            if ($appointmentYear == $year && $appointmentMonth == $month) {
                $appointments[] = [
                    'title' => $title,
                    'date' => $date,
                ];
            }
        }
    }

    return $appointments;
}

// Function to generate the calendar
function generateCalendar($year, $month) {
    $firstDay = getFirstDayOfMonth($year, $month);
    $lastDay = getLastDayOfMonth($year, $month);
    $appointments = getAppointments($year, $month);

    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Sun</th>';
    echo '<th>Mon</th>';
    echo '<th>Tue</th>';
    echo '<th>Wed</th>';
    echo '<th>Thu</th>';
    echo '<th>Fri</th>';
    echo '<th>Sat</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    $dayCount = 1;
    $currentDay = 1;

    // Loop through each week
    for ($i = 0; $i < 6; $i++) {
        echo '<tr>';

        // Loop through each day of the week
        for ($j = 0; $j < 7; $j++) {
            // Check if the current cell should be empty
            if (($i == 0 && $j < $firstDay - 1) || ($currentDay > $lastDay)) {
                echo '<td></td>';
            } else {
                echo '<td>' . $currentDay;

                // Check if there are appointments for this day
                foreach ($appointments as $appointment) {
                    $appointmentDay = date('j', strtotime($appointment['date']));
                    if ($appointmentDay == $currentDay) {
                        echo '<br><span class="appointment">' . htmlspecialchars($appointment['title']) . '</span>';
                    }
                }

                echo '</td>';
                $currentDay++;
            }

            $dayCount++;
        }

        echo '</tr>';

        // If we have reached the last day of the month, break the loop
        if ($currentDay > $lastDay) {
            break;
        }
    }

    echo '</tbody>';
    echo '</table>';
}

// Get the current year and month
$currentYear = date('Y');
$currentMonth = date('m');

// Handle navigation if provided in the URL
if (isset($_GET['year']) && isset($_GET['month'])) {
    $currentYear = $_GET['year'];
    $currentMonth = $_GET['month'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="author" content="">
   <title>Calendar</title>

   <link rel="shortcut icon" href="assets/ico/favicon.png">

   <!-- Google fonts used in this theme -->
   <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
   <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic,700italic' rel='stylesheet' type='text/css'>  

   <!-- Bootstrap core CSS -->
   <link href="bootstrap3_bookTheme/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Bootstrap theme CSS -->
   <link href="bootstrap3_bookTheme/theme.css" rel="stylesheet">

   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!--[if lt IE 9]>
   <script src="bootstrap3_bookTheme/assets/js/html5shiv.js"></script>
   <script src="bootstrap3_bookTheme/assets/js/respond.min.js"></script>
   <![endif]-->
</head>

<body>

<?php include 'includes/book-header.inc.php';?>

<div class="container">
   <div class="row">  <!-- start main content row -->

      <div class="col-md-2">  <!-- start left navigation rail column -->
         <?php include 'includes/book-left-nav.inc.php'; ?>
      </div>  <!-- end left navigation rail --> 

      <div class="col-md-10">  <!-- start main content column -->

         <!-- Calendar panel -->
         <div class="panel panel-primary spaceabove">
            <div class="panel-heading">
               <h4>Calendar</h4>
            </div>

        <!-- Add this code inside the Calendar panel, after displaying the current month -->
            <div class="text-center">
                <span class="current-month"><?php echo date('F Y', strtotime("$currentYear-$currentMonth-01")); ?></span>
            </div>

            <!-- Form for adding appointments -->
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="form-group">
                    <label for="appointmentTitle">Appointment Title:</label>
                    <input type="text" class="form-control" id="appointmentTitle" name="appointmentTitle" required>
                </div>
                <div class="form-group">
                    <label for="appointmentDate">Appointment Date:</label>
                    <input type="date" class="form-control" id="appointmentDate" name="appointmentDate" required>
                </div>
                <!-- Add more fields if needed -->

                <button type="submit" class="btn btn-primary">Add Appointment</button>
            </form>


            <?php generateCalendar($currentYear, $currentMonth); ?>
         </div>
      </div>

   </div>  <!-- end main content row -->
   <div class="well well-sm">
         This Software assignment was created by <em>Hamza El Sousi</em>  
         <b>&copy; 2023 Customer Relation Management System</b>
    </div> 
</div>   <!-- end container -->

<!-- Bootstrap core JavaScript -->
<script src="bootstrap3_bookTheme/assets/js/jquery.js"></script>
<script src="bootstrap3_bookTheme/dist/js/bootstrap.min.js"></script>
<script src="bootstrap3_bookTheme/assets/js/holder.js"></script>
</body>
</html>
