<?php

// Things to notice:
// You need to add your Analysis and Design element of the coursework to this script
// There are lots of web-based survey tools out there already.
// It’s a great idea to create trial accounts so that you can research these systems. 
// This will help you to shape your own designs and functionality. 
// Your analysis of competitor sites should follow an approach that you can decide for yourself. 
// Examining each site and evaluating it against a common set of criteria will make it easier 
// for you to draw comparisons between them. 
// You should use client-side code (i.e., HTML5/JavaScript/jQuery) to help you organise and present your information and analysis 
// For example, using tables, bullet point lists, images, hyperlinking to relevant materials, etc.

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
	echo <<<_END
			<style>
				h4 
				{
					font-size:120%
					text-align: center;
				}
				h2
				{
					font-size:80%
					
				}
				ul 
				{
					list-style-type: circle;
				}
				a:hover 
				{
				color: blue;
				}
				
			</style>
_END;

				echo"<a href='https://www.surveymonkey.co.uk/' target='_blank'><h4><b><i><ins>Survey Monkey: </ins></i></b></h4></a>";
				echo"
					<ul>
						<li><h2><ins>Layout/Presentation of Surveys:</ins></h2><p> When creating a new survey, the first thing you will notice is the wide variety of templates that is on offer. This is a very good feature as it covers all the possible types of surveys possible such as Education, Business Management, Customer feedback, Quizzes and much more. 
						This is a great feature as it allows you to have a base idea of what you could do with the available tools or will help you if you didn’t have any idea at all of how to go about making a survey. Once you start up and name the survey, you can go ahead and choose the format which gives you options such as, 
						display all questions at once or display them one at a time and so on. What I liked in particular is the overlying header when creating your survey which clearly explains each part of the survey, including the design->running a preview->collecting results->->analysing results->and presenting results. 
						This makes it very clear and simple to use when trying navigate around. The layout was consistent with the colour scheme, buttons and the way each page was presented.</p></li>
						<li><h2><ins>Ease of use: </h2></ins><p> Survey  monkey delivers a very good level of ease of use, everything is clear and concise. 
						Pages are not filled up with lots of text and explanations of what to do but rather have meaningful headers that do the job well enough.</p></li>
						<li><h2><ins>User account set-up/login process: </h2></ins><p> Very simple and straight forward. Entering your username, password, 
						name and email (for verification) which you then can update easily in your accounts tab.  </p></li>
						<li><h2><ins>Question Types: </h2></ins><p> Many types of questions on offer: multiple choice, dropdown, checkboxes, 
						ranking, sliders, date/time. </p> </li>
						<li><h2><ins>Analysis Tools: </h2></ins><p> Built in tools such as, receiving summaries on questions, data trends (i.e if a specific checkbox was selected more often then another), and finally, individual responses which is qualitative data. 
						There are paid features which will export analysis data to various file formats such as csv and JSON .</p> </li>
					</ul>";
				echo "<img src='surveymonkey1.png'style='width:950px;height:500px'>
					  <br>
					  <img src='surveymonkey3.png'style='width:600px;height:200px'>";
				echo"<a href='https://surveyplanet.com' target='_blank'><h4><b><i><ins>Survey Planet: </ins></i></b></h4></a>";
				echo"
					<ul>
						<li><h2><ins>Layout/Presentation of Surveys:</ins></h2><p> Before signing into survey planet you have useful headers which explain the basic functionalities of the website and what you can expect when creating surveys. 
						For example, the blog header which stood out for me was kind of useful in terms that it explained a lot about the types of surveys, data you can retrieve, what to do with that data, how to send surveys out and so on; 
						but contained too much information that would most likely make a potential user go to a simpler website.
						Once logging in, you can choose to display your current surveys in a grid or list. When creating the surveys, you get a bar on the left hand side with many tabs that are useful and look professional and simple to use.  
						I really liked how you could change the theme of the survey and then run a preview. Everything was straight forward, e.g. the share tab allowed you to share the survey, the preview tab allowed you to preview and so on. </p></li>
						<li><h2><ins>Ease of use: </h2></ins><p> This website felt like it had a simple but professional feel to it. 
						The colour scheme was consistent, and all the tabs, headers and navigations bars were very straight forward and easy to use.</p></li>
						<li><h2><ins>User account set-up/login process: </h2></ins><p>Very simple, you had to enter your email, first name, surname and verify the link they sent to you. 
						Only thing I would improve on is having a username option so that when you come to sign in, you don’t have to keep entering your email.  </p></li>
						<li><h2><ins>Question Types: </h2></ins><p> Upon creating a question, you can choose to set whether you want the question to be required. The question types are all in a drop-down menu and if you press a certain type, 
						e.g. scoring, it will display the relevant data, so in this case it will display a range for the scoring. 
						There is a total of 9 types of questions.</p> </li>
						<li><h2><ins>Analysis Tools: </h2></ins><p> The analysis tool on this is very good. The question part of it shows how many have answered and depending on the question type will display that to you a in a chart with percentages (if applicable). 
						This also includes a participants tab which I really like, it contains the date, email, question number, 
						operating system, browser and although it may be overkill, it could be useful to compare data based on each region/country. 
						You could also delete participants if you wish.</p> </li>
					</ul>";
				echo"<a href='https://www.smartsurvey.co.uk' target='_blank'><h4><b><i><ins>Smart Survey: </ins></i></b></h4></a>";
				echo"
					<ul>
						<li><h2><ins>Layout/Presentation of Surveys:</ins></h2><p> When creating surveys, you have the option of creating ‘pages’ which all have display certain information, e.g. the thank you page. In a given page, you can add as many questions as you’d like. 
						The themes available whilst using the website is very good as it provides you with a lot of themes to work with, for example there is standard, professional ,season, patterns and mobile themes. 
						In the settings tab you could select logos for the survey, change the title and put a password/authentication for your surveys which I really thought was good. 
						Navigation bar at the top was very simple and easy to navigate around, clear tabs with matching icons.</p></li>
						<li><h2><ins>Ease of use: </h2></ins><p> Very nice layout, the colour scheme, tabs and headers were all meaningful and easy to use.</p></li>
						<li><h2><ins>User account set-up/login process: </h2></ins><p> Easy method of signing in. You’re asked to enter your first and second name as well as your email address. 
						However you have to enter your email every time you want to log in, this is quite tedious compared to if you have a username that could be much shorter. You are given an account number with the login process. 
						Updating user profile is very simple.  </p></li>
						<li><h2><ins>Question Types: </h2></ins><p> I like the way they split up the question types into basic and advanced(advanced was part of the pro version), 
						there was a total of 12 basic and 4 advances types of questions.  </p> </li>
						<li><h2><ins>Analysis Tools: </h2></ins><p> It is very easy to send surveys via a generated link. I like how you can adjust the survey status and I feel like that gives greater flexibility to the producer of the survey (can analyse data during specific time frames?).  
						The response tab shows the survey date of creation, shows the total amount of partial/full completions and provides percentages based on the responses but only in a small box. That could be improved on if it were to be a graph of some kind.</p> </li>
					</ul>";
				echo "<img src='smartsurvey1.png'style='width:950px;height:500px'>";
				echo"<br><br>
				<h3><ins>Conclusion of surveys:</ins></h3>
				<p>
				I think that overall, all the surveys I have reviewed are great survey websites with a very good balance of 
				both professionalism and a creative sense about it. I think the number one thing that stood out as being important
				was the fact that all had a very clear navigation menu that allowed everything to 'flow' easy. 
				<br>
				I came to the conclusion that I think Survey Monkey was the website I liked the most because it was able to blend both the professional
				and simple feel to the website effectively, using friendly colours, tabs, bars, headers. It also had a good amount of question types and
				anaylsis tools on offer and felt like the one I would use, if I needed to ever create a survey.
				<br>
				I'd like to implement that ease of use functionality when creating my surveys as I realy think it's an important factor for trying to
				keep the user hooked on to the website. I'd like to implement features such as, being able to modify the title, be able to create 
				additional questions after the user has created them, to be able to organise questoins in the order they like after 
				creating the survey and also to have a welcome and thank you page. 
				Some features that I really liked but I don't think I would have the time or ability at this moment of time is to enable
				the user to implement different themes to their surveys (that changes both the colour/layout). Also another cool feature I found 
				when researching the websites above was, gathering data that tracks the times/location/software/browser and so on when the user 
				was conducting the survey. I think this is a great feature for larger developers so they can then be able to target users and get
				more out of the surveys. 
				</p>
				
				";
	
	
}

// finish off the HTML for this page:
require_once "footer.php";
?>