<?php
	// Script to generate the database
	require('./connect.php');
	global $lokaldb;
	$run = false;
	$sql = "ALTER DATABASE lokal CHARACTER SET = utf8 COLLATE utf8_unicode_ci;";
	$sql .= "DROP TABLE IF EXISTS `Admins`;
			DROP TABLE IF EXISTS `Privileges`; 
			DROP TABLE IF EXISTS `Restaurants`; 
			DROP TABLE IF EXISTS `Customers`; 
			DROP TABLE IF EXISTS `Codes`;";
	//var_dump($sql);
	if($run)var_dump($lokaldb->query($sql));
	$sql = "CREATE TABLE IF NOT EXISTS Admins (
			AdminID INT(5) NOT NULL AUTO_INCREMENT,
			Username VARCHAR(20) NOT NULL,
			Password VARCHAR(100) NOT NULL,
			Email VARCHAR(100) NOT NULL,
			Fname VARCHAR(100) NOT NULL,
			Lname VARCHAR(100) NOT NULL,
			UNIQUE INDEX user_un (Username),
			PRIMARY KEY admin_pk (AdminID)
		);";
	if($run)var_dump($lokaldb->query($sql));
	$sql = "CREATE TABLE IF NOT EXISTS Privileges (
			PrivID INT(5) NOT NULL AUTO_INCREMENT,
			AdminID INT(5) NOT NULL,
			RestID INT(5) NOT NULL,
			PRIMARY KEY (PrivID),
			FOREIGN KEY priv_to_admin (AdminID) 
				REFERENCES Admins(admin_pk)
		);";
	if($run)var_dump($lokaldb->query($sql));
	$sql = "CREATE TABLE IF NOT EXISTS Restaurants (
			RestID INT(5) NOT NULL AUTO_INCREMENT,
			RestName VARCHAR(100) NOT NULL,
			PRIMARY KEY rest_pk (RestID)
		);";
	if($run)var_dump($lokaldb->query($sql));
	$sql = "ALTER TABLE `Priveleges` ADD CONSTRAINT `rest_fk` FOREIGN KEY (`RestID`) REFERENCES Restaurants(`rest_pk`);";
	if($run)var_dump($lokaldb->query($sql));
	$sql = "CREATE TABLE IF NOT EXISTS Customers (
			ID INT(5) NOT NULL AUTO_INCREMENT,
			Email VARCHAR(100) NOT NULL,
			DOB DATE NOT NULL ,
			FirstName VARCHAR(30) NOT NULL,
			LastName VARCHAR(30) NOT NULL,
			RestID INT(5) NOT NULL,
			RegDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
			PRIMARY KEY custID_pk (ID),
			FOREIGN KEY rest_to_cust (RestID)
				REFERENCES Restaurants(rest_pk)
		);";
	if($run)var_dump($lokaldb->query($sql));
	$sql = "CREATE TABLE IF NOT EXISTS Codes (
			ID INT(5) NOT NULL AUTO_INCREMENT,
			Code VARCHAR(100) NOT NULL,
			CustID INT(5) NOT NULL,
			Exp TIMESTAMP NOT NULL,
			PRIMARY KEY codeID_pk (ID),
			FOREIGN KEY code_to_cust(CustID)
				REFERENCES Customers (custID_pk) 
		);";
	if($run)var_dump($lokaldb->query($sql));
	// footer includes the database close
	/*
	$sql = "DELIMITER $$
			drop trigger if exists `trg_admin_priv` $$
			create trigger `trg_admin_priv` after insert on `Restaurants`
			FOR EACH ROW begin
				insert into Privileges (`AdminID`, `RestID`) VALUES (1, NEW.RestID);
			end$$"
	*/
	$lokaldb->close();
?>