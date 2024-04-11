<?php
/**
 * Check submit button, take data and save to DB
 */
require_once("header.php");
require_once("data.php");
$db = new DBConnection();
$errors = [];

$ownerships = $db->getAllOwnership()->fetchAll();
$countries = $db->getAllCountries()->fetchAll();

$name = $capacity = $ticketfee = $transit = $destination = $ownership = $country = "";

// if there is id in the URL, get data
if (isset($_GET["id"])) {
    $result = $db->getFerryById($_GET["id"]);
    if ($result) {
        $ferry = $result->fetch();
        $name = $ferry["name"];
        $capacity = $ferry["capacity"];
        $ticketfee = $ferry["ticketfee"];
        $transit = $ferry["transit"];
        $destination = $ferry["destination"];
        $ownership = $ferry["ownership_id"];
        $country = $ferry["country_id"];
    }
}

if (isset($_POST["submit"])) {
    // check name first, set error if no value
    if (empty($_POST["name"])) {
        $errors[] = "Name is required";
    }

    if (empty($_POST["capacity"])) {
        $errors[] = "Capacity is required";
    } else {
        if (is_nan($_POST["capacity"])) {
            $errors[] = "Capacity must be a number";
        }
    }
    if (empty($_POST["ownership_id"])) {
        $errors[] = "Owner company is required";
    }
    if (empty($_POST["country_id"])) {
        $errors[] = "Country of origin is required";
    }
    $name = htmlspecialchars($_POST["name"]);
    $capacity = htmlspecialchars($_POST["capacity"]);
    $ticketfee = htmlspecialchars($_POST["ticketfee"]);
    $transit = htmlspecialchars($_POST["transit"]);
    $destination = htmlspecialchars($_POST["destination"]);
    $ownership = $_POST["ownership_id"];
    $country = $_POST["country_id"];

    if (count($errors) == 0) {
        if (isset($_GET["id"])) {
            $db->updateFerry($_GET["id"], $name, $capacity, $ticketfee, $transit, $destination, $ownership, $country);
        } else {
            $db->addFerry($name, $capacity, $ticketfee, $transit, $destination, $ownership, $country);
        }
        header("Location: index.php");
        exit(); 
    }
}
?>

<div class="container mt-4">
    <form class="form" action="" method="post">
        <div class="row mt-3">
            <div class="col-4">
                <label for="name">Ferry Name</label>
                <input class="form-control" type="text" name="name"
                    value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter Ferry Name"/>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <label for="capacity">Vessel Capacity</label>
                <input class="form-control" type="text" name="capacity"
                    value="<?php echo htmlspecialchars($capacity); ?>" placeholder="Enter Ferry's Capacity"/>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <label for="ticketfee">Ferry Ticket Fee</label>
                <input class="form-control" type="text" name="ticketfee"
                    value="<?php echo htmlspecialchars($ticketfee); ?>" placeholder="Enter Ferry Ticket Fee"/>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <label for="transit">Ferry Transit Port</label>
                <input class="form-control" type="text" name="transit"
                    value="<?php echo htmlspecialchars($transit); ?>" placeholder="Enter Ferry Transit"/>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <label for="destination">Ferry Port Destination</label>
                <input class="form-control" type="text" name="destination"
                    value="<?php echo htmlspecialchars($destination); ?>" placeholder="Enter Ferry Destination"/>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <label for="ownership">Ferry Ownership</label>
                <select class="form-select" name="ownership_id">
                    <?php
                    foreach ($ownerships as $row) {
                        $selected = ($row["id"] == $ownership) ? "selected" : "";
                        echo "<option value=\"{$row['id']}\" $selected>{$row['id']} - {$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <label for="country">Country of Origin</label>
                <select class="form-select" name="country_id">
                    <?php
                    foreach ($countries as $row) {
                        $selected = ($row["id"] == $country) ? "selected" : "";
                        echo "<option value=\"{$row['id']}\" $selected>{$row['id']} - {$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <input class="mt-3 btn btn-add" type="submit" name="submit" value="Add Record"/>
        <a class="mt-3 btn btn-del" href="index.php">Cancel</a>
    </form>
    <div class="mt-4">
        <ul class="error">
            <?php
            foreach ($errors as $err) {
                echo "<li>" . htmlspecialchars($err) . "</li>";
            }
            ?>
        </ul>
    </div>
</div>
