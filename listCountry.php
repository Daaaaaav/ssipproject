<!DOCTYPE html>
<html lang="en">
<?php include_once("header.php"); ?>
<body>
<?php
   require("data.php");
   include_once("nav.php");
   $db = new DBConnection();
   $countries = $db->getAllCountries();
?>
<div class="container mt-3">
   <table class="table table-sm table-bordered">
       <tr>
           <th>Name</th>
           <th>Continent</th>
           <th>Ports</th>
           <th>Edit</th>
           <th>Delete</th>
       </tr>
       <?php
       foreach ($countries as $row) {
       ?>
       <tr>
           <td><?= $row["name"] ?></td>
           <td><?= $row["continent"] ?></td>
           <td><?= $row["ports"] ?></td>
           <td>
               <a class="btn btn-warning" href="countryForm.php?id=<?= $row['id'] ?>">Edit</a>
           </td>
           <td>
               <a class="btn btn-danger" href="deleteCountry.php?id=<?= $row['id']?>">Delete</a>
           </td>
       </tr>
       <?php
       }
       ?>
   </table>
   <div>
       <a class="btn btn-success" href="countryForm.php">Add New Data</a>
   </div>
</div>
</body>
</html>