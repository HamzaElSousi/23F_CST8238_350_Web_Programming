<?php
header('Content-Type: text/html; charset=UTF-8');

// Task 2
$customers = [];
$lines = file('orders/customers.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES | FILE_TEXT);
foreach ($lines as $line) {
    $customerData = explode(',', $line);
    if (count($customerData) >= 7) {
        $customerId = $customerData[0];
        // Convert customer data to UTF-8 encoding
         $customerId = $customerData[0];
         $firstName = mb_convert_encoding($customerData[1], 'UTF-8', 'auto');
         $lastName = mb_convert_encoding($customerData[2], 'UTF-8', 'auto');
         $email = mb_convert_encoding($customerData[3], 'UTF-8', 'auto');
         $university = mb_convert_encoding($customerData[4], 'UTF-8', 'auto');
         $city = mb_convert_encoding($customerData[6], 'UTF-8', 'auto');
         $customers[] = [
            'id' => $customerId,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'university' => $university,
            'city' => $city,
        ];
    }
}

// Task 4
$orders = [];
$customerHasOrder = false;
if (isset($_GET['customer_id'])) {
    $customerId = $_GET['customer_id'];
    $orderLines = file('orders/orders.txt'); // Update the path if necessary
    foreach ($orderLines as $orderLine) {
        $orderData = explode(',', $orderLine);
        if (count($orderData) >= 5 && $orderData[1] == $customerId) {
            $isbn = isset($orderData[2]) ? utf8_encode($orderData[2]) : '';
            $title = isset($orderData[3]) ? utf8_encode($orderData[3]) : '';
            $category = isset($orderData[4]) ? utf8_encode($orderData[4]) : '';
            $orders[] = [
                'isbn' => $isbn,
                'title' => $title,
                'category' => $category,
            ];
            $customerHasOrder = true;
        }
    }
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
   <title>Book Template</title>

   <link rel="shortcut icon" href="assets/ico/favicon.png">

   <!-- Google fonts used in this theme  -->
<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic,700italic' rel='stylesheet' type='text/css'>  

   <!-- Bootstrap core CSS -->
   <link href="bootstrap3_bookTheme/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Update the path if necessary -->
   <!-- Bootstrap theme CSS -->
   <link href="bootstrap3_bookTheme/theme.css" rel="stylesheet"> <!-- Update the path if necessary -->

   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!--[if lt IE 9]>
   <script src="../bootstrap3_bookTheme/assets/js/html5shiv.js"></script>
   <script src="../bootstrap3_bookTheme/assets/js/respond.min.js"></script>
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
        
         <!-- Customer panel  -->
         <div class="panel panel-danger spaceabove">
            <div class="panel-heading"><h4>My Customers</h4></div>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>University</th>
                    <th>City</th>
                </tr>
                <?php foreach ($customers as $customer) { ?>
                    <tr>
                        <td><a href="orders.php?customer_id=<?php echo $customer['id']; ?>"><?php echo $customer['firstName'] . ' ' . $customer['lastName']; ?></a></td>
                        <td><?php echo $customer['email']; ?></td>
                        <td><?php echo $customer['university']; ?></td>
                        <td><?php echo $customer['city']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

         <!-- Order panel -->
         <?php if (isset($_GET['customer_id'])) {
            $requestedCustomerId = $_GET['customer_id'];
            $selectedCustomer = null;

            // Find the selected customer based on the customer ID
            foreach ($customers as $customer) {
                if ($customer['id'] == $requestedCustomerId) {
                    $selectedCustomer = $customer;
                    break;
                }
            }

            if ($selectedCustomer) {
                ?>
                <div class="panel panel-info spaceabove">
                    <div class="panel-heading">
                        <h4>Orders for <?php echo $selectedCustomer['firstName'] . ' ' . $selectedCustomer['lastName']; ?></h4>
                    </div>
                    <?php if ($customerHasOrder) { ?>
                        <table class="table">
                            <tr>
                                <th>ISBN</th>
                                <th>Title</th>
                                <th>Category</th>
                            </tr>
                            <?php foreach ($orders as $order) { ?>
                                <tr>
                                    <td><?php echo $order['isbn']; ?></td>
                                    <td><?php echo $order['title']; ?></td>
                                    <td><?php echo $order['category']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } else { ?>
                        <div class="panel-body">
                            <p>No order information for the requested customer.</p>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
               <div class="panel-body">
                     <p>No order information for the requested customer.</p>
               </div>
               <?php } ?>
            </div>
         <?php } ?>
      </div>

   </div>  <!-- end main content row -->
</div>   <!-- end container -->
   
 <!-- Bootstrap core JavaScript
 ================================================== -->
 <!-- Placed at the end of the document so the pages load faster -->
 <script src="../bootstrap3_bookTheme/assets/js/jquery.js"></script>
 <script src="../bootstrap3_bookTheme/dist/js/bootstrap.min.js"></script>
 <script src="../bootstrap3_bookTheme/assets/js/holder.js"></script>
</body>
</html>
