<?php
require_once("header.php");
require_once("data.php");
$db = new DBConnection();
$errors = [];

$ferries = $db->getAllFerries()->fetchAll();
$rooms = $db->getAllRooms()->fetchAll();

$name = $position = $salary = $ferry = $room = '';
$crew = [];

// if there is an id in the URL, get data
if (isset($_GET["id"])) {
    $result = $db->getCrewMemberById($_GET["id"]);
    $name = $position = $salary = $ferry = $room = "";
    if ($result) {
        $crew = $result->fetch();
        $name = $crew["name"];
        $position = $crew["position"];
        $salary = $crew["salary"];
        $ferry = $crew["ferry_id"];
        $room = $crew["room_id"];
    }
}

if (isset($_POST["submit"])) {
    // Validate Crew Member data
    if (empty($_POST["name"])) {
        array_push($errors, "Name is required");
    } else {
        $name = $_POST["name"];
    }

    if (empty($_POST["position"])) {
        array_push($errors, "Position is required");
    } else {
        if (strlen($_POST["position"]) <= 3) {
            array_push($errors, "Position must be at least 4 characters");
        } else {
            $position = $_POST["position"];
        }
}
 
    if (empty($_POST["salary"])) {
        array_push($errors, "Salary is required");
    } else {
        $salary = (int)$_POST["salary"];
        if ($salary < 7) {
            array_push($errors, "Salary must be at least 7 dollars");
        }
    }

    // Assign selected ferry and room
    $ferry = $_POST["ferry"];
    $room = $_POST["room"];

    // Check if the selected room is already booked
    $isRoomBooked = $db->isRoomBooked($room);
    if ($isRoomBooked) {
        array_push($errors, "Selected room is already booked.");
    }

    if (count($errors) == 0) {
        if (isset($_GET["id"])) {
            $db->updateCrewMember($_GET["id"], $name, $position, $salary, $ferry, $room);
        } else {
            $db->addCrewMember($name, $position, $salary, $ferry, $room);
        }
        header("Location: listCrew.php");
        exit();
    }
}
?>

<div class="container mt-4">
   <form class="form" action="" method="post">
       <div class="row mt-3">
           <div class="col-4">
               <label for="name">Crew Member Name</label>
               <input class="form-control" type="text" name="name"
                   value="<?php echo($name); ?>" placeholder="Enter Name"/>
           </div>
       </div>
       <div class="row mt-3">
           <div class="col-4">
               <label for="position">Crew Member Position</label>
               <input class="form-control" type="text" name="position"
                   value="<?php echo($position); ?>" placeholder="Enter Position"/>
           </div>
       </div>
       <div class="row mt-3">
           <div class="col-4">
               <label for="salary">Crew Member's Salary</label>
               <input class="form-control" type="text" name="salary"
                   value="<?php echo($salary); ?>"placeholder="Enter Salary"/>
           </div>
       </div>
       <div class="row mt-3">
           <div class="col-4">
               <label for="ferry">Ferry Placement</label>
               <select class="form-select" name="ferry">
                   <?php
                       foreach ($ferries as $row) {
                           $selected = $row["id"] == $ferry ? "selected" : "";
                           echo("<option value=\"{$row['id']}\" {$selected}>");
                           echo("{$row['id']} - {$row['name']}");
                           echo("</option>");
                       }
                   ?>
               </select>
           </div>
       </div>
       <div class="row mt-3">
           <div class="col-4">
               <label for="room">Room Placement</label>
               <select class="form-select" name="room">
                   <?php
                       foreach ($rooms as $row) {
                           $selected = $row["id"] == $room ? "selected" : "";
                           echo("<option value=\"{$row['id']}\" {$selected}>");
                           echo("{$row['id']} - {$row['name']}");
                           echo("</option>");
                       }
                   ?>
               </select>
           </div>
       </div>
       <input class="mt-3 btn btn-add" type="submit" name="submit" value="Add Record"/>
       <a class="mt-3 btn btn-del" href="listCrew.php">Cancel</a>
   </form>
   <div class="mt-4">
       <ul class="error">
           <?php
           foreach ($errors as $err) {
               echo("<li>{$err}</li>");
           }
           ?>
       </ul>
   </div>
</div>
