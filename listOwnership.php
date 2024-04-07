<!DOCTYPE html>
<html lang="en">
<?php include_once("header.php"); ?>
<body>
<?php
   require("data.php");
   include_once("nav.php");
   $db = new DBConnection();
   $ownerships = $db->getAllOwnership();
?>
<div class="container mt-3">
   <table class="table table-sm table-bordered">
       <tr>
           <th>Company Name</th>
           <th>Ownership Net Worth (USD)</th>

           <th>Edit</th>
           <th>Delete</th>
       </tr>
       <?php
       // loop all majors and show in table
       foreach ($ownerships as $row) {
       ?>
       <tr>
           <td><?= $row["name"] ?></td>
           <td><?= $row["networth"] ?></td>
           <td>
               <a class="btn btn-warning" href="ownershipForm.php?id=<?= $row['id'] ?>">Edit</a>
           </td>
           <td>
               <a class="btn btn-danger" href="deleteOwnership.php?id=<?= $row['id']?>">Delete</a>
           </td>
       </tr>
       <?php
       }
       ?>
   </table>
   <div>
       <a class="btn btn-success" href="ownershipForm.php">Add New Data</a>
   </div>
</div>
</body>
</html>