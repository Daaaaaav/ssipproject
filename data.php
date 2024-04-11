<?php
class DBConnection {
   private $conn;

   public function __construct() {
      $this->conn = new PDO(
          "mysql:host=localhost;dbname=ssipproject",
          "root", ""
      );
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  
   public function __destruct() {
       $this->conn = null;
   }

   public function isRoomBooked($room_id) {
      try {
          $stmt = $this->conn->prepare("SELECT COUNT(*) FROM passenger WHERE room_id = ? UNION ALL SELECT COUNT(*) FROM crew WHERE room_id = ?");
          $stmt->execute([$room_id, $room_id]);
          $counts = $stmt->fetchAll(PDO::FETCH_COLUMN);
          foreach ($counts as $count) {
              if ($count > 0) {
                  return true;
              }
          }
          return false;
      } catch (PDOException $e) {
          die("Error: " . $e->getMessage());
      }
  }
  
  

   public function getAllFerries() {
    $sql = "SELECT id, name, capacity, ticketfee, transit, destination, ownership_id, country_id FROM ferry";
    $result = $this->conn->prepare($sql);
    $result->execute();
    return $result;
 }
 
 public function getFerryById($id) {
    $sql = "SELECT id, name, capacity, ticketfee, transit, destination, ownership_id, country_id FROM ferry WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
    return $result;
 }
 
 public function addFerry($name, $capacity, $ticketfee, $transit, $destination, $ownership_id, $country_id) {
   $sql = "INSERT INTO ferry (name, capacity, ticketfee, transit, destination, ownership_id, country_id)
   VALUES (?, ?, ?, ?, ?, ?, ?)";
   $result = $this->conn->prepare($sql);
   $result->execute([$name, $capacity, $ticketfee, $transit, $destination, $ownership_id, $country_id]);
}

 public function updateFerry($id, $name, $capacity, $ticketfee, $transit, $destination, $ownership_id, $country_id) {
    $sql = "UPDATE ferry SET name = ?, capacity = ?, ticketfee = ?, transit = ?, destination = ?, ownership_id = ?, country_id = ? WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$name, $capacity, $ticketfee, $transit, $destination, $ownership_id, $country_id, $id]);
 }
 
 public function deleteFerry($id) {
   $this->deleteRoomByFerryId($id);
   $this->deletePassengerByFerryId($id);
   $this->deleteCrewMemberByFerryId($id);
    $sql = "DELETE FROM ferry WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
 }

 public function deleteFerryByOwnershipId($ownership_id) {
   $sql = "DELETE FROM ferry WHERE ownership_id = ?";
   $result = $this->conn->prepare($sql);
   $result->execute([$ownership_id]);
}

public function deleteFerryByCountryId($country_id) {
   $sql = "DELETE FROM ferry WHERE country_id = ?";
   $result = $this->conn->prepare($sql);
   $result->execute([$country_id]);
}


 public function getAllRooms() {
    $sql = "SELECT id, name, floor, ferry_id FROM room";
    $result = $this->conn->prepare($sql);
    $result->execute();
    return $result;
 }
 
 public function getRoomById($id) {
    $sql = "SELECT id, name, floor, ferry_id FROM room WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
    return $result;
 }
 
 public function addRoom($name, $floor, $ferry_id) {
    $sql = "INSERT INTO room (name, floor, ferry_id) VALUES (?, ?, ?)";
    $result = $this->conn->prepare($sql);
    $result->execute([$name, $floor, $ferry_id]);
 }

 public function updateRoom($id, $name, $floor, $ferry_id) {
    $sql = "UPDATE room SET name = ?, floor = ?, ferry_id = ? WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$name, $floor, $ferry_id, $id]);
}

public function deleteRoom($id) {
   $this->deletePassengerByRoomId($id);
   $this->deleteCrewMemberByRoomId($id);
    $sql = "DELETE FROM room WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
}

public function deleteRoomByFerryId($ferry_id) {
   $this->deletePassengerByFerryId($ferry_id);
   $this->deleteCrewMemberByFerryId($ferry_id);
   $sql = "DELETE FROM room WHERE ferry_id = ?";
   $result = $this->conn->prepare($sql);
   $result->execute([$ferry_id]);
}

 public function getAllPassengers() {
    $sql = "SELECT id, name, departuretime, ferry_id, room_id FROM passenger";
    $result = $this->conn->prepare($sql);
    $result->execute();
    return $result;
 }
 
 public function getPassengerById($id) {
    $sql = "SELECT id, name, departuretime, ferry_id, room_id FROM passenger WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
    return $result;
 }
 
 public function addPassenger($name, $departuretime, $ferry_id, $room_id) {
    $sql = "INSERT INTO passenger (name, departuretime, ferry_id, room_id) VALUES (?, ?, ?, ?)";
    $result = $this->conn->prepare($sql);
    $result->execute([$name, $departuretime, $ferry_id, $room_id]);
 }

 public function updatePassenger($id, $name, $departuretime, $ferry_id, $room_id) {
    $sql = "UPDATE passenger SET name = ?, departuretime = ?, ferry_id = ?, room_id = ? WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$name, $departuretime, $ferry_id, $room_id, $id]);
}

public function deletePassenger($id) {
    $sql = "DELETE FROM passenger WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
}

public function deletePassengerByFerryId($ferry_id) {
   $sql = "DELETE FROM passenger WHERE ferry_id = ?";
   $result = $this->conn->prepare($sql);
   $result->execute([$ferry_id]);
}

public function deletePassengerByRoomId($room_id) {
   $sql = "DELETE FROM passenger WHERE room_id = ?";
   $result = $this->conn->prepare($sql);
   $result->execute([$room_id]);
}

public function getAllCrewMembers() {
   $sql = "SELECT id, name, position, salary, ferry_id, room_id FROM crew";
   $result = $this->conn->prepare($sql);
   $result->execute();
   return $result;
}
public function getCrewMemberById($id) {
   $sql = "SELECT id, name, position, salary, ferry_id, room_id FROM crew WHERE id = ?";
   $result = $this->conn->prepare($sql);
   $result->execute([$id]);
   return $result;
}

public function addCrewMember($name, $position, $salary, $ferry_id, $room_id) {
   $sql = "INSERT INTO crew (name, position, salary, ferry_id, room_id) VALUES (?, ?, ?, ?, ?)";
   $result = $this->conn->prepare($sql);
   $result->execute([$name, $position, $salary, $ferry_id, $room_id]);
}

public function updateCrewMember($id, $name, $position, $salary, $ferry_id, $room_id) {
   $sql = "UPDATE crew SET name = ?, position = ?, salary = ?, ferry_id = ?, room_id = ? WHERE id = ?";
   $result = $this->conn->prepare($sql);
   $result->execute([$name, $position, $salary, $ferry_id, $room_id, $id]);
}

public function deleteCrewMember($id) {
   $sql = "DELETE FROM crew WHERE id = ?";
   $result = $this->conn->prepare($sql);
   $result->execute([$id]);
}

public function deleteCrewMemberByFerryId($ferry_id) {
  $sql = "DELETE FROM crew WHERE ferry_id = ?";
  $result = $this->conn->prepare($sql);
  $result->execute([$ferry_id]);
}

public function deleteCrewMemberByRoomId($room_id) {
  $sql = "DELETE FROM crew WHERE room_id = ?";
  $result = $this->conn->prepare($sql);
  $result->execute([$room_id]);
}

public function getAllCountries() {
    $sql = "SELECT id, name, continent, ports FROM country";
    $result = $this->conn->prepare($sql);
    $result->execute();
    return $result;
 }
 
 public function getCountryById($id) {
    $sql = "SELECT id, name, continent, ports FROM country WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
    return $result;
 }
 
 public function addCountry($name, $continent, $ports) {
    $sql = "INSERT INTO country (name, continent, ports) VALUES (?, ?, ?)";
    $result = $this->conn->prepare($sql);
    $result->execute([$name, $continent, $ports]);
 }

 public function updateCountry($id, $name, $continent, $ports) {
    $sql = "UPDATE country SET name = ?, continent = ?, ports = ? WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$name, $continent, $ports, $id]);
}

public function deleteCountry($id) {
   $this->deleteFerryByCountryId($id);
    $sql = "DELETE FROM country WHERE id = ?";
    $result = $this->conn->prepare($sql);
    $result->execute([$id]);
}

public function getAllOwnership() {
   $sql = "SELECT id, name, networth FROM ownership";
   $result = $this->conn->prepare($sql);
   $result->execute();
   return $result;
}

public function getOwnershipById($id) {
   $sql = "SELECT id, name, networth FROM ownership WHERE id = ?";
   $result = $this->conn->prepare($sql);
   $result->execute([$id]);
   return $result;
}

public function addOwnership($name, $networth) {
   $sql = "INSERT INTO ownership (name, networth) VALUES (?, ?)";
   $result = $this->conn->prepare($sql);
   $result->execute([$name, $networth]);
}

public function updateOwnership($id, $name, $networth) {
   $sql = "UPDATE ownership SET name = ?, networth = ? WHERE id = ?";
   $result = $this->conn->prepare($sql);
   $result->execute([$name, $networth, $id]);
}

public function deleteOwnership($id) {
   $this->deleteFerryByOwnershipId($id);
   $sql = "DELETE FROM ownership WHERE id = ?";
   $result = $this->conn->prepare($sql);
   $result->execute([$id]);
}
}
