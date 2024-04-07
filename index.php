<!DOCTYPE html>
<html lang="en">
<?php include_once("header.php"); ?>
<body>
<?php include_once("nav.php"); ?>
<div class="container mt-3">
   <table class="table table-sm table-bordered">
       <tr>
           <th>Name</th>
           <th>Max Capacity</th>
           <th>Ticket Fee (USD)</th>
           <th>Transit Port</th>
           <th>Destination Port</th>
           <th>Company Ownership</th>
           <th>Country of Origin</th>
           <th>Edit</th>
           <th>Delete</th>
       </tr>
   <?php
   require("data.php");
   $db = new DBConnection();
   $ferries = $db->getAllFerries(); 
   foreach ($ferries as $row) {
    $ownership = $db->getAllOwnership($row['ownership_id'])->fetch();
    $country = $db->getAllCountries($row['country_id'])->fetch();
?>
<tr>
    <td><?= $row["name"]; ?></td>
    <td><?= $row["capacity"]; ?></td>
    <td><?= $row["ticketfee"]; ?></td>
    <td><?= $row["transit"]; ?></td>
    <td><?= $row["destination"]; ?></td>
    <td><?= $ownership["name"]; ?></td>
    <td><?= $country["name"]; ?></td>
    <td>
        <a class="btn btn-warning" href="ferryForm.php?id=<?= $row['id']; ?>">Edit</a>
    </td>
    <td>
        <a class="btn btn-danger" href="deleteFerry.php?id=<?= $row['id']; ?>">Delete</a>
    </td>
</tr>
<?php
}
?>
</table>
<div>
    <a class="btn btn-success" href="ferryForm.php">Add New Data</a>
</div>
</div>
</body>
</html>
