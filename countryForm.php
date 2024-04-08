<?php
/**
 * Check submit button, take data and save to DB
 */
require_once("header.php");
require_once("data.php");
$db = new DBConnection();
$errors = [];
$name = $continent = $ports = ""; // Initialize variables

// if there is id in the URL, get data
if (isset($_GET["id"])) {
    $result = $db->getCountryById($_GET["id"]);
    if ($result) {
        $country = $result->fetch();
        $name = $country["name"];
        $continent = $country["continent"];
        $ports = $country["ports"];
    }
}

// button is clicked
if (isset($_POST["submit"])) {
    if (empty($_POST["name"])) {
        array_push($errors, "Name is required");
    }
    if (empty($_POST["ports"])) {
        array_push($errors, "Port is required");
    } else {
        $ports = (int)$_POST["ports"];
        if ($ports < 1) {
            array_push($errors, "There must be at least one port");
        }
    }

    $name = $_POST["name"];
    $continent = $_POST["continent"];

    if (count($errors) == 0) {
        if (isset($_GET["id"])) {
            $db->updateCountry($_GET["id"], $name, $continent, $ports);
        } else {
            $db->addCountry($name, $continent, $ports);
        }
        header("Location: listCountry.php");
        exit(); 
    }
}
?>
<div class="container mt-4">
    <form class="form" action="" method="post">
        <div class="row mt-3">
            <div class="col-4">
                <label for="name">Country Name</label>
                <input id="name" class="form-control" type="text" name="name"
                    value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter Country Name"/>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <label for="continent">Continent of Country</label>
                <input id="continent" class="form-control" type="text" name="continent"
                    value="<?php echo htmlspecialchars($continent); ?>" placeholder="Enter Continent"/>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <label for="ports">Number of Ports in Country</label>
                <input id="ports" class="form-control" type="text" name="ports"
                    value="<?php echo htmlspecialchars($ports); ?>" placeholder="Enter Number of Ports"/>
            </div>
        </div>
        <input class="mt-3 btn btn-add" type="submit" name="submit" value="Save Record"/>
        <a class="mt-3 btn btn-del" href="listCountry.php">Cancel</a>
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
