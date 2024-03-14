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
    public static function getProductData()
    {
        return array(
            array("Chocolate Bar", 2.00, "../Images/choc.jpg", 10),
            array("Gummy Bears", 5.00, "../Images/gumie.jpg", 20),
            array("Lollipop", 2.00, "../Images/loly.jpg", 15),
            array("Stick of Rock", 5.00, "../Images/rock.jpg", 8),
            array("Chewy Candy", 5.00, "../Images/boiledProd.jpg", 12)
        );
    }
    public static function getOccasionsData()
    {
        return array(
            array("Christening", "€50", "../Images/christening.jpg", 1),
            array("Birthday", "€60", "../Images/birthday.jpg", 2),
            array("First Communion", "€70", "../Images/communion.jpg", 3),
            array("Confirmation", "€80", "../Images/confirmation.jpg", 4),
            array("Wedding", "€90", "../Images/wedding.jpg", 5)
        );
    }
    public static function displayProduct($name, $price, $image, $quantity)
    {
        // Generate HTML code for displaying a product
        $html = "<div class='category'>";
        $html .= "<img src='$image' alt='$name'>";
        $html .= "<h3>$name</h3>";
        $html .= "<p>Price: €" . number_format($price, 2) . "</p>";
        $html .= "<p>Quantity: $quantity</p>";
        $html .= "<form action='cart.php' method='post'>";
        $html .= "<input type='hidden' name='product_name' value='$name'>";
        $html .= "<input type='hidden' name='product_price' value='$price'>";
        $html .= "<input type='hidden' name='product_quantity' value='$quantity'>";
        $html .= "<button type='submit'>Add to Cart</button>";
        $html .= "</form>";
        $html .= "</div>";

        return $html;
    }

}

// Instantiate the Product class

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
