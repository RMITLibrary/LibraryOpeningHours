<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>RMIT University Library - Today's opening hours </title>

<style>
* {
  box-sizing: border-box;
}
.colwrapper{
  
width:700px;
margin:auto;
}
.hours_columns{
width: 33.33%;
float: left;
font-family: Arial, sans-serif;
font-size: 16px;
padding: 0 1.3em 0 0;
text-align: center;
}
.hours_columns p{
  line-height: 24px;
  padding-bottom: 0;
  width: auto;
  font-color:#333333;
  margin-bottom: 0;
}
@media screen and (max-width: 700px) {
.hours_columns {
width:100%;
}
.colwrapper{
width:100%;
}

}
.colwrapper:after {
  content: "";
  display: table;
  clear: both;
}
.hours_columns a{
text-decoration:underline;
color:#333333;
}
</style>
</head>
<body>
<?php 
date_default_timezone_set('Australia/Melbourne');
// print("<h2 style=\"color: #000053; font-family: Museo300,sans-serif; font-size: 1.3em;\">Today's opening hours</h2>");

// Turn off all php error reporting
error_reporting(0);

/* Mike Added RMIT's connection stuff */
include("../protected/phpMySQL/tour.connect");
/* Select the database */
mysql_select_db("rmitlib", $mysql_link);
/* Get today's date */
	$d= date("d");     // Finds today's day
	$m= date("m");	   // Finds today's month
	$y= date("Y");     // Finds today's year

/* Assign table names of sites to an array so that they can be looped through */
	$dbTable[0] = "asklibrary_hours";
	$dbTable[1] = "brunswick_hours";

/* Use a loop to query the database for each site */
print("<div class=\"colwrapper\"><div class=\"hours_columns\">");
for($l=0; $l<=2; $l++)
{
 $q = "SELECT opening, closing, is_closed, ymd, is_semester, is_exam, notes FROM `$dbTable[$l]` WHERE ymd = '$y-$m-$d'";
$r = MYSQL_QUERY($q, $mysql_link);

while($row =  mysql_fetch_array($r))
	{  
/*	 if ($l==0){$site="<strong><a target=\"_parent\" href=\"https://www.rmit.edu.au/library/help/ask-the-library\">Ask the Library</a></strong> ";} */
	 if ($l==0){$site="<strong>Ask the Library</strong> ";}
/*	elseif ($l==1){$site="<strong><a target=\"_parent\" href=\"https://www.rmit.edu.au/library/about-and-contacts/hours-and-locations?activeTab=Brunswick\">Brunswick</a></strong> ";} */
	elseif ($l==1){$site="<strong>Brunswick</strong> ";}
	 print("<p>$site<br>");
	// Check if the Library is closed
	if($row[2]==1)
		{print("CLOSED");}
	else
	{print("$row[0]  - $row[1]</p>");
	}
}
}
print("</div>");

    $dbTable[0] = "bundoora_hours";	
	$dbTable[1] = "carlton_hours";


/* Use a loop to query the database for each site */
print("<div  class=\"hours_columns\">");
for($l=0; $l<=2; $l++)
{
 $q = "SELECT opening, closing, is_closed, ymd, is_semester, is_exam, notes FROM `$dbTable[$l]` WHERE ymd = '$y-$m-$d'";
$r = MYSQL_QUERY($q, $mysql_link);

while($row =  mysql_fetch_array($r))
	{  
/*	if ($l==0){$site="<strong><a target=\"_parent\" href=\"https://www.rmit.edu.au/library/about-and-contacts/hours-and-locations/bundoora-library\">Bundoora</a></strong> ";} */
	if ($l==0){$site="<strong>Bundoora</strong> ";}
/*	 elseif ($l==1){$site="<strong><a target=\"_parent\" href=\"https://www.rmit.edu.au/library/about-and-contacts/hours-and-locations/carlton-library\">Carlton</a></strong> ";} */
	elseif ($l==1){$site="<strong>Carlton</strong> ";}
	 print("<p>$site<br>");
	// Check if the Library is closed
	if($row[2]==1)
		{print("CLOSED");}
	elseif ($row[2]==2) 
		{print("Study space");}
	else
	{print("$row[0]  - $row[1]</p>");
	}
}
}
print("</div>");

$dbTable[0] = "swanston_hours";
$dbTable[1] = "makerspace_hours";

/* Use a loop to query the database for each site */
print("<div class=\"hours_columns\">");
for($l=0; $l<=2; $l++)
{
 $q = "SELECT opening, closing, is_closed, ymd, is_semester, is_exam, notes FROM `$dbTable[$l]` WHERE ymd = '$y-$m-$d'";
$r = MYSQL_QUERY($q, $mysql_link);

while($row =  mysql_fetch_array($r))
	{  
/*	if ($l==0){$site="<strong><a target=\"_parent\" href=\"https://www.rmit.edu.au/library/about-and-contacts/hours-and-locations/swanston-library\">Swanston</a></strong> ";} */
	if ($l==0){$site="<strong>Swanston</strong> ";}
/*	 elseif ($l==1){$site="<strong><a target=\"_parent\" href=\"https://www.rmit.edu.au/library/about-and-contacts/hours-and-locations/makerspace\">Makerspace</a></strong> ";} */
	elseif ($l==1){$site="<strong>Makerspace</strong> ";}
	 print("<p>$site<br>");
	// Check if the Library is closed
	if($row[2]==1)
		{print("CLOSED");}
	else
	{print("$row[0]  - $row[1]</p>");
	}
}
}
print("</div></div>");	  

?>

</body>
</html>






