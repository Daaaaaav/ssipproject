<!DOCTYPE html>
<html lang="en">
<?php include_once("header.php"); ?>
<body class="bg">
<?php
   require("data.php");
   include_once("nav.php");
   $db = new DBConnection();
   $crew = $db->getAllCrewMembers();
?>
<div class="container mt-3">
   <table class="nautical-table table-sm table-bordered">
       <tr>
           <th>Member Name</th>
           <th>Position</th>
           <th>Salary</th>
           <th>Ferry Placement</th>
           <th>Room Placement</th>
           <th>Edit</th>
           <th>Delete</th>
       </tr>
       <?php
       foreach ($crew as $row) {
        $ferry = $db->getFerryById($row['ferry_id'])->fetch();
        $room = $db->getRoomById($row['room_id'])->fetch();
       ?>
       <tr>
           <td><?= $row["name"] ?></td>
           <td><?= $row["position"] ?></td>
           <td><?= $row["salary"] ?></td>
           <td><?= $ferry["name"] ?></td>
           <td><?= 'Level ' . $room["floor"] . ' - ' . ' Room ' . $room["name"] ?></td>
           <td>
               <a class="btn btn-edit" href="crewForm.php?id=<?= $row['id'] ?>">Edit</a>
           </td>
           <td>
               <a class="btn btn-del" href="deleteCrew.php?id=<?= $row['id']?>">Delete</a>
           </td>
       </tr>
       <?php
       }
       ?>
   </table>
   <div>
       <a class="btn btn-add" href="crewForm.php">Add New Data</a>
   </div>
</div>
</body>
</html>