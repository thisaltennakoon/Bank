CREATE DATABASE Bank;
USE Bank;
CREATE TABLE Customer(
    Customer_ID INT,
    Address VARCHAR(80),
    PRIMARY KEY(Customer_ID)
);
CREATE TABLE Email(
    Customer_ID INT,
    Email VARCHAR(50),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) ON DELETE SET NULL
);
CREATE TABLE Customer_Contact_No(
    Customer_ID INT,
    Contact_No VARCHAR(10),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) ON DELETE SET NULL
);
CREATE TABLE Customer_Login(
    Customer_ID INT,
    Username VARCHAR(50),
    Password VARCHAR(30),
    Recovery_Contact_No VARCHAR(10),
    Recovery_Email VARCHAR(50),
    PRIMARY KEY(Username),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) ON DELETE SET NULL
);
CREATE TABLE Organization(
    Customer_ID INT,
    Name VARCHAR(50),
    Bussiness_Registration_Number VARCHAR(20),
    PRIMARY KEY(Customer_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) ON DELETE SET NULL
);
CREATE TABLE Individual(
    Customer_ID INT,
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
    Branch_ID INT,
    Branch_Name VARCHAR(20),
    Location VARCHAR(20),
    PRIMARY KEY(Branch_ID)
);
CREATE TABLE Employee(
    Employee_ID INT,
    First_Name VARCHAR(10),
    Last_Name VARCHAR(10),
    Middle_Name VARCHAR(10),
    Address VARCHAR(80),
    NIC VARCHAR(10),
    DOB DATE,
    Gender VARCHAR(6),
    Branch_ID INT,
    PRIMARY KEY(Employee_ID),
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) ON DELETE SET NULL
);
CREATE TABLE Employee_Contact_No(
    Employee_ID INT,
    Contact_No VARCHAR(10),
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) ON DELETE SET NULL
);
CREATE TABLE Employee_Login(
    Employee_ID INT,
    Username VARCHAR(50),
    Password VARCHAR(30),
    Recovery_Contact_No VARCHAR(10),
    Recovery_Email VARCHAR(50),
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) ON DELETE SET NULL
);
CREATE TABLE Account(
    Account_No INT,
    Currency VARCHAR(3),
    Balance FLOAT,
    Account_Status VARCHAR(10),
    Date_Created DATETIME,
    PRIMARY KEY(Account_No)
);
CREATE TABLE Account_Branch(
    Account_No INT,
    Branch_ID INT,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) ON DELETE SET NULL,
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) ON DELETE SET NULL
);
CREATE TABLE Customer_Account(
    Customer_ID INT,
    Account_No INT,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) ON DELETE SET NULL,
    FOREIGN KEY (Account_No) REFERENCES Accoun(Account_No) ON DELETE SET NULL
);
CREATE TABLE Current_Account(
    Account_No INT,
    FOREIGN KEY (Account_No) REFERENCES Accoun(Account_No) ON DELETE SET NULL,
    PRIMARY KEY(Account_No)
);
CREATE TABLE Savings_Account_Plan(
    Plan_ID INT,
    Account_Type VARCHAR(10),
    Minimum_Balance FLOAT,
    Interest FLOAT
    PRIMARY KEY (Plan_ID)
);
CREATE TABLE Savings_Account(
    Account_No INT,
    Number_of_Withdrawals INT,
    Account_Plan_ID INT,
    FOREIGN KEY (Account_Plan_ID) REFERENCES Savings_Account_Plan(Plan_ID) ON DELETE SET NULL,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) ON DELETE SET NULL,
    PRIMARY KEY(Account_No)
);
CREATE TABLE Child_Savings_Account(
    Account_No INT,
    First_Name VARCHAR(10),
    Last_Name VARCHAR(10),
    Middle_Name VARCHAR(10),
    DOB DATE,
    Gender VARCHAR(6),
    FOREIGN KEY (Account_No) REFERENCES Savings_Account(Account_No) ON DELETE SET NULL,
    PRIMARY KEY(Account_No)
);
CREATE TABLE Transaction_Details(
    Transaction_ID INT,
    Account_No INT,
    Amount FLOAT,
    Date_Time DATETIME,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) ON DELETE SET NULL,
    PRIMARY KEY(Transaction_ID)
);
CREATE TABLE Bank_Transaction(
    Transaction_ID INT,
    Type VARCHAR(8),
    FOREIGN KEY (Transaction_ID) REFERENCES Transaction_Details(Transaction_ID) ON DELETE SET NULL
);
CREATE TABLE ATM_Withdrawal(
    Transaction_ID INT,
    ATM_ID INT,
    Location VARCHAR(20),
    FOREIGN KEY (Transaction_ID) REFERENCES Transaction_Details(Transaction_ID) ON DELETE SET NULL
);
CREATE TABLE Online_Transaction(
    Transaction_ID INT,
    Recepient_ACC_No INT,
    FOREIGN KEY (Transaction_ID) REFERENCES Transaction_Details(Transaction_ID) ON DELETE SET NULL,
    FOREIGN KEY (Recepient_ACC_No) REFERENCES Account(Account_No) ON DELETE SET NULL
);