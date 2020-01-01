DROP DATABASE Bank;
CREATE DATABASE Bank;
USE Bank;
CREATE TABLE Customer(
    Customer_ID INT UNSIGNED AUTO_INCREMENT,    /*Statrt with CUS*/
    Address_Line_1 VARCHAR(30),
    Address_Line_2 VARCHAR(30),
    Address_Line_3 VARCHAR(30),
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
CREATE TABLE Individual(
    Customer_ID INT,
    First_Name VARCHAR(20),
    Last_Name VARCHAR(20),
    Middle_Name VARCHAR(20),
    NIC VARCHAR(10) NOT NULL,
    DOB DATE,
    Gender VARCHAR(6),
    PRIMARY KEY(Customer_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) /*ON DELETE SET NULL*/
);


CREATE TABLE Organization(
    Customer_ID INT,
    Name VARCHAR(50) NOT NULL,
    Bussiness_Registration_Number VARCHAR(20),
    PRIMARY KEY(Customer_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Organization_Individual(
    Organization_ID INT,
    Individual_ID INT,
    FOREIGN KEY (Organization_ID) REFERENCES Organization(Customer_ID),
    FOREIGN KEY (Individual_ID) REFERENCES Individual(Customer_ID)
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
    Branch_ID INT UNSIGNED AUTO_INCREMENT,
    Branch_Name VARCHAR(20),
    Location VARCHAR(20),
    PRIMARY KEY(Branch_ID)
);


CREATE TABLE Employee(
    Employee_ID INT UNSIGNED AUTO_INCREMENT,
    First_Name VARCHAR(20),
    Middle_Name VARCHAR(20),
    Last_Name VARCHAR(20),
    Address VARCHAR(80),
    NIC VARCHAR(10) NOT NULL,
    DOB DATE,
    Gender VARCHAR(6),
    Primary_Contact_No VARCHAR(10) NOT NULL,
    Branch_ID INT,
    PRIMARY KEY(Employee_ID),
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) /*ON DELETE SET NULL*/
);

INSERT INTO Employee(First_Name,Middle_Name,Last_Name,Address,NIC,DOB,Gender,Primary_Contact_No,Branch_ID) 
VALUES ('John','Aniston','Smith','123,Albert St, Victoria, Seychelles','903611178V','1969-12-26','Male','0766220249',1);
INSERT INTO Employee(First_Name,Middle_Name,Last_Name,Address,NIC,DOB,Gender,Primary_Contact_No,Branch_ID) 
VALUES ('Emma','Ruthann','Marasco','21,Capital City, Independence Ave, Seychelles','933611178V','1997-11-26','Female','0716220249',1);

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
INSERT INTO Employee_Login(Employee_ID,Username,Password,Recovery_Contact_No,Recovery_Email) 
VALUES (1,'john','8cb2237d0679ca88db6464eac60da96345513964','0766220249','johnsmith@gmail.com'); /*password=12345*/
INSERT INTO Employee_Login(Employee_ID,Username,Password,Recovery_Contact_No,Recovery_Email) 
VALUES (2,'emma','8cb2237d0679ca88db6464eac60da96345513964','0716220249','emma@gmail.com'); /*password=12345*/

CREATE TABLE Manager(
    Employee_ID INT,
    PRIMARY KEY(Employee_ID),
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) /*ON DELETE SET NULL*/
);
INSERT INTO Manager(Employee_ID) VALUES (1);

CREATE TABLE Clerk(
    Employee_ID INT,
    PRIMARY KEY(Employee_ID),
    FOREIGN KEY (Employee_ID) REFERENCES Employee(Employee_ID) /*ON DELETE SET NULL*/
);
INSERT INTO Clerk(Employee_ID) VALUES (2);

CREATE TABLE Account(
    Account_No BIGINT UNSIGNED AUTO_INCREMENT,
    Balance FLOAT,
    Primary_Customer_ID INT,     /*one account can have many customers.but in most cases it is one*/
    Primary_Branch_ID INT, /*account has a branch. but customer can add many branches.This attribute makes redundence data.*/
    Account_Status VARCHAR(10),         /*but in most cases customers tend to use the branch where the account is created*/
    Date_Created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Primary_Branch_ID) REFERENCES Branch(Branch_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Primary_Customer_ID) REFERENCES Customer(Customer_ID) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Account_No)
);
ALTER TABLE Account AUTO_INCREMENT=22601003929;

CREATE TABLE Account_Branch(     /*--customer can add many branches to a single account(mentioned in the SRS)*/
    Account_No BIGINT NOT NULL,              /*--apart from the account creating branch*/
    Branch_ID INT NOT NULL,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Customer_Account(   /*--one customer can have many accounts and one account can belongs to many people(ex:joint accounts)*/
    Customer_ID INT NOT NULL,
    Account_No BIGINT NOT NULL,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/
);
CREATE TABLE Checking_Account(   /*--'Checking account' is the term given in the discription not 'current account'*/
    Account_No BIGINT,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Account_No)
);
CREATE TABLE Checkbook(
    Checkbook_Number INT UNSIGNED AUTO_INCREMENT,
    Account_No BIGINT NOT NULL,
    Issued_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Number_of_Pages INT NOT NULL,
    Starting_Check_Number INT NOT NULL,
    FOREIGN KEY (Account_No) REFERENCES Checking_Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Checkbook_Number)
);
delimiter //
CREATE TRIGGER ChargeForCheckBook BEFORE INSERT ON Checkbook
 FOR EACH ROW
 BEGIN 
 UPDATE Account SET Balance=(Balance-((NEW.Number_of_Pages)*18)) WHERE Account_No=NEW.Account_No;
 END; //
 delimiter ;


CREATE TABLE Savings_Account_Plan(
    Plan_ID INT,
    Account_Plan VARCHAR(10),
    Minimum_Balance FLOAT,
    Interest FLOAT,
    PRIMARY KEY (Plan_ID)
);

INSERT INTO Savings_Account_Plan(Plan_ID,Account_Plan,Minimum_Balance,Interest) 
VALUES (1,'Children',0,12),(2,'Teen',500,11),(3,'Adult(18+)',1000,10),(4,'Senior',1000,13);

CREATE TABLE Savings_Account(
    Account_No BIGINT,
    Number_of_Withdrawals INT CHECK (Number_of_Withdrawals <= 5),
    Account_Plan_ID INT,
    FOREIGN KEY (Account_Plan_ID) REFERENCES Savings_Account_Plan(Plan_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Account_No)
);


CREATE TABLE Child_Savings_Account(
    Account_No BIGINT,
    First_Name VARCHAR(20),
    Middle_Name VARCHAR(20),
    Last_Name VARCHAR(20),
    DOB DATE,
    Gender VARCHAR(6),
    FOREIGN KEY (Account_No) REFERENCES Savings_Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Account_No,First_Name,Middle_Name)
);
CREATE TABLE Transaction_Detail(
    Transaction_ID INT,
    Account_No BIGINT NOT NULL,
    Amount FLOAT NOT NULL,
    Date_Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Transaction_ID)
);
CREATE TABLE Bank_Transaction(
    Transaction_ID INT,
    Withdraw BOOLEAN,/*withdraw-True,deposit-False*/
    FOREIGN KEY (Transaction_ID) REFERENCES Transaction_Details(Transaction_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE ATM_Withdrawal(
    Transaction_ID INT,
    ATM_ID INT,
    FOREIGN KEY (Transaction_ID) REFERENCES Transaction_Details(Transaction_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Online_Transaction(
    Online_Transaction_ID INT,
    Sender_ACC_No INT,
    Recepient_ACC_No INT,
    Sender_Transaction_ID INT,
    FOREIGN KEY (Recepient_ACC_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Sender_ACC_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Online_Transaction_ID)
);
CREATE TABLE Loan_Type(  /*--there are basically two loan types are given in the description but it has not mentioned in the ERD.*/
    Type_ID INT,         /*--Please have a look*/
    Type_Nmae VARCHAR(15),
    Interest_Rate FLOAT NOT NULL,
    PRIMARY KEY (Type_ID)
);
CREATE TABLE Requested_Loan( /*--this is also not in the ERD. in my opinion this should be there because there can be many*/
    Request_ID INT UNSIGNED AUTO_INCREMENT,          /*--loans which cannot approve at all and if we add all those things to the loan table,it would become a dustbin*/
    Account_No BIGINT NOT NULL,
    Amount FLOAT NOT NULL,
    Branch_ID INT,
    Time_Period INT NOT NULL,
    Installment FLOAT NOT NULL,
    Requested_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Requested_By INT,
    Request_Status VARCHAR(10),
    FOREIGN KEY (Requested_By) REFERENCES Clerk(Employee_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Loan_Type) REFERENCES Loan_Type(Type_ID) /*ON DELETE SET NULL*/,
    PRIMARY KEY (Request_ID)
);
CREATE TABLE Loan( /*--this is also not mentioned as a inheritence in the ERD. Please have a look (parent)*/
    Loan_ID BIGINT UNSIGNED AUTO_INCREMENT,/*--another problem. why have you made a has reletionship from 'Loan_BankVist' to 'Customer'?*/
    Account_No BIGINT,      /*--I have removed it. we have to discuss it*/
    Loan_Type INT,
    Amount FLOAT,
    Branch_ID INT,
    Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Time_Period INT,
    Installment FLOAT,
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Loan_Type) REFERENCES Loan_Type(Type_ID) /*ON DELETE SET NULL*/,
    PRIMARY KEY (Loan_ID)
);
ALTER TABLE Account AUTO_INCREMENT=11301003989;

CREATE TABLE Bank_Visit_Loan(  /*--(child)*/
    Loan_ID INT,
    Approved_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
    Loan_ID INT NOT NULL,
    Amount FLOAT NOT NULL,
    Due_Date DATE,
    Paid_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Loan_ID) REFERENCES Loan(Loan_ID) /*ON DELETE SET NULL*/,
    PRIMARY KEY (Installment_ID)
);
CREATE TABLE Fixed_Deposit_Plan(
    Plan_ID INT,
    Time_Period VARCHAR(10) NOT NULL,
    Interest FLOAT NOT NULL,
    PRIMARY KEY (Plan_ID)
);

INSERT INTO Fixed_Deposit_Plan(Plan_ID,Time_Period,Interest) 
VALUES (1,'6 months',13),(2,'1 year',14),(3,'3 years',15);

CREATE TABLE Fixed_Deposit(
    FD_No BIGINT UNSIGNED AUTO_INCREMENT,
    Account_No BIGINT, /*account number can be null here because there no need to have a savings account to open a fixed deposit.anyone can do */
    Amount FLOAT NOT NULL,
    Date_Opened TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Plan_ID INT NOT NULL,
    Transaction_ID INT,
    FOREIGN KEY (Plan_ID) REFERENCES Fixed_Deposit_Plan(Plan_ID) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Account_No) REFERENCES Savings_Account(Account_No) /*ON DELETE SET NULL*/,
    FOREIGN KEY (Transaction_ID) REFERENCES Online_Transaction(Transaction_ID) /*ON DELETE SET NULL*/,
    PRIMARY KEY (FD_No)
);
ALTER TABLE Account AUTO_INCREMENT=11201003969;
INSERT INTO Branch(Branch_Name,Location)  VALUES
('Head Office Victoria','Victoria'),
('Anse A La Mouche','Anse A La Mouche'),
('Anse Aux Pins','Anse Aux Pins'),
('Anse Boileau','Anse Boileau'),
('Anse Etoile','Anse Etoile'),
('Anse Kerlan','Anse Kerlan'),
('Anse Possession','Anse Possession'),
('Anse Royale','Anse Royale'),
('Anse Volbert Village','Anse Volbert Village'),
('Au Cap','Au Cap'),
('Baie Lazare Mahe','Baie Lazare Mahe'),
('Baie Sainte Anne','Baie Sainte Anne'),
('Baie St Anne','Baie St Anne'),
('Beau Vallon','Beau Vallon'),
('Bel Ombre','Bel Ombre'),
('Bird Island','Bird Island'),
('Cerf Island','Cerf Island'),
('Cousine','Cousine'),
('De Quincey Village','De Quincey Village'),
('Denis Island','Denis Island'),
('Desroches','Desroches'),
('Eden Island','Eden Island'),
('Felicite','Felicite'),
('Fregate Island','Fregate Island'),
('Glacis','Glacis'),
('Grand Anse','Grand Anse'),
('Grandanse','Grandanse'),
('Grandanse Praslin','Grandanse Praslin'),
('La Digue','La Digue'),
('La Reunion','La Reunion'),
('Machabee','Machabee'),
('Mahe','Mahe'),
('North Island','North Island'),
('Pinte Au Sel','Pinte Au Sel'),
('Pointe Au Sel','Pointe Au Sel'),
('Pointe Larue','Pointe Larue'),
('Port Glaud','Port Glaud'),
('Praslin','Praslin'),
('Silhouette Island','Silhouette Island'),
('Takamaka','Takamaka');

