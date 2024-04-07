<?php
/**
* Check submit button, take data and save to DB
*/
require_once("header.php");
require_once("data.php");
$db = new DBConnection();
$errors = [];

$ferries = $db->getAllFerries()->fetchAll();
$rooms = $db->getAllRooms()->fetchAll();

// Initialize variables
$name = $departuretime = $ferry = $room = '';

// if there is id in the URL, get data
if (isset($_GET["id"])) {
    $result = $db->getPassengerById($_GET["id"]);
    if ($result) {
        $passenger = $result->fetch();
        $name = $passenger["name"];
        $departuretime = $passenger["departuretime"];
        $ferry = $passenger["ferry_id"];
        $room = $passenger["room_id"];
    }
}

if (isset($_POST["submit"])) {
    // check name first, set error if no value
    if (empty($_POST["name"])) {
        array_push($errors, "Name is required");
    } else {
        $name = $_POST["name"];
    }
 
    if (empty($_POST["departuretime"])) {
        array_push($errors, "Booked departure time is required");
    } else {
        $departuretime = $_POST["departuretime"];
        if (strlen($departuretime) != 4) {
            array_push($errors, "Departure time must be exactly 4 characters");
        }
    }

    // Assign selected ferry and room
    $ferry = $_POST["ferry"];
    $room = $_POST["room"];

    if (count($errors) == 0) {
        if (isset($_GET["id"])) {
            $db->updatePassenger($_GET["id"], $name, $departuretime, $ferry, $room);
        } else {
            $db->addPassenger($name, $departuretime, $ferry, $room);
        }
        header("Location: listPassenger.php");
        exit(); // Always exit after header redirect
    }
}
?>

<div class="container mt-4">
   <form class="form" action="" method="post">
       <div class="row mt-3">
           <div class="col-4">
               <label for="name">Passenger Name</label>
               <input class="form-control" type="text" name="name"
                   value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter Passenger Name"/>
           </div>
       </div>
       <div class="row mt-3">
           <div class="col-4">
               <label for="departuretime">Booked Departure Time</label>
               <input class="form-control" type="text" name="departuretime"
                   value="<?php echo htmlspecialchars($departuretime); ?>" placeholder="Enter Passenger's Booked Departure Time"/>
           </div>
       </div>
       <div class="row mt-3">
           <div class="col-4">
               <label for="ferry">Booked Ferry</label>
               <select class="form-select" name="ferry">
                   <?php
                   foreach ($ferries as $row) {
                       $selected = $row["id"] == $ferry ? "selected" : "";
                       echo "<option value=\"{$row['id']}\" $selected>";
                       echo "{$row['id']} - {$row['name']}";
                       echo "</option>";
                   }
                   ?>
               </select>
           </div>
       </div>
       <div class="row mt-3">
           <div class="col-4">
               <label for="room">Booked Room</label>
               <select class="form-select" name="room">
                   <?php
                   foreach ($rooms as $row) {
                       $selected = $row["id"] == $room ? "selected" : "";
                       echo "<option value=\"{$row['id']}\" $selected>";
                       echo "{$row['floor']} - {$row['name']}";
                       echo "</option>";
                   }
                   ?>
               </select>
           </div>
       </div>
       <input class="mt-3 btn btn-primary" type="submit" name="submit" value="Add Record"/>
       <a class="mt-3 btn btn-warning" href="listPassenger.php">Cancel</a>
   </form>
   <div class="mt-4">
       <ul class="error">
           <?php
           foreach ($errors as $err) {
               echo "<li>" . htmlspecialchars($err) . "</li>";
           }
           ?>
       </ul>
   </div>
</div>
