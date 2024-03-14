<?php
/*
Profile Class (aggregation with customer)
*/
?>

<?php
class Profile {
    protected $profileId;
    protected $customerId;
    protected $fullName;
    protected $address;
    protected $pdo;
    protected $customer; // Aggregation
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getProfileId() {
        return $this->profileId;
    }

    public function setProfileId($profileId) {
        $this->profileId = $profileId;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId) {
        $this->customerId = $customerId;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    // Retrieve profile by customer ID
    public function getProfileByCustomerId($customerId) {
        try {
            $sql = "SELECT * FROM Profile WHERE customer_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$customerId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching profile: " . $e->getMessage();
            return false;
        }
    }

    // Update profile
    public function updateProfile($customerId, $fullName, $address) {
        try {
            // Check if profile exists
            $existingProfile = $this->getProfileByCustomerId($customerId);
            if (!$existingProfile) {
                // If profile doesn't exist, create a new one
                $sql = "INSERT INTO Profile (customer_id, full_name, address) VALUES (?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$customerId, $fullName, $address]);
            } else {
                // If profile exists, update it
                $sql = "UPDATE Profile SET full_name = ?, address = ? WHERE customer_id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$fullName, $address, $customerId]);
            }

            return true;
        } catch (PDOException $e) {
            echo "Error updating profile: " . $e->getMessage();
            return false;
        }
    }
}
?>
