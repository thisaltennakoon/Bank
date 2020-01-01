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


CREATE TABLE Manager(
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
    Account_No BIGINT UNSIGNED AUTO_INCREMENT,
    Balance FLOAT,
    Primary_Customer_ID INT,     /*one account can have many customers.but in most cases it is one*/
    Primary_Branch_ID INT, /*account has a branch. but customer can add many branches.This attribute makes redundence data.*/
    Account_Status VARCHAR(10),         /*but in most cases customers tend to use the branch where the account is created*/
    Date_Created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
    Transaction_ID INT AUTO_INCREMENT,
    Account_No BIGINT NOT NULL,
    Amount FLOAT NOT NULL,
	Withdraw BOOLEAN,/*withdraw-True,deposit-False*/
    Balance FLOAT NOT NULL,
    Detail VARCHAR(20),
    Date_Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Teller VARCHAR(20),
    FOREIGN KEY (Account_No) REFERENCES Account(Account_No) /*ON DELETE SET NULL*/,
    PRIMARY KEY(Transaction_ID)
);

CREATE TABLE Bank_Transaction(
    Transaction_ID INT PRIMARY KEY,
    FOREIGN KEY (Transaction_ID) REFERENCES Transaction_Details(Transaction_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE ATM_Withdrawal(
    ATM_Transaction_ID INT AUTO_INCREMENT,
	Transaction_ID INT,
    ATM_ID INT,
	PRIMARY KEY(ATM_Transaction_ID),
    FOREIGN KEY (Transaction_ID) REFERENCES Transaction_Details(Transaction_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Online_Transaction(
    Online_Transaction_ID INT AUTO_INCREMENT,
	Withdrawal_ID INT,
	Deposit_ID INT,
    FOREIGN KEY (Withdrawal_ID) REFERENCES Transaction_Details(Transaction_ID), /*ON DELETE SET NULL*/
	FOREIGN KEY (Deposit_ID) REFERENCES Transaction_Details(Transaction_ID), /*ON DELETE SET NULL*/
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
ALTER TABLE Loan AUTO_INCREMENT=11301003989;

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

CREATE TABLE Loan_Arrears(
    Loan_ID INT NOT NULL,
    Due_Date DATE,
    FOREIGN KEY (Loan_ID) REFERENCES Loan(Loan_ID) /*ON DELETE SET NULL*/,
    PRIMARY KEY (Loan_ID,Due_Date)
);

CREATE TABLE Fixed_Deposit_Plan(
    Plan_ID INT,
    Time_Period VARCHAR(10) NOT NULL,
    Interest FLOAT NOT NULL,
    PRIMARY KEY (Plan_ID)
);


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



/*CREATE TRIGGER after_Transaction_Detail_update
    BEFORE UPDATE ON Transaction_Detail
    REFERENCING NEW ROW AS nrow
    FOR EACH ROW
    IF(nrow.Withdraw=True)
    THEN UPDATE Account SET Balance=Balance-nrow.Amount WHERE Account_No=nrow.Account_No
    ELSE
        UPDATE Account SET Balance=Balance+nrow.Amount WHERE Account_No=nrow.Account_No;*/


ALTER TABLE Fixed_Deposit AUTO_INCREMENT=11201003969;
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


INSERT INTO `account` (`Account_No`, `Balance`, `Primary_Customer_ID`, `Primary_Branch_ID`, `Account_Status`, `Date_Created`) VALUES
(22601003929, -1800, 5, 1, 'Active', '2020-01-02 00:17:47'),
(22601003930, 0, 1, 1, 'Active', '2020-01-02 00:19:56'),
(22601003931, 0, 2, 1, 'Active', '2020-01-02 00:20:38'),
(22601003932, 0, 3, 1, 'Active', '2020-01-02 00:21:56'),
(22601003933, 0, 4, 1, 'Active', '2020-01-02 00:22:50'),
(22601003934, 0, 3, 1, 'Active', '2020-01-02 00:23:27'),
(22601003935, -900, 4, 1, 'Active', '2020-01-02 00:26:49');

INSERT INTO `account_branch` (`Account_No`, `Branch_ID`) VALUES
(22601003929, 1),
(22601003929, 3),
(22601003929, 5),
(22601003929, 7),
(22601003930, 1),
(22601003930, 3),
(22601003930, 7),
(22601003931, 1),
(22601003931, 5),
(22601003931, 7),
(22601003931, 12),
(22601003932, 1),
(22601003932, 9),
(22601003932, 13),
(22601003932, 15),
(22601003933, 3),
(22601003933, 6),
(22601003933, 9),
(22601003934, 1),
(22601003934, 2),
(22601003934, 3),
(22601003934, 4),
(22601003935, 1),
(22601003935, 8),
(22601003935, 12);

INSERT INTO `checkbook` (`Checkbook_Number`, `Account_No`, `Issued_Date`, `Number_of_Pages`, `Starting_Check_Number`) VALUES
(1, 22601003929, '2020-01-01 19:06:05', 100, 20200102),
(2, 22601003935, '2020-01-01 19:07:24', 50, 20200202);

INSERT INTO `checking_account` (`Account_No`) VALUES
(22601003929),
(22601003935);

INSERT INTO `child_savings_account` (`Account_No`, `First_Name`, `Middle_Name`, `Last_Name`, `DOB`, `Gender`) VALUES
(22601003934, 'Anabella', 'Nicole', 'Rose', '2013-01-23', 'Female');

INSERT INTO `clerk` (`Employee_ID`) VALUES
(2),
(4);

INSERT INTO `customer` (`Customer_ID`, `Address_Line_1`, `Address_Line_2`, `Address_Line_3`, `Primary_Email`, `Primary_Contact_No`) VALUES
(1, '1st cross street', 'Germantown', 'Victoria', 'OliverJake@gmail.com', '1234567891'),
(2, 'Park Avenue', 'Florida', 'Marktown', 'AmeliaMargaret@gmail.com', '9876543211'),
(3, 'Queens Street', 'Parktown', 'Queensland', 'DamianWilliam@ymail.com', '5432167891'),
(4, 'Griffith Road', 'Brisbaner', 'Geogiana', 'IslaBethany@outlook.com', '1233214569'),
(5, 'Nathan Circular', 'Briginton', 'Griffith', 'info@uog.sh', '1234543211');


INSERT INTO `customer_account` (`Customer_ID`, `Account_No`) VALUES
(1, 22601003929),
(2, 22601003929),
(3, 22601003929),
(4, 22601003929),
(1, 22601003930),
(2, 22601003931),
(3, 22601003932),
(4, 22601003933),
(3, 22601003934),
(4, 22601003935);


INSERT INTO `customer_login` (`Customer_ID`, `Username`, `Password`, `Recovery_Contact_No`, `Recovery_Email`) VALUES
(1, 'oliverjake', '8cb2237d0679ca88db6464eac60da96345513964', '1234567891', 'OliverJake@gmail.com'),
(2, 'ameliaemma', '8cb2237d0679ca88db6464eac60da96345513964', '9876543211', 'AmeliaMargaret@gmail.com'),
(3, 'williamdamian', '8cb2237d0679ca88db6464eac60da96345513964', '5432167891', 'DamianWilliam@ymail.com'),
(4, 'bethanysophia', '348162101fc6f7e624681b7400b085eeac6df7bd', '1233214569', 'IslaBethany@outlook.com');

INSERT INTO `employee` (`Employee_ID`, `First_Name`, `Middle_Name`, `Last_Name`, `Address`, `NIC`, `DOB`, `Gender`, `Primary_Contact_No`, `Branch_ID`) VALUES
(1, 'John', 'Aniston', 'Smith', '123,Albert St, Victoria, Seychelles', '903611178V', '1969-12-26', 'Male', '0766220249', 1),
(2, 'Emma', 'Ruthann', 'Marasco', '21,Capital City, Independence Ave, Seychelles', '933611178V', '1997-11-26', 'Female', '0716220249', 1),
(3, 'Theresa', 'Amelia', 'May', '26,Park Road,Virginia', '697911178V', '1969-02-23', 'Female', '0766220249', 2),
(4, 'Albert', 'William', 'Brethan', '12,German Town,New South Wales', '983672354V', '1998-01-08', 'Male', '0717303215', 2);

INSERT INTO `employee_login` (`Employee_ID`, `Username`, `Password`, `Recovery_Contact_No`, `Recovery_Email`) VALUES
(1, 'john', '8cb2237d0679ca88db6464eac60da96345513964', '0766220249', 'johnsmith@gmail.com'),
(2, 'emma', '8cb2237d0679ca88db6464eac60da96345513964', '0716220249', 'emma@gmail.com'),
(3, 'theresa', 'f2515b5363f697393a46f4641e5c6b5ffc7a1d27', '0717303215', 'theresamay@banka.com'),
(4, 'albert', '198a52ae72c2d5c6f41914d337dc325238f6a53e', '0112816336', 'albertbrethan@yahoo.com');

INSERT INTO `fixed_deposit_plan` (`Plan_ID`, `Time_Period`, `Interest`) VALUES
(1, '6 months', 13),
(2, '1 year', 14),
(3, '3 years', 15);

INSERT INTO `individual` (`Customer_ID`, `First_Name`, `Last_Name`, `Middle_Name`, `NIC`, `DOB`, `Gender`) VALUES
(1, 'Oliver', 'Jake', 'Noah', '123456789V', '1992-01-02', 'Male'),
(2, 'Amelia', 'Emma', 'Margaret', '987654321V', '2000-01-15', 'Female'),
(3, 'William', 'Damian', 'Daniel', '123454321V', '1969-01-12', 'Male'),
(4, 'Isla', 'Bethany', 'Sophia', '973611178V', '1989-08-15', 'Female');

INSERT INTO `manager` (`Employee_ID`) VALUES
(1),
(3);

INSERT INTO `organization` (`Customer_ID`, `Name`, `Bussiness_Registration_Number`) VALUES
(5, 'University of Griffith', '22601929');

INSERT INTO `organization_individual` (`Organization_ID`, `Individual_ID`) VALUES
(5, 1),
(5, 2),
(5, 3),
(5, 4);

INSERT INTO `savings_account` (`Account_No`, `Number_of_Withdrawals`, `Account_Plan_ID`) VALUES
(22601003930, 0, 3),
(22601003931, 0, 2),
(22601003932, 0, 4),
(22601003933, 0, 3),
(22601003934, 0, 1);

INSERT INTO `savings_account_plan` (`Plan_ID`, `Account_Plan`, `Minimum_Balance`, `Interest`) VALUES
(1, 'Children', 0, 12),
(2, 'Teen', 500, 11),
(3, 'Adult(18+)', 1000, 10),
(4, 'Senior', 1000, 13);

