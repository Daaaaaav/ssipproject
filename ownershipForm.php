<?php
/**
* Check submit button, take data and save to DB
*/
require_once("header.php");
require_once("data.php");
$db = new DBConnection();
$errors = [];

// Initialize variables
$name = $networth = "";

// if there is id in the URL, get data
if (isset($_GET["id"])) {
    $result = $db->getOwnershipById($_GET["id"]);
    if ($result) {
        $ownership = $result->fetch();
        $name = $ownership["name"];
        $networth = $ownership["networth"];
    }
}

// button is clicked
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $networth = $_POST["networth"];

    if (empty($name)) {
        array_push($errors, "Name is required");
    }
    if (!is_numeric($networth)) {
        array_push($errors, "Networth must be a number");
    } else {
        if (strlen($networth) <= 2) {
            array_push($errors, "Networth must be more than 2 characters");
        }
    }

    // check the $errors array, if count is zero, then proceed, else just show errors
    if (count($errors) == 0) {
        if (isset($_GET["id"])) {
            $db->updateOwnership($_GET["id"], $name, $networth);
        } else {
            $db->addOwnership($name, $networth);
        }
        header("Location: listOwnership.php");
        exit(); // Ensure script stops here to redirect
    }
}
?>
<div class="container mt-4">
    <form class="form" action="" method="post">
        <div class="row mt-3">
            <div class="col-4">
                <label for="name">Company Name</label>
                <input class="form-control" type="text" name="name"
                    value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter Company Name" />
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <label for="code">Ownership Net Worth</label>
                <input class="form-control" type="text" name="networth"
                    value="<?php echo htmlspecialchars($networth); ?>" placeholder="Enter Net Worth" />
            </div>
        </div>
        <input class="mt-3 btn btn-primary" type="submit" name="submit" value="Save Record" />
        <a class="mt-3 btn btn-warning" href="listOwnership.php">Cancel</a>
    </form>
    <?php if (count($errors) > 0) : ?>
        <div class="mt-4">
            <ul class="error">
                <?php foreach ($errors as $err) : ?>
                    <li><?php echo htmlspecialchars($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
