CREATE DATABASE Bank;
USE Bank;
CREATE TABLE Customer(
    Customer_ID INT UNSIGNED AUTO_INCREMENT,
    Address VARCHAR(80),
    Primary_Email VARCHAR(50),
    Primary_Contact_No VARCHAR(10), 
    PRIMARY KEY(Customer_ID)
);
CREATE TABLE Customer_Email(    /*{Email} multi valued attribute*/ /**/
    Customer_ID INT NOT NULL,
    Email VARCHAR(50) NOT NULL,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Customer_Contact_No(   /*--{Contact_No} multi valued attribute*/ 
    Customer_ID INT NOT NULL,
    Contact_No VARCHAR(10) NOT NULL,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Organization(
    Customer_ID INT,
    Name VARCHAR(50) NOT NULL,
    Bussiness_Registration_Number VARCHAR(20),
    PRIMARY KEY(Customer_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) /*ON DELETE SET NULL*/
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
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Customer_Login(
    Customer_ID INT,
    Username VARCHAR(50),
    Password VARCHAR(100) NOT NULL,
    Recovery_Contact_No VARCHAR(10) NOT NULL,
    Recovery_Email VARCHAR(50) NOT NULL,
    PRIMARY KEY(Username),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) /*ON DELETE SET NULL*/
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
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Employee_Contact_No(    /*--{Contact_No} multi valued attribute*/
    Employee_ID INT NOT NULL,
    Contact_No VARCHAR(10) NOT NULL,
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Employee_Login(
    Employee_ID INT,
    Username VARCHAR(50),
    Password VARCHAR(100),
    Recovery_Contact_No VARCHAR(10),
    Recovery_Email VARCHAR(50),
    PRIMARY KEY(Username),
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Maneger(
    Employee_ID INT,
    PRIMARY KEY(Employee_ID),
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Clerk(
    Employee_ID INT,
    PRIMARY KEY(Employee_ID),
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Account(
    Account_No INT,
    Currency VARCHAR(3) NOT NULL,
    Balance FLOAT,
    Primary_Customer_ID INT,     /*one account can have many customers.but in most cases it is one*/
    Primary_Branch_ID INT, /*account has a branch. but customer can add many branches.This attribute makes redundence data.*/
    Account_Status VARCHAR(10),         /*but in most cases customers tend to use the branch where the account is created*/
    Date_Created DATETIME,
    FOREIGN KEY (Primary_Branch_ID) REFERENCES Branch(Branch_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Primary_Customer_ID) REFERENCES Customer(Customer_ID) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Account_No)
);
CREATE TABLE Account_Branch(     /*--customer can add many branches to a single account(mentioned in the SRS)*/
    Account_No INT NOT NULL,              /*--apart from the account creating branch*/
    Branch_ID INT NOT NULL,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Customer_Account(   /*--one customer can have many accounts and one account can belongs to many people(ex:joint accounts)*/
    Customer_ID INT NOT NULL,
    Account_No INT NOT NULL,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/
);
CREATE TABLE Checking_Account(   /*--'Checking account' is the term given in the discription not 'current account'*/
    Account_No INT,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Account_No)
);
CREATE TABLE Checkbook(
    Checkbook_Number INT UNSIGNED AUTO_INCREMENT,
    Account_No INT NOT NULL,
    Issued_Date DATE NOT NULL,
    Number_of_Pages INT NOT NULL,
    Starting_Check_Number INT NOT NULL,
    FOREIGN KEY (Account_No) REFERENCES Checking_Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Checkbook_Number)
);
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
    FOREIGN KEY (Account_Plan_ID) REFERENCES Savings_Account_Plan(Plan_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Account_No)
);
CREATE TABLE Child_Savings_Account(
    Account_No INT,
    First_Name VARCHAR(10),
    Last_Name VARCHAR(10),
    Middle_Name VARCHAR(10),
    DOB DATE,
    Gender VARCHAR(6),
    FOREIGN KEY (Account_No) REFERENCES Savings_Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Account_No)
);
CREATE TABLE Transaction_Detail(
    Transaction_ID INT,
    Account_No INT NOT NULL,
    Amount FLOAT NOT NULL,
    Date_Time DATETIME,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Transaction_ID)
);
CREATE TABLE Bank_Transaction(
    Transaction_ID INT,
    Type VARCHAR(8),
    FOREIGN KEY (Transaction_ID) REFERENCES Transaction_Details(Transaction_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE ATM_Withdrawal(
    Transaction_ID INT,
    ATM_ID INT,
    FOREIGN KEY (Transaction_ID) REFERENCES Transaction_Details(Transaction_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Online_Transaction(
    Transaction_ID INT,
    Recepient_ACC_No INT,
    FOREIGN KEY (Transaction_ID) REFERENCES Transaction_Details(Transaction_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Recepient_ACC_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/
);
CREATE TABLE Loan_Type(  /*--there are basically two loan types are given in the description but it has not mentioned in the ERD.*/
    Type_ID INT,         /*--Please have a look*/
    Type_Nmae VARCHAR(15),
    Interest_Rate FLOAT NOT NULL,
    PRIMARY KEY (Type_ID)
);
CREATE TABLE Requested_Loan( /*--this is also not in the ERD. in my opinion this should be there because there can be many*/
    Request_ID INT UNSIGNED AUTO_INCREMENT,          /*--loans which cannot approve at all and if we add all those things to the loan table,it would become a dustbin*/
    Account_No INT NOT NULL,
    Loan_Type INT NOT NULL,
    Amount FLOAT NOT NULL,
    Branch_ID INT,
    Time_Period INT NOT NULL,
    Installment FLOAT NOT NULL,
    Requested_Date DATE NOT NULL,
    Requested_By INT,
    Request_Status VARCHAR(10),
    FOREIGN KEY (Requested_By) REFERENCES Clerk(Employee_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Loan_Type) REFERENCES Loan_Type(Type_ID) /*ON DELETE SET NULL*/,
    PRIMARY KEY (Request_ID)
);
CREATE TABLE Loan( /*--this is also not mentioned as a inheritence in the ERD. Please have a look (parent)*/
    Loan_ID INT,     /*--another problem. why have you made a has reletionship from 'Loan_BankVist' to 'Customer'?*/
    Account_No INT,      /*--I have removed it. we have to discuss it*/
    Loan_Type INT,
    Amount FLOAT,
    Branch_ID INT,
    Time_Period INT,
    Installment FLOAT,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Loan_Type) REFERENCES Loan_Type(Type_ID) /*ON DELETE SET NULL*/,
    PRIMARY KEY (Loan_ID)
);
CREATE TABLE Bank_Visit_Loan(  /*--(child)*/
    Loan_ID INT,
    Approved_Date DATE,
    Approved_By INT,
    Requested_By INT,
    FOREIGN KEY (Loan_ID) REFERENCES Loan(Loan_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Approved_By) REFERENCES Maneger(Employee_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Requested_By) REFERENCES Clerk(Employee_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Online_Loan(  /*--(child)*/
    Loan_ID INT,
    FD_No INT NOT NULL,
    FOREIGN KEY (Loan_ID) REFERENCES Loan(Loan_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (FD_No) REFERENCES Fixed_Deposit(FD_No) /*ON DELETE SET NULL*/
);
CREATE TABLE Loan_Installment_Bank(
    Installment_ID INT UNSIGNED AUTO_INCREMENT,
    Loan_ID INT,
    Amount FLOAT,
    Due_Date DATE,
    Paid_Date DATE,
    FOREIGN KEY (Loan_ID) REFERENCES Loan(Loan_ID) /*ON DELETE SET NULL*/,
    PRIMARY KEY (Installment_ID)
);
CREATE TABLE Fixed_Deposit_Plan(
    Plan_ID INT,
    Time_Period VARCHAR(10) NOT NULL,
    Interest FLOAT NOT NULL,
    PRIMARY KEY (Plan_ID)
);
CREATE TABLE Fixed_Deposit(
    FD_No INT,
    Customer_ID INT NOT NULL,
    Account_No INT, /*account number can be null here because there no need to have a savings account to open a fixed deposit.anyone can do */
    Amount FLOAT NOT NULL,
    Date_Opened DATE NOT NULL,
    Plan_ID INT NOT NULL,
    FOREIGN KEY (Plan_ID) REFERENCES Fixed_Deposit_Plan(Plan_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Account_No) REFERENCES Savings_Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY (FD_No)
);
INSERT INTO Savings_Account_Plan(Plan_ID,Account_Plan,Minimum_Balance,Interest) VALUES (1,'Children',0,12),(2,'Teen',500,11),(3,'Adult(18+)',1000,10),(4,'Senior',1000,13);
INSERT INTO Fixed_Deposit_Plan(Plan_ID,Time_Period,Interest) VALUES (1,'6 months',13),(2,'1 year',14),(3,'3 years',15);
INSERT INTO Employee_Login(Employee_ID,Username,Password,Recovery_Contact_No,Recovery_Email) VALUES (973611178,'thisal','8cb2237d0679ca88db6464eac60da96345513964','0766220249','thisal@mail.com'); /*password=12345*/

