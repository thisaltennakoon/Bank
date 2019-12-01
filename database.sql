CREATE DATABASE Bank;
USE Bank;
CREATE TABLE Customer(
    Customer_ID int,
    Address VARCHAR(80),
    PRIMARY KEY(Customer_ID)
);
CREATE TABLE Email(
    Customer_ID int,
    Email VARCHAR(50),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) ON DELETE SET NULL
);
CREATE TABLE Customer_Contact_No(
    Customer_ID int,
    Contact_No VARCHAR(10),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) ON DELETE SET NULL
);
CREATE TABLE Customer_Login(
    Customer_ID int,
    Username VARCHAR(50),
    Password VARCHAR(30),
    Recovery_Contact_No VARCHAR(10),
    Recovery_Email VARCHAR(50),
    PRIMARY KEY(Username),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) ON DELETE SET NULL
);
CREATE TABLE Organization(
    Customer_ID int,
    Name VARCHAR(50),
    Bussiness_Registration_Number VARCHAR(20),
    PRIMARY KEY(Customer_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) ON DELETE SET NULL
);
CREATE TABLE Individual(
    Customer_ID int,
    First_Name VARCHAR(10),
    Last_Name VARCHAR(10),
    Middle_Name VARCHAR(10),
    NIC VARCHAR(10),
    DOB DATE,
    Gender VARCHAR(6),
    PRIMARY KEY(Customer_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) ON DELETE SET NULL
);
CREATE TABLE Branch(
    Branch_ID int,
    Branch_Name VARCHAR(20),
    Location VARCHAR(20),
    PRIMARY KEY(Branch_ID)
);
CREATE TABLE Employee(
    Employee_ID int,
    First_Name VARCHAR(10),
    Last_Name VARCHAR(10),
    Middle_Name VARCHAR(10),
    Address VARCHAR(80),
    NIC VARCHAR(10),
    DOB DATE,
    Gender VARCHAR(6),
    Branch_ID int,
    PRIMARY KEY(Employee_ID),
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) ON DELETE SET NULL
);
CREATE TABLE Employee_Contact_No(
    Employee_ID int,
    Contact_No VARCHAR(10),
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) ON DELETE SET NULL
);
CREATE TABLE Employee_Login(
    Employee_ID int,
    Username VARCHAR(50),
    Password VARCHAR(30),
    Recovery_Contact_No VARCHAR(10),
    Recovery_Email VARCHAR(50),
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) ON DELETE SET NULL
);

