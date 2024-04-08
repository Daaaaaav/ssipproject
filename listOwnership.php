<!DOCTYPE html>
<html lang="en">
<?php include_once("header.php"); ?>
<body class="bg">
<?php
   require("data.php");
   include_once("nav.php");
   $db = new DBConnection();
   $ownerships = $db->getAllOwnership();
?>
<div class="container mt-3">
   <table class="nautical-table table-sm table-bordered">
       <tr>
           <th>Company Name</th>
           <th>Ownership Net Worth (USD)</th>

           <th>Edit</th>
           <th>Delete</th>
       </tr>
       <?php
       foreach ($ownerships as $row) {
       ?>
       <tr>
           <td><?= $row["name"] ?></td>
           <td><?= $row["networth"] ?></td>
           <td>
               <a class="btn btn-edit" href="ownershipForm.php?id=<?= $row['id'] ?>">Edit</a>
           </td>
           <td>
               <a class="btn btn-del" href="deleteOwnership.php?id=<?= $row['id']?>">Delete</a>
           </td>
       </tr>
       <?php
       }
       ?>
   </table>
   <div>
       <a class="btn btn-add" href="ownershipForm.php">Add New Data</a>
   </div>
</div>
</body>
</html>