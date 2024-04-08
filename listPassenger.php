<!DOCTYPE html>
<html lang="en">
<?php include_once("header.php"); ?>
<body class="bg">
<?php
   require("data.php");
   include_once("nav.php");
   $db = new DBConnection();
   $passengers = $db->getAllPassengers();
?>
<div class="container mt-3">
   <table class="nautical-table table-sm table-bordered">
       <tr>
           <th>Name</th>
           <th>Booked Departure Time</th>
           <th>Booked Ferry</th>
           <th>Booked Room</th>
           <th>Edit</th>
           <th>Delete</th>
       </tr>
       <?php
       foreach ($passengers as $row) {
        $ferry = $db->getFerryById($row['ferry_id'])->fetch();
        $room = $db->getRoomById($row['room_id'])->fetch();
       ?>
       <tr>
           <td><?= $row["name"] ?></td>
           <td><?= $row["departuretime"] ?></td>
           <td><?= $ferry["name"] ?></td>
           <td><?= 'Level ' . $room["floor"] . ' - ' . ' Room ' . $room["name"] ?></td>
           <td>
               <a class="btn btn-edit" href="passengerForm.php?id=<?= $row['id'] ?>">Edit</a>
           </td>
           <td>
               <a class="btn btn-del" href="deletePassenger.php?id=<?= $row['id']?>">Delete</a>
           </td>
       </tr>
       <?php
       }
       ?>
   </table>
   <div>
       <a class="btn btn-add" href="passengerForm.php">Add New Data</a>
   </div>
</div>
</body>
</html>