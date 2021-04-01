<?php

// Things to notice:
// You need to add code to this script to implement the admin functions and features
// Notice that the code not only checks whether the user is logged in, but also whether they are the admin, before it displays the page content
// When an admin user is verified, you can implement all the admin tools functionality from this script, or distribute them over multiple pages - your choice

// execute the header script:
require_once "header.php";

// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}

// the user must be signed-in, show them suitable page content
else
{
	// only display the page content if this is the admin account (all other users get a "you don't have permission..." message):
	if ($_SESSION['username'] == "admin")
	{
		
		
		// connect directly to our database (notice 4th argument):
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

		// if the connection fails, we need to know, so allow this exit:
		if (!$connection)
		{
			die("Connection failed: " . $mysqli_connect_error);
		}
		
		// display all users info:
		$query = "SELECT * FROM users";

		// this query can return data ($result is an identifier):
		$result = mysqli_query($connection, $query);

		// how many rows of data come back?
		$n = mysqli_num_rows($result);

		// there should only be one row
		if ($n>0)  
		{
				// just a bit of CSS to make the table clearly visible:
				echo <<<_END
			<style>
				table, th, td {border: 2px solid black; align: center;}
					
					th, td 
				{
					text-align: left;
					padding: 10px;
					border-bottom: 1px solid #ddd;
				}
				
			   tr:hover {background-color: #f5f5f5;}
				td{vertical-align: bottom;}
				th 
				{
					background-color: #ff6347;
					color: black;
				}
				
				
			</style>
_END;
				echo "<table cellpadding='2' cellspacing='2'>";
				echo "<tr><th>Firstname</th></th><th>Surname</th><th>Username</th><th>Password</th><th>Email</th><th>DOB</th><th>Telephone</th></tr>";
				// loop over all rows, adding them into the table:
				for ($i=0; $i<$n; $i++)
				{
					// fetch one row as an associative array (elements named after columns):
					$row = mysqli_fetch_assoc($result);
					// add it as a row in our table:
					echo "<tr>";
					echo "<td>{$row['firstname']}</td><td>{$row['surname']}</td><td>{$row['username']}</td><td>{$row['password']}</td><td>{$row['email']}</td><td>{$row['dateOfBirth']}</td><td>{$row['telephone']}</td>";
					echo "</tr>";
				}
				echo "</table>";
			

		}

		else
		{
			echo "You don't have permission to view this page...<br>";
		}   

	
		echo "<br>Create a <a href='admin_create_user.php'>NEW USER</a> here!<br>";
		echo "<br>Delete an <a href='admin_delete_user.php'>EXISTING USER</a> here!<br>";
		echo "<br>Update a <a href='admin_check_user.php'>USER ACCOUNT</a> here!<br>";
	
	}
}

// finish off the HTML for this page:
require_once "footer.php";
?>