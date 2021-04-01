<?php
// execute the header script:
require_once "header.php";

// default values we show in the form:
$username = "";

// strings to hold any validation error messages:
$username_val = "";


// should we show the form:
$show_form = false;
// message to output to user:
$message = "";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
	
}

// the user must be signed-in, show them suitable page content
elseif ($_SESSION['username'] == "admin")
{
	// only display the page content if this is the admin account (all other users get a "you don't have permission..." message):
	 if(isset($_POST['username']))
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
		
		
		// concatenate all the validation results together ($errors will only be empty if ALL the data is valid):
		$errors = $username_val;
		
		// check that all the validation tests passed before going to the database:
		if ($errors == "")
		{
			// check for a row in our users table with a matching username
			$query = "SELECT * FROM users WHERE username='$username'";

			// this query can return data:
			$result = mysqli_query($connection, $query);

			// how many rows came back? (can only be 1 or 0 because usernames are the primary key in our table):
			$n = mysqli_num_rows($result);
				
			// if there was a match then delete user:
			if ($n > 0)
			{
				$query = "DELETE FROM users WHERE username='$username'";

				if (mysqli_query($connection, $query))
				{
					echo "User deleted successfully";
				} 
			}
			else 
			{
				echo "Couldn't find requuested user: " . mysqli_error($connection);
				$show_form = true;
			}
			
		}
		else
		{
			// validation failed, show the form again with guidance:
			$show_form = true;
		}
		
		// we're finished with the database, close the connection:
		mysqli_close($connection);

	}
	else 
	{
		$show_form = true;
	}
	
}
else
	{
			echo "You don't have permission to view this page...<br>";
	}



if ($show_form)
{
// show the form that allows admin to enter user to delete
echo <<<_END
<form action="admin_delete_user.php" method="post">
  Please enter username:<br>
  Username: <input type="text" name="username" maxlength="16" value="$username" required> $username_val
  <br>
  <input type="submit" value="Submit">
</form>	
_END;
}

// display our message to the user:
echo $message;

// finish off the HTML for this page:
require_once "footer.php";
?>