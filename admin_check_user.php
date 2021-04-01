<?php
// execute the header script:
require_once "header.php";


$username = "";
$username_val = "";

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


elseif ($_SESSION['username'] == "admin")
{
	// only display the page content if this is the admin account (all other users get a "you don't have permission..." message):
	if (isset($_POST['username']))
	{
		// connect directly to our database (notice 4th argument) we need the connection for sanitisation:
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		
		// if the connection fails, we need to know, so allow this exit:
		if (!$connection)
		{
			die("Connection failed: " . $mysqli_connect_error);
		}	
		
		$username = sanitise($_POST['username'], $connection);
		$username_val = validateString($username, 1, 16);
		
		$errors = $username_val;
		
		
		// check that all the validation tests passed before going to the database:
		if ($errors == "")
		{
			 // check for a row in our users table with a matching username and password:
			$query = "SELECT * FROM users WHERE username='$username'";

			// this query can return data:
			$result = mysqli_query($connection, $query);

			// how many rows came back? (can only be 1 or 0 because usernames are the primary key in our table):
			$n = mysqli_num_rows($result);
				
			// if there was a match then set the session variables and display a success message:
			if ($n > 0)
			{
				//copy their username into the session data for use by our other scripts:
				$_SESSION['updateUser'] = $username;
				echo "<br>User valid, <a href='admin_update_user.php'>UPDATE</a> details here!<br><br>";
			}

			else
			{
				$message = "<br>User doesn't exist<br>";
				$show_account_form = true;
			}
			
		}
		// we're finished with the database, close the connection:
		mysqli_close($connection);
	}
else
{
	// just a normal visit to the page, show the signup form:
	$show_account_form = true;
		
}

}
else
{
	echo "You don't have permission to view this page...<br>";
}
	

if ($show_account_form)
{
echo <<<_END
    <form action="admin_check_user.php" method="post">
		Enter Username that you would like to update:<br><br>
		Username: <input type="text" name="username" maxlength="16" value="$username" required> $username_val
		<br>
		<br>
		<input type="submit" value="Submit">
    </form>	
_END;
}

// display our message to the user:
echo $message;

// finish of the HTML for this page:
require_once "footer.php";
?>