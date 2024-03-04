CREATE DATABASE The_Candy_Shop;
 use The_Candy_Shop;

CREATE TABLE Customer (
                          Customer_ID INT PRIMARY KEY,
                          Name VARCHAR(50),
                          Address VARCHAR(100),
                          Email VARCHAR(50),
                          Phone_Number VARCHAR(15),
                          Password VARCHAR(50)
);

CREATE TABLE Product (
                         Product_ID INT PRIMARY KEY,
                         Name VARCHAR(100),
                         Description VARCHAR(255),
                         Price DECIMAL(10, 2),
                         Stock_Level INT
);

CREATE TABLE Order (
                       Order_ID INT PRIMARY KEY,
                       Customer_ID INT,
                       Order_Date DATE,
                       Total_Amount DECIMAL(10, 2),
                       FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
);

CREATE TABLE Order_Item (
                            Order_Item_ID INT PRIMARY KEY,
                            Order_ID INT,
                            Product_ID INT,
                            Quantity INT,
                            FOREIGN KEY (Order_ID) REFERENCES Order(Order_ID),
                            FOREIGN KEY (Product_ID) REFERENCES Product(Product_ID)
);

CREATE TABLE Admin (
                       Admin_ID INT PRIMARY KEY,
                       Name VARCHAR(50),
                       Email VARCHAR(50),
                       Password VARCHAR(50)
);

CREATE TABLE Employee (
                          Employee_ID INT PRIMARY KEY,
                          Name VARCHAR(50),
                          Email VARCHAR(50),
                          Password VARCHAR(50)
);

CREATE TABLE Contact_Form (
                              Contact_ID INT PRIMARY KEY,
                              Customer_ID INT,
                              Subject VARCHAR(100),
                              Message TEXT,
                              Date_Submitted DATE,
                              FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
);
