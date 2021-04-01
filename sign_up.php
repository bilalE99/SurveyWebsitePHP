<?php

// Things to notice:
// The main job of this script is to execute an INSERT statement to add the submitted username, password and email address
// However, the assignment specification tells you that you need more fields than this for each user.
// So you will need to amend this script to include them. Don't forget to update your database (create_data.php) in tandem so they match
// This script does client-side validation using "password","text" inputs and "required","maxlength" attributes (but we can't rely on it happening!)
// we sanitise the user's credentials - see helper.php (included via header.php) for the sanitisation function
// we validate the user's credentials - see helper.php (included via header.php) for the validation functions
// the validation functions all follow the same rule: return an empty string if the data is valid...
// ... otherwise return a help message saying what is wrong with the data.
// if validation of any field fails then we display the help messages (see previous) when re-displaying the form

// execute the header script:
require_once "header.php";

// default values we show in the form:
$username = "";
$password = "";
$email = "";
$firstname = "";
$surname = "";
$dateofBirth = "";
$telephone = "";

// strings to hold any validation error messages:
$username_val = "";
$password_val = "";
$email_val = "";
$firstname_val = "";
$surname_val = "";
$dateofBirth_val = "";
$telephone_val = "";

// should we show the signup form?:
$show_signup_form = false;
// message to output to user:
$message = "Welcome, please sign up";


// checks the session variable named 'loggedInSkeleton'
if (isset($_SESSION['loggedInSkeleton']))
{
	// user is already logged in, just display a message:
	echo "You are already logged in, please log out if you wish to create a new account<br>";
	
}

elseif (isset($_POST['username']))
{
	// user just tried to sign up:
	
	// take copies of the credentials the user submitted:
    $username = $_POST['username'];
    $password = $_POST['password'];
	$password = $_POST['email'];
	$firstname = $_POST['firstname'];
	$surname = $_POST['surname'];
	$dateofBirth = $_POST['dateofBirth'];
	$telephone = $_POST['telephone'];
	
	
	// connect directly to our database (notice 4th argument) we need the connection for sanitisation:
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}	
	
	
	/////////////////////////////////////////
    //////// SERVER-SIDE VALIDATION /////////
    /////////////////////////////////////////
	// take copies of the credentials the user submitted, and sanitise (clean) them:
	$username = sanitise($_POST['username'], $connection);
	$password = sanitise($_POST['password'], $connection);
    $email = sanitise($_POST['email'], $connection);
	$firstname = sanitise($_POST['firstname'], $connection);
	$surname = sanitise($_POST['surname'], $connection);
	$dateofBirth = sanitise($_POST['dateofBirth'], $connection);
	$telephone = sanitise($_POST['telephone'], $connection);
	
	$username_val = validateString($username, 1, 16);
	$password_val = validateString($password, 1, 16);
    $email_val = validateEmail($email);
	$firstname_val = validateString($firstname, 1, 16);
	$surname_val = validateString($surname, 1, 16);
	$dateofBirth_val = validateDOB($dateofBirth);
	$telephone_val = validateTel($telephone);
	
	// concatenate all the validation results together ($errors will only be empty if ALL the data is valid):
	$errors = $username_val . $password_val . $email_val . $firstname_val . $surname_val . $dateofBirth_val . $telephone_val;
	
	
	// check that all the validation tests passed before going to the database:
	if ($errors == "")
	{
		
		// try to insert the new details:
		$query = "INSERT INTO users (firstname, surname,username, password, email, dateofBirth,telephone) VALUES ('$firstname','$surname','$username', '$password', '$email','$dateofBirth', '$telephone');";
		$result = mysqli_query($connection, $query);
		
		// no data returned, we just test for true(success)/false(failure):
		if ($result) 
		{
			// show a successful signup message:
			$message = "Signup was successful, please sign in<br>";
		} 
		else 
		{
			// show the form:
			$show_signup_form = true;
			// show an unsuccessful signup message:
			$message = "Sign up failed, please try again<br>";
		}
			
	}

	else
	{
		// validation failed, show the form again with guidance:
		$show_signup_form = true;
		// show an unsuccessful signin message:
		$message = "Sign up failed, please check the errors shown above and try again<br>";
	}
	
	// we're finished with the database, close the connection:
	mysqli_close($connection);

}

else
{
	// just a normal visit to the page, show the signup form:
	$show_signup_form = true;
	
}
/*
//version with client validation - turn off server side validation
if ($show_signup_form)
{
// show the form that allows users to sign up
// Note we use an HTTP POST request to avoid their password appearing in the URL:
    echo <<<_END
<form action="sign_up.php" method="post">
  Please choose a username,password and email:<br>
  Username: <input type="text" name="username" minlength="1" maxlength="16" value="$username" required > <b><i>$username_val</b></i>
  <br>
  Password: <input type="password"  name="password" minlength="1" maxlength="16" value="$password" required > <b><i>$password_val</b></i>
  <br>
  Email: <input type="email"  name="email" minlength="1" maxlength="64" value="$email" required> $email_val
  <br>
  FirstName: <input type="text" name="firstname" minlength="1" maxlength="16" value="$firstname" required> <b><i>$firstname_val</b></i>
  <br>
  Surname: <input type="text"  name="surname" minlength="1" maxlength="16" value="$surname" required> <b><i>$surname_val</b></i>
  <br>
  DOB: <input type="date" name="dateofBirth"  value="$dateofBirth" required> $dateofBirth_val
  <br>
  Telephone: <input type="text" name="telephone" minlength="11" maxlength="11" value="$telephone" required> $telephone_val
  <br>
  <br>
  <input type="submit" value="Sign-Up">
</form>	
_END;
}
*/

//version without client validation - to test server side validation
if ($show_signup_form)
{
// show the form that allows users to sign up
// Note we use an HTTP POST request to avoid their password appearing in the URL:
    echo <<<_END
<form action="sign_up.php" method="post">
  Please choose a username,password and email:<br>
  Username: <input type="text" name="username" value="$username" > <b><i>$username_val</b></i>
  <br>
  Password: <input type="password"  name="password" value="$password" > <b><i>$password_val</b></i>
  <br>
  Email: <input type="email" name="email"  value="$email" > $email_val
  <br>
  FirstName: <input type="text" name="firstname" value="$firstname" > <b><i>$firstname_val</b></i>
  <br>
  Surname: <input type="text"  name="surname" value="$surname" > <b><i>$surname_val</b></i>
  <br>
  DOB: <input type="date" name="dateofBirth"  value="$dateofBirth" > $dateofBirth_val
  <br>
  Telephone: <input type="text" name="telephone"  value="$telephone" > $telephone_val
  <br>
  <br>
  <input type="submit" value="Sign-Up">
</form>	
_END;
}

// display our message to the user:
echo $message;

// finish off the HTML for this page:
require_once "footer.php";

?>