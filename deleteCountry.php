<?php
require_once("header.php");
require_once("data.php");
$db = new DBConnection();
if (isset($_POST["submit"]) and isset($_GET["id"])) {
   $db->deleteCountry($_GET["id"]);
   header("Location: listCountry.php");
}
?>
<div class="container">
   <form action="" method="post">
       Are you sure you want to delete this data?<br/>
       <input class="mt-3 btn btn-del" type="submit" name="submit" value="Confirm"/>
       <a class="mt-3 btn btn-edit" href="listCountry.php">Cancel</a>
   </form>
</div>