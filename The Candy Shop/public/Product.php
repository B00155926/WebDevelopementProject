<?php
/*
Product class
*/
?>
<?php
require "../src/config.php";
require "../src/DBconnect.php";

class Product
{
    private $pdo; // Database connection
    private $productId;
    private $name;
    private $price;
    private $description;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;

    }

    // Getter and setter methods

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    //method to search for products
    public function searchProducts($searchQuery)
    {
        try {
            // Prepare the SQL statement to search for products
            $sql = "SELECT * FROM Product WHERE name LIKE :search OR description LIKE :search";
            $stmt = $this->pdo->prepare($sql);

            // Bind the search query to the parameter
            $searchParam = "%{$searchQuery}%"; //wildcard
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);

            // Execute the query
            $stmt->execute();

            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle any errors
            echo "Error searching products: " . $e->getMessage();
            return array(); // Return an empty array on error
        }
    }
 // Method to update the quantity of a product
    public function addToCart($productName, $quantity)
    {
        try {
            $sql = "INSERT INTO Orders (order_date, product_name, quantity) VALUES (CURRENT_TIMESTAMP, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productName, $quantity]);
            return true; // Return true on success
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Return false on error
        }
    }

    // Database interaction methods

    public function saveToDatabase()
    {
        try {
            $sql = "INSERT INTO product (name, price, description) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$this->name, $this->price, $this->description]);
            return true; // Return true on success
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Return false on error
        }
    }

    public function fetchProducts()
    {
        try {
            $sql = "SELECT * FROM product";
            $stmt = $this->pdo->query($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return array(); // Return an empty array on error
        }
    }
}
// Instantiate the Product class if needed

$product1 = new Product($pdo);
$product1->setName("Chocolate Bar");
$product1->setPrice(2.00);
$product1->setDescription("Chocolate Bar");

$product2 = new Product($pdo);
$product2->setName("Gummy Bears");
$product2->setPrice(5.00);
$product2->setDescription("Tasty gummy bears €5/100gr");

$product3 = new Product($pdo);
$product3->setName("Lollipop");
$product3->setPrice(2.00);
$product3->setDescription("Colorful lollipops €2/each");

$product4 = new Product($pdo);
$product4->setName("Stick of Rock");
$product4->setPrice(5.00);
$product4->setDescription("Traditional candy cane €5/each");

$product5 = new Product($pdo);
$product5->setName("Chewy Candy");
$product5->setPrice(5.00);
$product5->setDescription("Chewy candy treats €5/100gr");

?>
