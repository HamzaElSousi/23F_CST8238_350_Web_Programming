<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for tasks
    if (isset($_POST['task'])) {
        $task = $_POST['task'];
        $details = isset($_POST['details']) ? $_POST['details'] : '';
        file_put_contents('TextFiles/Task.txt', "$task|$details\n", FILE_APPEND | LOCK_EX);
    }

    // Handle form submission for notes
    if (isset($_POST['note'])) {
        $note = $_POST['note'];
        file_put_contents('TextFiles/Notes.txt', "$note\n", FILE_APPEND | LOCK_EX);
    }

    // Handle note deletion
    if (isset($_POST['deleteNote'])) {
        $index = $_POST['deleteNote'];
        $notes = file('TextFiles/Notes.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (isset($notes[$index])) {
            unset($notes[$index]);
            file_put_contents('TextFiles/Notes.txt', implode("\n", $notes));
        }
    }

    // Handle task completion
    if (isset($_POST['completeTask'])) {
        $index = $_POST['completeTask'];
        $tasksData = file('TextFiles/Task.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (isset($tasksData[$index])) {
            $taskDetails = explode('|', $tasksData[$index]);
            $completedTask = $taskDetails[0];
            $completedDetails = isset($taskDetails[1]) ? $taskDetails[1] : '';
            file_put_contents('TextFiles/CompletedTasks.txt', "$completedTask|$completedDetails\n", FILE_APPEND | LOCK_EX);

            // Remove the completed task from the Task.txt file
            unset($tasksData[$index]);
            file_put_contents('TextFiles/Task.txt', implode("\n", $tasksData));
        }
    }
}

// Read tasks from Task.txt
$tasksData = file('TextFiles/Task.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Extract tasks and details from the data
$tasks = [];
foreach ($tasksData as $taskData) {
    list($task, $details) = explode('|', $taskData, 2) + [NULL, NULL];
    $tasks[] = ['task' => $task, 'details' => $details];
}

// Read completed tasks from CompletedTasks.txt
$completedTasksData = file('TextFiles/CompletedTasks.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Extract completed tasks and details from the data
$completedTasks = [];
foreach ($completedTasksData as $completedTaskData) {
    list($completedTask, $completedDetails) = explode('|', $completedTaskData, 2) + [NULL, NULL];
    $completedTasks[] = ['task' => $completedTask, 'details' => $completedDetails];
}

// Read notes from Notes.txt
$notes = file('TextFiles/Notes.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="author" content="">
   <title>Task Manager</title>

   <link rel="shortcut icon" href="../../assets/ico/favicon.png">   

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

      <div class="col-md-8">  <!-- start main content column -->
         <!-- Task panel -->
         <div class="panel panel-danger spaceabove">
            <div class="panel-heading">
               <h4>Tasks</h4>
            </div>

            <form action="tasks.php" method="post">
               <div class="form-group">
                  <label for="task">Add Task:</label>
                  <input type="text" class="form-control" id="task" name="task" required>
               </div>
               <div class="form-group">
                  <label for="details">Details:</label>
                  <input type="text" class="form-control" id="details" name="details">
               </div>
               <button type="submit" class="btn btn-primary">Add</button>
            </form>

            <ul class="list-group">
               <?php
               // Display tasks
               if ($tasks) {
                  foreach ($tasks as $index => $task) {
                     echo '<li class="list-group-item">';
                     echo '<form action="tasks.php" method="post" class="form-inline">';
                     echo '<input type="hidden" name="completeTask" value="' . $index . '">';
                     echo '<button type="submit" class="btn btn-link"><span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span></button>';
                     echo '<span class="task-text">' . htmlspecialchars($task['task']) . '</span>';
                     if ($task['details']) {
                        echo '<br><span class="task-details">' . htmlspecialchars($task['details']) . '</span>';
                     }
                     echo '</form>';
                     echo '</li>';
                  }
               } else {
                  echo '<li class="list-group-item">No tasks available.</li>';
               }
               ?>
            </ul>
         </div>

         <!-- Completed Tasks panel -->
         <div class="panel panel-success spaceabove">
            <div class="panel-heading">
               <h4>Completed Tasks</h4>
            </div>

            <ul class="list-group">
               <?php
               // Display completed tasks
               if ($completedTasks) {
                  foreach ($completedTasks as $completedTask) {
                     echo '<li class="list-group-item">';
                     echo '<span class="glyphicon glyphicon-check" aria-hidden="true"></span>';
                     echo '<span class="task-text">' . htmlspecialchars($completedTask['task']) . '</span>';
                     if ($completedTask['details']) {
                        echo '<br><span class="task-details">' . htmlspecialchars($completedTask['details']) . '</span>';
                     }
                     echo '</li>';
                  }
               } else {
                  echo '<li class="list-group-item">No completed tasks yet.</li>';
               }
               ?>
            </ul>
         </div>

         <!-- Notes panel -->
         <div class="panel panel-info spaceabove">
            <div class="panel-heading">
               <h4>Notes</h4>
            </div>

            <form action="tasks.php" method="post">
               <div class="form-group">
                  <label for="note">Add Note:</label>
                  <textarea class="form-control" id="note" name="note" rows="3" required></textarea>
               </div>
               <button type="submit" class="btn btn-primary">Add</button>
            </form>

            <ul class="list-group">
               <?php
               // Display notes
               if ($notes) {
                  foreach ($notes as $index => $note) {
                     echo '<li class="list-group-item">';
                     echo '<form action="tasks.php" method="post" class="form-inline">';
                     echo '<input type="hidden" name="deleteNote" value="' . $index . '">';
                     echo '<button type="submit" class="btn btn-link"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                     echo '<span class="note-text">' . htmlspecialchars($note) . '</span>';
                     echo '</form>';
                     echo '</li>';
                  }
               } else {
                  echo '<li class="list-group-item">No notes available.</li>';
               }
               ?>
            </ul>
         </div>
      </div>

   </div>  <!-- end main content row -->
</div>   <!-- end container -->

<!-- Bootstrap core JavaScript -->
<script src="bootstrap3_bookTheme/assets/js/jquery.js"></script>
<script src="bootstrap3_bookTheme/dist/js/bootstrap.min.js"></script>
<script src="bootstrap3_bookTheme/assets/js/holder.js"></script>
</body>
</html>
