<?php
/*
User Class (inheritance with customer and employee)
*/
?>
<?php
require_once 'Admin.php';
require_once 'Profile.php';
class User
{
    protected $userId;
    protected $firstname;
    protected $lastname;
    protected $address;
    protected $email;
    protected $telephone;
    protected $pdo;

    protected $username;
    private $passwordHash;
    private $role;

    public function __construct($userId, $username, $passwordHash, $role, $pdo)
    {
        $this->userId = $userId;
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
        $this->pdo = $pdo;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function authenticateUser($password)
    {
        try {
            $sql = "SELECT * FROM user WHERE username = ?";
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$this->username]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
