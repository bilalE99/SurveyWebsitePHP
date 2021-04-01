<?php
// Things to notice:
// This is an empty page where you can provide a simple overview and description of your site
// Consider it the 'welcome' page for your survey web site

// execute the header script:
require_once "header.php";

echo "Users are able to create and alter accounts using the related tabs.<br>
In the my account script you can update your account there. 
You can take a practice survey and that will save the score in a database.<br>
Admins can alter/create/delete user information as well as view survey data and the scores of the users.<br>";

// finish of the HTML for this page:
require_once "footer.php";

?>