<?php

// Things to notice:
// This is the page where each user can MANAGE their surveys
// As a suggestion, you may wish to consider using this page to LIST the surveys they have created
// Listing the available surveys for each user will probably involve accessing the contents of another TABLE in your database
// Give users options such as to CREATE a new survey, EDIT a survey, ANALYSE a survey, or DELETE a survey, might be a nice idea
// You will probably want to make some additional PHP scripts that let your users CREATE and EDIT surveys and the questions they contain
// REMEMBER: Your admin will want a slightly different view of this page so they can MANAGE all of the users' surveys

// execute the header script:
require_once "header.php";

// should we show the form?:
$show_form = false;

$correct="";
$choice="";

$q1 = "";
$q3 = "";
$q5 = "";

$q1_val="";
$q3_val="";
$q5_val="";


$errors = "";

$counter = 0;



// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}

else
{
	$show_form = true;
	
	// read their username from the session:
	$username = $_SESSION['username'];
	
	
	if(isset($_POST['q1']))
	{	
		// connect directly to our database (notice 4th argument) we need the connection for sanitisation:
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		
		// if the connection fails, we need to know, so allow this exit:
		if (!$connection)
		{
			die("Connection failed: " . $mysqli_connect_error);
		}	
		
		
		
		$q1 = $_POST['q1'];

		
		$q1 = sanitise($_POST['q1'], $connection);
		
		$q1_val = validateInt($q1, 150, 250);

		
		$errors = $q1_val;
		
		// check that all the validation tests passed before going to the database:
		if ($errors == "")
		{

			// check to see if the answer is right:
			$query = "SELECT BHP FROM data WHERE BHP='$q1'";
			
			$result = mysqli_query($connection, $query);
			
			// how many rows came back?:
			$n = mysqli_num_rows($result);
			// if there was a match then UPDATE their score data
			if ($n > 0)
			{
				$counter=$counter + 1;
				// we need an UPDATE:
				$query = "UPDATE scores SET result='$counter'	WHERE username='$username'";
				$result = mysqli_query($connection, $query);
				echo"Score updated<br>";
				$show_form = true;			
				
			}
			else 
			{
				// show the form:
				$show_form = true;
				echo"Check answer again!<br>";
			}
		}
		else
		{
			// validation failed, show the form again with guidance:
			$show_form = true;
			$message = "Error with input values<br>";
		}
		// we're finished with the database, close the connection:
		mysqli_close($connection);
	}
	
	if(isset($_POST['q3']))
	{	
		// connect directly to our database (notice 4th argument) we need the connection for sanitisation:
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		
		// if the connection fails, we need to know, so allow this exit:
		if (!$connection)
		{
			die("Connection failed: " . $mysqli_connect_error);
		}	

		$q3 = $_POST['q3'];
		
		if ($errors == "")
		{

			// check to see if the answer is right:
			$query = "SELECT fuelType FROM data WHERE fuelType='$q3'";
			
			$result = mysqli_query($connection, $query);
			
			// how many rows came back?:
			$n = mysqli_num_rows($result);
			// if there was a match then UPDATE their score data
			if ($n > 0)
			{
				$counter=$counter + 1;
				// we need an UPDATE:
				$query = "UPDATE scores SET result='$counter'	WHERE username='$username'";
				$result = mysqli_query($connection, $query);
				echo"Score updated<br>";
				$show_form = true;			
				
			}
			else 
			{
				// show the form:
				$show_form = true;
				echo"Check answer again!<br>";
			}
		}
		else
		{
			// validation failed, show the form again with guidance:
			$show_form = true;
			$message = "Error with input values<br>";
		}
		// we're finished with the database, close the connection:
		mysqli_close($connection);
	}
	
	if(isset($_POST['q5']))
	{	
		// connect directly to our database (notice 4th argument) we need the connection for sanitisation:
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		
		// if the connection fails, we need to know, so allow this exit:
		if (!$connection)
		{
			die("Connection failed: " . $mysqli_connect_error);
		}	
		
		
		
		$q5 = $_POST['q5'];

		
		$q5 = sanitise($_POST['q5'], $connection);
		
		$q5_val = validateInt($q1, 150, 250);

		
		$errors = $q5_val;
		
		// check that all the validation tests passed before going to the database:
		if ($errors == "")
		{

			// check to see if the answer is right:
			$query = "SELECT BHP FROM data WHERE BHP='$q5'";
			
			$result = mysqli_query($connection, $query);
			
			// how many rows came back?:
			$n = mysqli_num_rows($result);
			// if there was a match then UPDATE their score data
			if ($n > 0)
			{
				$counter=$counter + 1;
				// we need an UPDATE:
				$query = "UPDATE scores SET result='$counter'	WHERE username='$username'";
				$result = mysqli_query($connection, $query);
				echo"Score updated<br>";
				$show_form = true;			
				
			}
			else 
			{
				// show the form:
				$show_form = true;
				echo"Check answer again!<br>";
			}
		}
		else
		{
			// validation failed, show the form again with guidance:
			$show_form = true;
			$message = "Error with input values<br>";
		}
		
		// we're finished with the database, close the connection:
		mysqli_close($connection);
	}
	
	
	
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
		$query = "SELECT * FROM data";
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
				}
					
				tr:nth-child(even){background-color: #f2f2f2}
					
				th 
				{
					background-color: #6495ed;
					color: black;
				}
					
					
			</style>
_END;
				echo "<table cellpadding='2' cellspacing='2'>";
				echo "<tr><th>Name</th></th><th>Manufacturer</th><th>Model</th><th>Fuel</th><th>BHP</th><th>Engine Size</th><th>Plate</th></tr>";
				// loop over all rows, adding them into the table:
				for ($i=0; $i<$n; $i++)
				{
					// fetch one row as an associative array (elements named after columns):
					$row = mysqli_fetch_assoc($result);
					// add it as a row in our table:
					echo "<tr>";
					echo "<td>{$row['name']}</td><td>{$row['manufacturer']}</td><td>{$row['model']}</td><td>{$row['fuelType']}</td><td>{$row['BHP']}</td><td>{$row['engineSize']}</td><td>{$row['plate']}</td>";
					echo "</tr>";
				}
				echo "</table><br>";
					

		}
		// display all users info:
		$query1 = "SELECT * FROM scores";

		// this query can return data ($result is an identifier):
		$result1 = mysqli_query($connection, $query1);

		// how many rows of data come back?
		$n1 = mysqli_num_rows($result1);

		// there should only be one row
		if ($n1>0)  
		{
				// just a bit of CSS to make the table clearly visible:
				echo <<<_END
			<style>
				table, th, td {border: 2px solid black; align: center;}
						
				th, td 
				{
					text-align: left;
					padding: 10px;
				}
					
				tr:nth-child(even){background-color: #f2f2f2}
					
				th 
				{
					background-color: #6495ed;
					color: black;
				}
					
					
			</style>
_END;

				echo "<table cellpadding='2' cellspacing='2'>";
				echo "<tr><th>Username</th></th><th>Score for survey</th></tr>";
				// loop over all rows, adding them into the table:
				for ($i=0; $i<$n1; $i++)
				{
					// fetch one row as an associative array (elements named after columns):
					$row1 = mysqli_fetch_assoc($result1);
					// add it as a row in our table:
					echo "<tr>";
					echo "<td>{$row1['username']}</td><td>{$row1['result']}</td>";
					echo "</tr>";
				}
				echo "</table><br>";
					

		}

	}
}

if($show_form)
{
echo <<<_END
  <form action="surveys_manage.php" method="post">
	  <br>
	How much Horse power does a stock BMW 3 series have:<br> 
	<input type="number" name="q1" value="$q1" min="150" max="250"  >
	<br>
	<br>
	
	<label>What size is the engine of a RS6 Audi Sport model:</label>
	<ul>
		<li><input name="choice" type="radio" value="$choice" />3.2L</li>
		<li><input name="choice1" type="radio" value="$choice" />2.6L</li>
		<li><input name="choice2" type="radio" value="$choice" />4.5</li>
		<li><input name="choice3" type="radio" value="$choice" />2.0</li>
	</ul>
	<br>
	
	
	<label>What fuel Type is the Golf R: </label>
	<select>
		<option name="q3" value="$q3">Petrol</option>
		<option name="q3" value="$q3">Diesel</option>
	</select>
	<br>

	<br>
	<label>What year was the Range Rover Evoque released: </label>
	<ul>
		<li><input name="choice1" type="radio" value="$correct" />08</li>
		<li><input name="choice1" type="radio" value="$correct" />15</li>
		<li><input name="choice1" type="radio" value="$correct" />05</li>
		<li><input name="choice1" type="radio" value="$correct" />13</li>
	</ul>
	<br>
	
	How much Horse power does a A Class AMG Mercedes have:<br> 
	<input type="number" name="q5" value="$q5" min="170" max="300" >
	<br>
	<br>
	<input type="submit" value="Submit" />
  </form>
_END;
}

// finish off the HTML for this page:
require_once "footer.php";

?>

