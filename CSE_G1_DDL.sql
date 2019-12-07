DROP DATABASE Bank;
CREATE DATABASE Bank;
USE Bank;
CREATE TABLE Customer(
    Customer_ID INT UNSIGNED AUTO_INCREMENT,    
    Address_Line_1 VARCHAR(20),
    Address_Line_2 VARCHAR(20),
    Address_Line_3 VARCHAR(20),
    Primary_Email VARCHAR(50),
    Primary_Contact_No VARCHAR(10), 
    PRIMARY KEY(Customer_ID)
);
CREATE TABLE Customer_Email(    /*Table for {Email} multi valued attribute*/ /**/
    Customer_ID INT NOT NULL,
    Email VARCHAR(50) NOT NULL,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) 
);
CREATE TABLE Customer_Contact_No(   /*Table for {Contact_No} multi valued attribute*/ 
    Customer_ID INT NOT NULL,
    Contact_No VARCHAR(10) NOT NULL,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) 
);
CREATE TABLE Individual(
    Customer_ID INT,
    First_Name VARCHAR(10),
    Last_Name VARCHAR(10),
    Middle_Name VARCHAR(10),
    NIC VARCHAR(10) NOT NULL,
    DOB DATE,
    Gender VARCHAR(6),
    PRIMARY KEY(Customer_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) 
);
CREATE TABLE Organization(
    Customer_ID INT,
    Name VARCHAR(50) NOT NULL,
    Registration_Number VARCHAR(20), /*Registration_Number attribute added because every NGO,company has a registration number*/
    PRIMARY KEY(Customer_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) 
);
CREATE TABLE Organization_Individual(
    Organization_ID INT,
    Individual_ID INT,
    FOREIGN KEY (Organization_ID) REFERENCES Organization(Customer_ID),
    FOREIGN KEY (Individual_ID) REFERENCES Individual(Customer_ID)
);/*This is not in the ERD.This table has been added because when creating a organization, people who are responsible for banking
 should be added.So, relationship between organization and individual is one to many*/
CREATE TABLE Customer_Login(
    Customer_ID INT,
    Username VARCHAR(50),
    Password VARCHAR(100) NOT NULL,
    Recovery_Contact_No VARCHAR(10) NOT NULL,
    Recovery_Email VARCHAR(50) NOT NULL,
    PRIMARY KEY(Username),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) 
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
    NIC VARCHAR(10) NOT NULL,
    DOB DATE,
    Gender VARCHAR(6),
    Primary_Contact_No VARCHAR(10) NOT NULL,
    Branch_ID INT,
    PRIMARY KEY(Employee_ID),
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) 
);
CREATE TABLE Employee_Contact_No(    /*table for {Contact_No} multi valued attribute*/
    Employee_ID INT NOT NULL,
    Contact_No VARCHAR(10) NOT NULL,
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) 
);
CREATE TABLE Employee_Login(
    Employee_ID INT,
    Username VARCHAR(50),
    Password VARCHAR(100),
    Recovery_Contact_No VARCHAR(10),
    Recovery_Email VARCHAR(50),
    PRIMARY KEY(Username),
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) 
);
CREATE TABLE Manager(
    Employee_ID INT,
    PRIMARY KEY(Employee_ID),
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) 
);
CREATE TABLE Clerk(
    Employee_ID INT,
    PRIMARY KEY(Employee_ID),
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) 
);
CREATE TABLE Account(/*Account_Detail Table in the ERD has renamed as Account*/
    Account_No INT,
    Currency VARCHAR(3) NOT NULL,
    Balance FLOAT,
    Primary_Customer_ID INT,/*account has a Customer_ID.But there can be many customers for one account.ex:-Joint accounts.Although this attribute makes redundence data in most cases, one account has one customer who the account is created*/
    Primary_Branch_ID INT, /*account has a branch. but customer can add many branches.This attribute makes redundence data.but in most cases, customers tend to use the branch where the account is created*/
    Account_Status VARCHAR(10),         /**/
    Date_Created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Primary_Branch_ID) REFERENCES Branch(Branch_ID) ,
    FOREIGN KEY (Primary_Customer_ID) REFERENCES Customer(Customer_ID) ,
    PRIMARY KEY(Account_No)
);/*only havings Account_Branch,Account_Customer tables, redundency can be reduced but we used Primary_Customer_ID,Primary_Branch_ID attributes 
in the Account table can increse the performance.*/
CREATE TABLE Account_Branch(/*customer can add many branches to a single account apart from the account creating branch and one brach can have many accounts*/
    Account_No INT NOT NULL,
    Branch_ID INT NOT NULL,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) ,
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) 
);
CREATE TABLE Account_Customer(/*one customer can have many accounts and one account can belongs to many customers(ex:joint accounts)*/
    Customer_ID INT NOT NULL,
    Account_No INT NOT NULL,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) ,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) 
);
CREATE TABLE Checking_Account(   /*--'Checking account' is the term given in the discription not 'current account'*/
    Account_No INT,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) ,
    PRIMARY KEY(Account_No)
);
CREATE TABLE Checkbook(
    Checkbook_Number INT UNSIGNED AUTO_INCREMENT,
    Account_No INT NOT NULL,
    Issued_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Number_of_Pages INT NOT NULL,
    Starting_Check_Number INT NOT NULL,
    FOREIGN KEY (Account_No) REFERENCES Checking_Account(Account_No) ,
    PRIMARY KEY(Checkbook_Number)
);/*This is not in the ERD and added afterwards.Since bank has checking accounts, check books have to be issued.
This table can record all the check book details*/
CREATE TABLE Savings_Account_Plan(
    Plan_ID INT,
    Account_Plan VARCHAR(10),
    Minimum_Balance FLOAT,
    Interest FLOAT,
    PRIMARY KEY (Plan_ID)
);
CREATE TABLE Savings_Account(
    Account_No INT,
    Number_of_Withdrawals INT CHECK (Number_of_Withdrawals <= 5),
    Account_Plan_ID INT,
    FOREIGN KEY (Account_Plan_ID) REFERENCES Savings_Account_Plan(Plan_ID) ,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) ,
    PRIMARY KEY(Account_No)
);
CREATE TABLE Child_Savings_Account(
    Account_No INT,
    First_Name VARCHAR(10),
    Last_Name VARCHAR(10),
    Middle_Name VARCHAR(10),
    DOB DATE,
    Gender VARCHAR(6),
    FOREIGN KEY (Account_No) REFERENCES Savings_Account(Account_No) ,
    PRIMARY KEY(Account_No)
);/*We have slightly changed the implementation of Child_Savings_Account which is in the ERD. In this system, we plan to make Child Savings Account using 
parents details. Actually, a Child_Savings_Account is originally a Savings_Account of his/her parent associated with child details.*/
CREATE TABLE Transaction_Detail(
    Transaction_ID INT,
    Account_No INT NOT NULL,
    Amount FLOAT NOT NULL,
    Date_Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) ,
    PRIMARY KEY(Transaction_ID)
);
CREATE TABLE Bank_Transaction(
    Transaction_ID INT,
    Withdraw BOOLEAN,/*withdraw-True,deposit-False*/
    FOREIGN KEY (Transaction_ID) REFERENCES Transaction_Details(Transaction_ID) 
);
CREATE TABLE ATM_Withdrawal(
    Transaction_ID INT,
    ATM_ID INT,
    FOREIGN KEY (Transaction_ID) REFERENCES Transaction_Details(Transaction_ID) 
);
CREATE TABLE Online_Transaction(
    Online_Transaction_ID INT,
    Sender_ACC_No INT,
    Recepient_ACC_No INT,
    Sender_Transaction_ID INT,
    FOREIGN KEY (Recepient_ACC_No) REFERENCES Account(Account_No) ,
    FOREIGN KEY (Sender_ACC_No) REFERENCES Account(Account_No) ,
    PRIMARY KEY(Online_Transaction_ID)
);
CREATE TABLE Loan_Type(
    Type_ID INT,         
    Type_Nmae VARCHAR(15),
    Interest_Rate FLOAT NOT NULL,
    PRIMARY KEY (Type_ID)
);
CREATE TABLE Requested_Loan( 
    Request_ID INT UNSIGNED AUTO_INCREMENT,          
    Account_No INT NOT NULL,
    Loan_Type INT NOT NULL,
    Amount FLOAT NOT NULL,
    Branch_ID INT,
    Time_Period INT NOT NULL,
    Installment FLOAT NOT NULL,
    Requested_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Requested_By INT,
    Request_Status VARCHAR(10),
    FOREIGN KEY (Requested_By) REFERENCES Clerk(Employee_ID) ,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) ,
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) ,
    FOREIGN KEY (Loan_Type) REFERENCES Loan_Type(Type_ID) ,
    PRIMARY KEY (Request_ID)
);
/*This table is not in the ERD. This table is added because to increase the performance of the application.
So, if a bank clerk submits a loan request to the bank manager,there can be many situations where the bank manager rejects the request due to various reasons. 
Moreover, there can be situations like manager change the Loan amount, Time period, Installment and approve the loan.
Therefore, two different tables like Requested_Loan and Loan is needed. So, all the requested loans are added to this table and if the bank manager 
accept a loan then it is added to the Loan table below.*/
CREATE TABLE Loan( 
    Loan_ID INT,     
    Account_No INT,      
    Loan_Type INT,
    Amount FLOAT,
    Branch_ID INT,
    Time_Period INT,
    Installment FLOAT,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) ,
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) ,
    FOREIGN KEY (Loan_Type) REFERENCES Loan_Type(Type_ID) ,
    PRIMARY KEY (Loan_ID)
);/*Loans in the loan table are used widely in a banking system to know details about loans.
But Loan details in the Requested_Loan table are only used by the maneger toapprove loans.
So, the seperation of Requested_Loan and Loan table would increse the dynamic performance of the system.*/
CREATE TABLE Fixed_Deposit_Plan(
    Plan_ID INT,
    Time_Period VARCHAR(10) NOT NULL,
    Interest FLOAT NOT NULL,
    PRIMARY KEY (Plan_ID)
);
CREATE TABLE Fixed_Deposit(
    FD_No INT,
    Customer_ID INT NOT NULL,
    Account_No INT NOT NULL, 
    Amount FLOAT NOT NULL,
    Date_Opened TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Plan_ID INT NOT NULL,
    Transaction_ID INT,
    FOREIGN KEY (Plan_ID) REFERENCES Fixed_Deposit_Plan(Plan_ID) ,
    FOREIGN KEY (Account_No) REFERENCES Savings_Account(Account_No) ,
    FOREIGN KEY (Transaction_ID) REFERENCES Online_Transaction(Transaction_ID) ,
    PRIMARY KEY (FD_No)
);
CREATE TABLE Bank_Visit_Loan(  /*--(child)*/
    Loan_ID INT,
    Approved_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Approved_By INT,
    Requested_By INT,
    FOREIGN KEY (Loan_ID) REFERENCES Loan(Loan_ID) ,
    FOREIGN KEY (Approved_By) REFERENCES Maneger(Employee_ID) ,
    FOREIGN KEY (Requested_By) REFERENCES Clerk(Employee_ID) 
);
CREATE TABLE Online_Loan(  /*--(child)*/
    Loan_ID INT,
    FD_No INT NOT NULL,
    FOREIGN KEY (Loan_ID) REFERENCES Loan(Loan_ID) ,
    FOREIGN KEY (FD_No) REFERENCES Fixed_Deposit(FD_No) 
);
/* There isn't inheritance relationship between Loan,Bank_Visit_Loan,Online_Loan entities in the ERD.It has been added to reduce redundency. 
Here,Loan is the parent  entity and Bank_Visit_Loan,Online_Loan entities are child entities*/
CREATE TABLE Loan_Installment_Bank(
    Installment_ID INT UNSIGNED AUTO_INCREMENT,
    Loan_ID INT NOT NULL,
    Amount FLOAT NOT NULL,
    Due_Date DATE,
    Paid_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Loan_ID) REFERENCES Loan(Loan_ID) ,
    PRIMARY KEY (Installment_ID)
);


