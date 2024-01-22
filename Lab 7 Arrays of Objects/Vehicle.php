<?php include('Header.php'); ?>
<?php include('Menu.php'); ?>

<div class="content">
    <h2>Vehicles Information</h2>

    <?php
    // Sub-Task 1: Define the Vehicle interface
    interface Vehicle {
        public function displayVehicleInfo();
    }

    // Sub-Task 2: Define the LandVehicle class
    class LandVehicle implements Vehicle {
        protected $make;
        protected $model;
        protected $year;
        protected $price;

        public function __construct($make, $model, $year, $price) {
            $this->make = $make;
            $this->model = $model;
            $this->year = $year;
            $this->price = $price;
        }

        public function displayVehicleInfo() {
            echo "Make: $this->make<br>";
            echo "Model: $this->model<br>";
            echo "Year: $this->year<br>";
            echo "Price: $this->price<br>";
        }
    }

    // Sub-Task 3: Define the Car class (derived from LandVehicle)
    class Car extends LandVehicle {
        private $speedLimit;

        public function __construct($make, $model, $year, $price, $speedLimit) {
            parent::__construct($make, $model, $year, $price);
            $this->speedLimit = $speedLimit;
        }

        public function displayVehicleInfo() {
            parent::displayVehicleInfo();
            echo "Speed Limit: $this->speedLimit<br>";
        }
    }

    // Sub-Task 4: Define the WaterVehicle class
    class WaterVehicle implements Vehicle {
        protected $make;
        protected $model;
        protected $year;
        protected $price;

        public function __construct($make, $model, $year, $price) {
            $this->make = $make;
            $this->model = $model;
            $this->year = $year;
            $this->price = $price;
        }

        public function displayVehicleInfo() {
            echo "Make: $this->make<br>";
            echo "Model: $this->model<br>";
            echo "Year: $this->year<br>";
            echo "Price: $this->price<br>";
        }
    }

    // Sub-Task 5: Define the Boat class (derived from WaterVehicle)
    class Boat extends WaterVehicle {
        private $boatCapacity;

        public function __construct($make, $model, $year, $price, $boatCapacity) {
            parent::__construct($make, $model, $year, $price);
            $this->boatCapacity = $boatCapacity;
        }

        public function displayVehicleInfo() {
            parent::displayVehicleInfo();
            echo "Boat Capacity: $this->boatCapacity<br>";
        }

    }

    // Sub-Task 6: Instantiate and display Car objects
    $car1 = new Car("Toyota", "Camry", 1992, 2000, 180);
    $car2 = new Car("Honda", "Accord", 2002, 6000, 200);

    echo "<h3>Car 1 Information:</h3>";
    $car1->displayVehicleInfo();

    echo "<h3>Car 2 Information:</h3>";
    $car2->displayVehicleInfo();

    // Sub-Task 7: Instantiate and display Boat objects
    $boat1 = new Boat("Yamaha", "Turbo", 1999, 20000, 18);
    $boat2 = new Boat("Hyundai", "XT", 2012, 26000, 8);

    echo "<h3>Boat 1 Information:</h3>";
    $boat1->displayVehicleInfo();

    echo "<h3>Boat 2 Information:</h3>";
    $boat2->displayVehicleInfo();
    ?>
</div>

<?php include('Footer.php'); ?>
