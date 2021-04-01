<?php

// Things to note:
// This code is designed to demonstrate the use of SQL and HTML sanitisation (cleaning)
// It gives you a chance to enter some SQL or HTML code in a form and see how it is processed
// Using either the mysqli_real_escape_string() or htmlentities() functions in PHP
// You can also experiment with the one-way hash function named sha1() - notice it gives a predictable output

// retrieve the DB credentials
require_once "credentials.php";

$show_sql_out = false;
$show_html_out = false;
$show_crypt_out = false;
$clean_SQL="";
$clean_HTML="";
$crypt="";

echo <<< _END

<!DOCTYPE html>
<title>Sanitise Examples</title>
<head><h2>Santisation and Hashing Examples on the Server-Side</h2></head>
<body>
<a href="index.php">Back to PD4</a><br><br>
_END;


// Check to see if some SQL has been entered in the form and that it is not an empty string
// The mysqli_real_escape_string() function requires two parameters: a DB connection AND the sql to be cleaned
if (isset($_POST['sql']) && $_POST['sql']!="") 
{

    // CREATE connection to the DB to be used
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        // if the connection fails, we need to know, so allow this exit:
        if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }

    // CLEAN THE SQL THAT HAS BEEN ENTERED
    $clean_SQL=mysqli_real_escape_string($connection, $_POST['sql']);

    // we're finished with the database, close the connection:
    mysqli_close($connection);

    // SHOW THE CLEANED SQL STRING
    $show_sql_out=true;
}



// Check to see if some HTML has been entered in the form and that it is not an empty string
elseif (isset($_POST['html']) && $_POST['html']!="") {

    $clean_HTML=htmlentities($_POST['html']);
    $show_html_out=true;

}


// Check to see if some HTML has been entered in the form and that it is not an empty string
elseif (isset($_POST['hashing']) && $_POST['hashing']!="") {

    $clean_string=htmlentities($_POST['hashing']);
    $crypt=sha1($_POST['hashing']);
    $show_crypt_out=true;

}

// show a form where the user can enter some SQL to see what the function does to it
echo <<<_END
    <form action="sanitise.php" method="post">
    Enter some SQL to see what happens when <code>mysqli_real_escape_string()</code> is perfomed:<br>
    <input type="text" size="100" name="sql"><br>
    <input type="submit" value="Submit">
    </form>
    <br>
_END;

// display the results of the processing, if we have them
if ($show_sql_out) {
    echo "The sanitised SQL looks like this: <br><code>$clean_SQL</code><br><br>";
}


// show a form where the user can enter some SQL to see what the function does to it
echo <<<_END
    <form action="sanitise.php" method="post">
    Enter some HTML to see what happens when <code>htmlentities()</code> is perfomed:<br>
    <input type="text" size="100" name="html"><br>
    <input type="submit" value="Submit">
    </form>
    <br>
_END;

// display the results of the processing, if we have them
if ($show_html_out) {
    echo "The sanitised HTML looks like this: <br> <code>$clean_HTML</code><br><br>";
}


// show a form where the user can enter some text to see what the SHA1 function does to it
echo <<<_END
    <form action="sanitise.php" method="post">
    Enter some string data to see what happens when <code>sha1()</code> is perfomed:<br>
    <input type="text" size="100" name="hashing"><br>
    <input type="submit" value="Submit">
    </form>
    <br>
_END;

// display the results of the processing, if we have them
if ($show_crypt_out) {
    echo "The hashed string looks like this: <br> <code>$crypt</code><br><br>";
}


echo "</body></html>";

?>