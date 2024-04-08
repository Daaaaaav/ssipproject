<!DOCTYPE html>
<html lang="en">
<?php include_once("header.php"); ?>
<body class="bg">
<?php
   require("data.php");
   include_once("nav.php");
   $db = new DBConnection();
   $rooms = $db->getAllRooms();
?>
<div class="container mt-3">
   <table class="nautical-table table-sm table-bordered">
       <tr>
           <th>Room Number</th>
           <th>Floor</th>
           <th>Ferry</th>
           <th>Edit</th>
           <th>Delete</th>
       </tr>
       <?php
       foreach ($rooms as $row) {
        $ferry = $db->getFerryById($row['ferry_id'])->fetch();
       ?>
       <tr>
           <td><?= $row["name"] ?></td>
           <td><?= $row["floor"] ?></td>
           <td><?= $ferry["name"] ?></td>
           <td>
               <a class="btn btn-edit" href="roomForm.php?id=<?= $row['id'] ?>">Edit</a>
           </td>
           <td>
               <a class="btn btn-del" href="deleteRoom.php?id=<?= $row['id']?>">Delete</a>
           </td>
       </tr>
       <?php
       }
       ?>
   </table>
   <div>
       <a class="btn btn-add" href="roomForm.php">Add New Data</a>
   </div>
</div>
</body>
</html>