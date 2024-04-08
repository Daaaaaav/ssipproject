<?php
/**
* Check submit button, take data and save to DB
*/
require_once("header.php");
require_once("data.php");
$db = new DBConnection();
$errors = [];

$ferries = $db->getAllFerries()->fetchAll();

// Initialize variables
$name = $floor = $ferry = '';

// if there is id in the URL, get data
if (isset($_GET["id"])) {
   $result = $db->getRoomById($_GET["id"]);
   $name = $floor = "";
   if ($result) {
       $room = $result->fetch();
       $name = $room["name"];
       $floor = $room["floor"];
       $ferry = $room["ferry_id"];
   }
}
if (isset($_POST["submit"])) {
    // check name first, set error if no value
    if (empty($_POST["name"])) {
        array_push($errors, "Name is required");
    } else {
        $name = $_POST["name"];
    }
 
    if (empty($_POST["floor"])) {
        array_push($errors, "Floor is required");
    } else {
        if (is_nan($_POST["floor"])) {
            array_push($errors, "Floor must be a number");
        }
    }

    $ferry = $_POST["ferry"];
 
    if (count($errors) == 0) {
        if (isset($_GET["id"])) {
            $db->updateRoom($_GET["id"], $name, $floor, $ferry);
        } else {
            $db->addRoom($name, $floor, $ferry);
        }
        header("Location: listRoom.php");
        exit();
    }
 }
 ?>

<div class="container mt-4">
   <form class="form" action="" method="post">
       <div class="row mt-3">
           <div class="col-4">
               <label for="name">Room Number</label>
               <input class="form-control" type="text" name="name"
                   value="<?php echo($name); ?>" placeholder="Enter Room Number"/>
           </div>
       </div>
       <div class="row mt-3">
           <div class="col-4">
               <label for="capacity">Floor Location</label>
               <input class="form-control" type="text" name="floor"
                   value="<?php echo($floor); ?>" placeholder="Enter Floor of the Room"/>
           </div>
       </div>
       <div class="row mt-3">
           <div class="col-4">
               <label for="ferry">Vessel of the Room</label>
               <select class="form-select" name="ferry">
                   <?php
                       foreach ($ferries as $row) {
                           $selected = ($row["id"] == $room["ferry_id"]) ? "selected" : "";
                           echo("<option value=\"{$row['id']}\" {$selected}>");    
                           echo("{$row['id']} - {$row['name']}");
                           echo("</option>");
                       }
                   ?>
               </select>
           </div>
       </div>
       <input class="mt-3 btn btn-primary" type="submit" name="submit" value="Add Record"/>
       <a class="mt-3 btn btn-warning" href="listRoom.php">Cancel</a>
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
