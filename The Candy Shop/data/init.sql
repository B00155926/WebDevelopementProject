

use the_candy_shop;


CREATE TABLE User (
                       user_id INT AUTO_INCREMENT PRIMARY KEY,
                       firstname VARCHAR(255),
                       lastname VARCHAR(255),
                       address VARCHAR(255),
                       email VARCHAR(255),
                       telephone VARCHAR(20),
                       role VARCHAR(20),
                       username VARCHAR(255),
                       password VARCHAR(255)

);



CREATE TABLE Customer (
                          customer_id INT PRIMARY KEY AUTO_INCREMENT,
                          user_id INT UNIQUE,
                          FOREIGN KEY (user_id) REFERENCES User(user_id)
);




CREATE TABLE Profile (
                         profile_id INT PRIMARY KEY AUTO_INCREMENT,
                         customer_id INT UNIQUE,
                         full_name VARCHAR(255),
                         address VARCHAR(255),
                         FOREIGN KEY (customer_id) REFERENCES Customer(customer_id)
);


CREATE TABLE Employee (
                          employee_id INT PRIMARY KEY AUTO_INCREMENT,
                          user_id INT UNIQUE,
                          FOREIGN KEY (user_id) REFERENCES User(user_id)
);


CREATE TABLE Admin (
                       admin_id INT PRIMARY KEY AUTO_INCREMENT,
                       user_id INT UNIQUE,
                       FOREIGN KEY (user_id) REFERENCES User(user_id)
);


CREATE TABLE Product (
                         product_id INT PRIMARY KEY AUTO_INCREMENT,
                         name VARCHAR(255),
                         price DECIMAL(10, 2),
                         description VARCHAR(255),
                         quantity INT,
                         total DECIMAL(10, 2)

);


CREATE TABLE Orders (
                        order_id INT PRIMARY KEY AUTO_INCREMENT,
                        customer_id INT,
                        employee_id INT,
                        order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (customer_id) REFERENCES Customer(customer_id),
                        FOREIGN KEY (employee_id) REFERENCES Employee(employee_id)
);


CREATE TABLE admin_product (
                               admin_id INT,
                               product_id INT,
                               product_name VARCHAR(255),
                               quantity INT,
                               FOREIGN KEY (admin_id) REFERENCES admin(admin_id),
                               FOREIGN KEY (product_id) REFERENCES product(product_id),
                               PRIMARY KEY (admin_id, product_id)
);

CREATE TABLE inventory_pages (
                                 page_id INT AUTO_INCREMENT PRIMARY KEY,
                                 content TEXT
);
