<?php

// Things to notice:
// This script will let a logged-in user VIEW their account details and allow them to UPDATE those details
// The main job of this script is to execute an INSERT or UPDATE statement to create or update a user's account information...
// ... but only once the data the user supplied has been validated on the client-side, and then sanitised ("cleaned") and validated again on the server-side
// It's your job to add these steps into the code
// Both sign_up.php and sign_in.php do client-side validation, followed by sanitisation and validation again on the server-side -- you may find it helpful to look at how they work 
// HTML5 can validate all the account data for you on the client-side
// The PHP functions in helper.php will allow you to sanitise the data on the server-side and validate *some* of the fields... 
// There are fields you will want to add to allow the user to update them...
// ... you'll also need to add some new PHP functions of your own to validate email addresses, telephone numbers and dates

// execute the header script:
require_once "header.php";

// default values we show in the form:
$password = "";
$email = "";
$firstname = "";
$surname = "";
$dateofBirth = "";
$telephone = "";

  
// strings to hold any validation error messages:
$password_val = "";
$email_val = "";
$firstname_val = "";
$surname_val = "";
$dateofBirth_val = "";
$telephone_val = "";
 
// should we show the set profile form?:
$show_account_form = false;

// message to output to user:
$message = "";

// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}


elseif (isset($_POST['email']))
{
	// user just tried to update their profile
	
	// connect directly to our database (notice 4th argument) we need the connection for sanitisation:
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	
	$password = $_POST['password'];
	$password = $_POST['email'];
	$firstname = $_POST['firstname'];
	$surname = $_POST['surname'];
	$dateofBirth = $_POST['dateofBirth'];
	$telephone = $_POST['telephone'];
	
	// SANITISATION CODE :
	// SERVER-SIDE VALIDATION CODE :
    $password = sanitise($_POST['password'], $connection);
    $email = sanitise($_POST['email'], $connection);
	$firstname = sanitise($_POST['firstname'], $connection);
	$surname = sanitise($_POST['surname'], $connection);
	$dateofBirth = sanitise($_POST['dateofBirth'], $connection);
	$telephone = sanitise($_POST['telephone'], $connection);
	
	$password_val = validateString($password, 1, 16);
    $email_val = validateEmail($email);
	$firstname_val = validateString($firstname, 1, 16);
	$surname_val = validateString($surname, 1, 16);
	$dateofBirth_val = validateDOB($dateofBirth);
	$telephone_val = validateTel($telephone);

	$errors = $password_val . $email_val . $firstname_val . $surname_val . $dateofBirth_val . $telephone_val;
	
	// check that all the validation tests passed before going to the database:
	if ($errors == "")
	{		
		// read their username from the session:
		$username = $_SESSION["username"];
		
		// now write the new data to our database table...
		$sql = "UPDATE users SET password='{$_POST['password']}',email='{$_POST['email']}',firstname='{$_POST['firstname']}' ,surname='{$_POST['surname']}',dateofBirth='{$_POST['dateofBirth']}',telephone='{$_POST['telephone']}' WHERE username='$username'";
		
		
		// check to see if this user exists:
		$query = "SELECT * FROM users WHERE username='$username'";
		
		// this query can return data ($result is an identifier):
		$result = mysqli_query($connection, $query);
		
		// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
		$n = mysqli_num_rows($result);
			
		// if there was a match then UPDATE their profile data, otherwise INSERT it:
		if ($n > 0)
		{
			// we need an UPDATE:
			$query = "UPDATE users SET password='$password', email='$email',firstname='$firstname',surname='$surname',dateofBirth='$dateofBirth', telephone='$telephone' WHERE username='$username'";
			$result = mysqli_query($connection, $query);		
		}
	

		// no data returned, we just test for true(success)/false(failure):
		if ($result) 
		{
			// show a successful update message:
			$message = "Profile successfully updated<br>";
		} 
		else
		{
			// show the set profile form:
			$show_account_form = true;
			// show an unsuccessful update message:
			$message = "Update failed<br>";
		}
	}
	else
	{
		// validation failed, show the form again with guidance:
		$show_account_form = true;
		// show an unsuccessful update message:
		$message = "Update failed, please check the errors above and try again<br>";
	}
	
	// we're finished with the database, close the connection:
	mysqli_close($connection);

}

else
{
	// user has arrived at the page for the first time, show any data already in the table:
	
	// read the username from the session:
	$username = $_SESSION["username"];
	
	// now read their profile data from the table...
	
	
	// connect directly to our database (notice 4th argument):
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	
	// check for a row in our profiles table with a matching username:
	$query = "SELECT * FROM users WHERE username='$username'";
	
	// this query can return data ($result is an identifier):
	$result = mysqli_query($connection, $query);
	
	// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
	$n = mysqli_num_rows($result);
		
	// if there was a match then extract their profile data:
	if ($n > 0)
	{
		// use the identifier to fetch one row as an associative array (elements named after columns):
		$row = mysqli_fetch_assoc($result);
		// extract their profile data for use in the HTML:
		$password = $row['password'];
		$email = $row['email'];
		$firstname = $row['firstname'];
		$surname = $row['surname'];
		$dateofBirth = $row['dateOfBirth'];
		$telephone = $row['telephone'];
		

	}
	
	// show the set profile form:
	$show_account_form = true;
	
	// we're finished with the database, close the connection:
	mysqli_close($connection);
	
}

//without client side  
if ($show_account_form)
{
echo <<<_END
    
    <form action="account_set.php" method="post">
	Update your profile info:<br>
		Username: {$_SESSION['username']}
		<br>
		Password: <input type="password"  name="password"  value="$password" > <b><i>$password_val</b></i>
		<br>
		Email: <input type="email" name="email" value="$email" > $email_val
		<br>
		FirstName: <input type="text" name="firstname"  value="$firstname"  > <b><i>$firstname_val</b></i>
		<br>
		Surname: <input type="text"  name="surname" value="$surname" > <b><i>$surname_val</b></i>
		<br>
		DOB: <input type="date" name="dateofBirth" value="$dateofBirth" > $dateofBirth_val
		<br>
		Telephone: <input type="text" name="telephone"  value="$telephone" > $telephone_val
		<br>
		<input type="submit" value="Submit">
    </form>	
_END;
}

/*
//client side 
if ($show_account_form)
{
echo <<<_END
    
    <form action="account_set.php" method="post">
	Update your profile info:<br>
		Username: {$_SESSION['username']}
		<br>
		Password: <input type="password"  name="password" minlength="1" maxlength="16" value="$password" required> <b><i>$password_val</b></i>
		<br>
		Email: <input type="email" name="email" minlength="1" maxlength="64" value="$email" required> $email_val
		<br>
		FirstName: <input type="text" name="firstname" minlength="1" maxlength="16" value="$firstname" required > <b><i>$firstname_val</b></i>
		<br>
		Surname: <input type="text"  name="surname" minlength="1" maxlength="16"value="$surname" required> <b><i>$surname_val</b></i>
		<br>
		DOB: <input type="date" name="dateofBirth" value="$dateofBirth" required> $dateofBirth_val
		<br>
		Telephone: <input type="text" name="telephone" minlength="11" maxlength="11" value="$telephone" required> $telephone_val
		<br>
		<input type="submit" value="Submit">
    </form>	
_END;
}
*/

// display our message to the user:
echo $message;

// finish of the HTML for this page:
require_once "footer.php";
?>