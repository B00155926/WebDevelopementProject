CREATE DATABASE The_Candy_Shop;



-- Create the User table
CREATE TABLE User (
                      user_id INT PRIMARY KEY AUTO_INCREMENT,
                      password VARCHAR(255),
                      email VARCHAR(255) UNIQUE
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
                         description TEXT
);


CREATE TABLE Orders (
                        order_id INT PRIMARY KEY AUTO_INCREMENT,
                        customer_id INT,
                        employee_id INT,
                        order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (customer_id) REFERENCES Customer(customer_id),
                        FOREIGN KEY (employee_id) REFERENCES Employee(employee_id)
);


CREATE TABLE Admin_Product (
                               admin_id INT,
                               product_id INT,
                               FOREIGN KEY (admin_id) REFERENCES Admin(admin_id),
                               FOREIGN KEY (product_id) REFERENCES Product(product_id),
                               PRIMARY KEY (admin_id, product_id)
);
