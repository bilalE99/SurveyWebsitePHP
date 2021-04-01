<?php

// Things to notice:
// This file is the first one we will run when we mark your submission
// Its job is to: 
// Create your database (currently called "skeleton", see credentials.php)... 
// Create all the tables you will need inside your database (currently it makes a simple "users" table, you will probably need more and will want to expand fields in the users table to meet the assignment specification)... 
// Create suitable test data for each of those tables 
// NOTE: this last one is VERY IMPORTANT - you need to include test data that enables the markers to test all of your site's functionality

// read in the details of our MySQL server:
require_once "credentials.php";

// We'll use the procedural (rather than object oriented) mysqli calls

// connect to the host:
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);

// exit the script with a useful message if there was an error:
if (!$connection)
{
	die("Connection failed: " . $mysqli_connect_error);
}
  
// build a statement to create a new database:
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Database created successfully, or already exists<br>";
} 
else
{
	die("Error creating database: " . mysqli_error($connection));
}

// connect to our database:
mysqli_select_db($connection, $dbname);

///////////////////////////////////////////
////////////// USERS TABLE //////////////
///////////////////////////////////////////

// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS users";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Dropped existing table: users<br>";
}

else 
{	
	die("Error checking for existing table: " . mysqli_error($connection));
}

// make our table:
// notice that the username field is a PRIMARY KEY and so must be unique in each record
$sql = "CREATE TABLE users (firstname VARCHAR(16), surname VARCHAR(16), username VARCHAR(16), password VARCHAR(16), email VARCHAR(64),dateOfBirth DATE , telephone VARCHAR(11),  PRIMARY KEY(username))";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Table created successfully: users<br>";
}

else 
{
	die("Error creating table: " . mysqli_error($connection));
}

// put some data in our table:
// create an array variable for each field in the DB that we want to populate
$firstnames[] = 'barry'; $surnames[] = 'mike'; $usernames[] = 'barrym'; $passwords[] = 'letmein'; $emails[] = 'barry@m-domain.com'; $dob[] = '2008-03-09'; $telephoneNo[] = '07234567811';
$firstnames[] = 'mandy'; $surnames[] = 'brian'; $usernames[] = 'mandyb'; $passwords[] = 'abc123'; $emails[] = 'webmaster@mandy-g.co.uk'; $dob[] = '1993-02-07'; $telephoneNo[] = '07634363811';
$firstnames[] = 'timmy'; $surnames[] = 'turner'; $usernames[] = 'timmy'; $passwords[] = 'secret95'; $emails[] = 'timmy@lassie.com'; $dob[] = '1970-11-22'; $telephoneNo[] = '07934516651';
$firstnames[] = 'brian'; $surnames[] = 'gareth'; $usernames[] = 'briang'; $passwords[] = 'password'; $emails[] = 'brian@quahog.gov'; $dob[] = '1998-08-27'; $telephoneNo[] = '07812367465';
$firstnames[] = 'alpha'; $surnames[] = 'male'; $usernames[] = 'alpham'; $passwords[] = 'test'; $emails[] = 'a@alphabet.test.com'; $dob[] = '2008-02-25'; $telephoneNo[] = '59920390255';
$firstnames[] = 'Graeme'; $surnames[] = 'Mcghee'; $usernames[] = 'b'; $passwords[] = 'test'; $emails[] = 'b@alphabet.test.com'; $dob[] = '1986-01-26'; $telephoneNo[] = '72251075341';
$firstnames[] = 'Nick '; $surnames[] = 'Dulcie '; $usernames[] = 'c'; $passwords[] = 'test'; $emails[] = 'c@alphabet.test.com'; $dob[] = '1998-10-26'; $telephoneNo[] = '81353763646';
$firstnames[] = 'Julie '; $surnames[] = 'Ilayda '; $usernames[] = 'd'; $passwords[] = 'test'; $emails[] = 'd@alphabet.test.com'; $dob[] = '1984-03-06'; $telephoneNo[] = '48602315435';
$firstnames[] = 'Haiden '; $surnames[] = 'Hatfield'; $usernames[] = 'e'; $passwords[] = 'test'; $emails[] = 'e@alphabet.test.com'; $dob[] = '1963-05-23'; $telephoneNo[] = '88642728628';
$firstnames[] = ''; $surnames[] = ''; $usernames[] = 'admin'; $passwords[] = 'secret'; $emails[] = 'admin@alphabet.test.com'; $dob[] = '1963-05-23'; $telephoneNo[] = '07348943023';

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($usernames); $i++)
{
	// create the SQL query to be executed
    $sql = "INSERT INTO users (firstname, surname, username, password, email,dateOfBirth, telephone) VALUES ('$firstnames[$i]', '$surnames[$i]','$usernames[$i]', '$passwords[$i]', '$emails[$i]', '$dob[$i]', '$telephoneNo[$i]')";
	
	// run the above query '$sql' on our DB
    // no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) 
	{
		echo "row inserted<br>";
	}

	else 
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}


///////////////////////////////////////////
////////////// DATA TABLE //////////////
///////////////////////////////////////////

// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS data";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Dropped existing table: data<br>";
}

else 
{	
	die("Error checking for existing table: " . mysqli_error($connection));
}

// make our table:
$sql = "CREATE TABLE data (name VARCHAR(16), manufacturer VARCHAR(16),model VARCHAR(16),fuelType VARCHAR(8),BHP INT(11),engineSize VARCHAR(16),plate INT(11), PRIMARY KEY(name))";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Table created successfully: data<br>";
}

else 
{
	die("Error creating table: " . mysqli_error($connection));
}


// put some data in our table:
// create an array variable for each field in the DB that we want to populate
$names[] = '3 Series'; $manufacturers[] = 'BMW'; $models[] = 'Stock'; $fuelTypes[] = 'Diesel'; $BHPs[] = '170'; $engineSizes[] = '2.0L'; $plates[] = '14';
$names[] = 'A Class AMG'; $manufacturers[] = 'Mercedes'; $models[] = 'Sport Hatchback'; $fuelTypes[] = 'Petrol'; $BHPs[] = '255'; $engineSizes[] = '2.5L'; $plates[] = '19';
$names[] = 'RS6'; $manufacturers[] = 'Audi'; $models[] = 'Sport'; $fuelTypes[] = 'Diesel'; $BHPs[] = '645'; $engineSizes[] = '3.2L'; $plates[] = '18';
$names[] = 'Golf R'; $manufacturers[] = 'VW'; $models[] = 'Sport Hatchback'; $fuelTypes[] = 'Petrol'; $BHPs[] = '355'; $engineSizes[] = '2.1L'; $plates[] = '08';
$names[] = 'M5'; $manufacturers[] = 'BMW'; $models[] = 'Sport'; $fuelTypes[] = 'Diesel'; $BHPs[] = '780'; $engineSizes[] = '3.6L'; $plates[] = '06';
$names[] = 'Evoque'; $manufacturers[] = 'Range Rover'; $models[] = 'Stock'; $fuelTypes[] = 'Diesel'; $BHPs[] = '230'; $engineSizes[] = '2.6L'; $plates[] = '13';


// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($names); $i++)
{
	// create the SQL query to be executed
    $sql = "INSERT INTO data (name,manufacturer,model,fuelType,BHP,engineSize,plate) VALUES ('$names[$i]', '$manufacturers[$i]','$models[$i]','$fuelTypes[$i]','$BHPs[$i]','$engineSizes[$i]','$plates[$i]')";
	
	// run the above query '$sql' on our DB
    // no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) 
	{
		echo "row inserted<br>";
	}

	else 
	{
		die("Error inserting row:" . mysqli_error($connection));
	}
}







///////////////////////////////////////////
////////////// SCOREs TABLE //////////////
///////////////////////////////////////////

// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS scores";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Dropped existing table: scores<br>";
}

else 
{	
	die("Error checking for existing table: " . mysqli_error($connection));
}

// make our table:
$sql = "CREATE TABLE scores (username VARCHAR(16), result INT(11), PRIMARY KEY(username))";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Table created successfully: scores<br>";
}

else 
{
	die("Error creating table: " . mysqli_error($connection));
}


// put some data in our table:
// create an array variable for each field in the DB that we want to populate
$usernamess[] = 'admin'; $results[] = '0'; 
$usernamess[] = 'alpham'; $results[] = '0'; 
$usernamess[] = 'b'; $results[] = '0'; 
$usernamess[] = 'barrym'; $results[] = '0'; 
$usernamess[] = 'briang'; $results[] = '0'; 
$usernamess[] = 'c'; $results[] = '0'; 
$usernamess[] = 'd'; $results[] = '0'; 
$usernamess[] = 'e'; $results[] = '0'; 
$usernamess[] = 'mandyb'; $results[] = '0'; 
$usernamess[] = 'timmy'; $results[] = '0'; 


// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($usernamess); $i++)
{
	// create the SQL query to be executed
    $sql = "INSERT INTO scores (username,result) VALUES ('$usernamess[$i]', '$results[$i]')";
	
	// run the above query '$sql' on our DB
    // no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) 
	{
		echo "row inserted<br>";
	}

	else 
	{
		die("Error inserting row:" . mysqli_error($connection));
	}
}



// we're finished, close the connection:
mysqli_close($connection);
?>