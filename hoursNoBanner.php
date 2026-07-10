<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php print $site_name; ?> Library opening hours - RMIT University</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<META NAME="Keywords" CONTENT="RMIT University Library" />
<META NAME="DC.Subject" CONTENT="RMIT University Library" />
<meta name="Description" content="<?php print $site_name; ?> Library opening hours for <?php echo date("Y"); ?>." />
<!-- <link rel="stylesheet" type="text/css" href="http://www.lib.rmit.edu.au/banner/fullwidth/css/styles.css"> -->
<link rel="icon" href="https://libapps.s3.amazonaws.com/customers/314/images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="https://libapps.s3.amazonaws.com/customers/314/images/favicon.png" type="image/x-icon" />
<style type="text/css" media="all">

@font-face {
    font-family: Museo300;
    src: url(https://libapps.s3.amazonaws.com/sites/325/include/Museo300-Regular-webfont.woff);
}

/*   RMIT LIBRARY HEADER STYLES   */




#banner {
	background-color: #ffffff;
	font-family: Museo300, Arial, sans-serif;
}
<!--	padding-left: 20px; -->


#appName {
	float: left;
    color: #000054;
    font-family: Museo300, Arial, sans-serif;
}


#contentArea {
	padding: 10px;
	font-family: Arial, sans-serif;
}





	
}

/*  CALENDAR STYLES  */

#hours {
	position:relative;
	float: left;
	width: auto;
	overflow: visible;
}
#hours table { 
	font-family: Arial, sans-serif;
	font-size: 1.1em;
	empty-cells: show;
}
.hours_header{
	text-align:left;
	font-family: Museo300, Arial, sans-serif;
	font-size: 1.4em;
	text-transform: uppercase;
	width:100%;
	float:left;
}	

#dayheader th {
	text-align: left;
    font-size: 1.1em;
    background-color: #A0CEFF;
    padding: 0.5em;
    font-family: Museo300, Arial, sans-serif;
}  
.hoursbox {
	background-color: #ECECE9;
	color: #333;
	padding: 0.2em 0.5em;
}	
#hours td { 
	vertical-align: top;
}
.hoursbox:hover,.hoursbox:active {
	background-color: #ffffff;
	color: #000;
}
.day{
	color: #000054; 
	font-size: 1.2em; 
	padding: 4px;
	font-weight: bold;
}
.ampm{
	font-size: 0.8em;
}
.hours_today {
	background-color: #ffffcc;
	color: #000;
}
.closed {
	background-color: #f1d8f1;
	color: #000;
}

/*	Other Library sites menu styles */	


.libsitenav h2 
		{
		font-size: 1em;
		}
.libsitenav ul
		{
		   	display: block;
			list-style: none;
			padding: 0;
			margin-top: 0;
		}
		
.libsitenav li
		{
			display: block;
			float: left;
			width: auto;
			position: relative;
			font-size: 85%;
			font-weight:bold;
			font-family: Arial,Helvetica,Geneva,sans-serif;
			margin: 2px 4px 0 0;
			padding: 0.5em 0;

		}
		
.libsitenav a:link,
.libsitenav a:visited
		{
//			background-color: #D5ECB0;
background-color: #FAC800;
			color: #000;
			text-decoration: none; 
			padding: 0.5em 1em;
		}
		
.libsitenav a:hover
		{
//			background-color: #AAD75F;
			background-color: #FCE380;
			padding: 0.5em 1em;

		}
		
/*.libsitenav li#active
		{
			background-color: #fff;
			border: 1px solid #ccc;
			color: #000; 
			padding: 0 1em;
		} 
*/
div.clear { clear: both; }


</style>
</head>


<?php 
// Turn off all php error reporting
error_reporting(0);
/* Mike Commented out LaTrobes Connection stuff

// MySQL hostname username and password
$hName = "localhost"; 
$uName = "DataBaseUsername"; 
$pWord = "DataBasePassword";

function dbCall($uName, $pWord, $dbName){
	global $hName;
	// make connection to database 
	MYSQL_CONNECT($hName, $uName, $pWord) OR DIE("<p>Unable to connect to database</p>");
	@mysql_select_db("$dbName") or die( "<p>Unable to select database</p>"); 
}
*/
/* Mike Added RMIT's connection stuff */
include("../protected/phpMySQL/tour.connect");
/* Select the database */
mysql_select_db("rmitlib", $mysql_link);

// Database name/table
/* Mike Changed $dbName from "hours" to rmitlib */
$dbName = "rmitlib";
/* Mike added if statements to select the appropriate table based on site - means one file for all sites */
if (isset($_GET["site"])) {} else {$_GET["site"]="swan";}
$site =$_GET["site"];
$site=htmlspecialchars($site);
if ($site=="swan")
	{
	$dbTable = "swanston_hours";
	$site_name = "Swanston Library";
	$site_message = "";
	}
elseif ($site=="carl")
	{
	$dbTable= "carlton_hours";
	$site_name ="Carlton Library";
	$site_message =	"<div style=\"clear:both\"><p style=\"padding-top:15px;\"><b>Study space open</b> 7 days, 6am-10.30pm. Use your RMIT ID card for access when the Library is unstaffed. <br>
<b>Collection area and Library staff available</b> weekdays 9am-5pm.</p></div>";
	}
elseif ($site=="make")
{
$dbTable= "makerspace_hours";	
	$site_name ="Makerspace";
	$site_message ="";
}
elseif ($site=="bund")
{
$dbTable= "bundoora_hours";	
	$site_name ="Bundoora Library";
	$site_message ="";
/* Iza commented out Bundoora East
 //}
//elseif ($site=="bunde")
//{
//$dbTable= "bundooraeast_hours";
//	$site_name ="Bundoora East Caf&eacute; -";
//	$site_message =	"<b>Library staff will be at the Bundoora East Caf&eacute; to answer queries.</b> "; 
*/
}
elseif ($site=="brun")
{
$dbTable= "brunswick_hours";
	$site_name ="Brunswick Library ";
	$site_message ="<div style=\"clear:both\"><p style=\"padding-top:15px;\">Weekend access to Brunswick campus is via entry gates B and C only (from Dawson St).</p></div>";
}

////////////////////////////////
// For the calendar
// script modified from http://www.plus2net.com/php_tutorial/php_calendar.php
////////////////////////////////

	// Make sure the user input is numeric and not nasty
		
/* Mike had to define m and c was getting undefined index error - this is so Calendar opens on current month*/
if (isset($_GET["m"])) {} else {$_GET["m"]=date("m");}
if (isset($_GET["c"])) {} else {$_GET["c"]=0;}
/*                                                            */

	if (is_numeric($_GET["m"]) && is_numeric($_GET["c"]))
	{
		$prm = $_GET["m"];
 		$chm = $_GET["c"];
	}

	$d= date("d");     // Finds today's day
	$y= date("Y");     // Finds today's year

	if(isset($prm) and $prm > 0){
		$m=$prm+$chm;
	}else{
		$m= date("m");
	}

	$no_of_days = date('t',mktime(0,0,0,$m,1,$y)); // This is to calculate number of days in a month

	$mn=date('F',mktime(0,0,0,$m,1,$y)); // Month is calculated to display at the top of the calendar
	$mql = date('m',mktime(0,0,0,$m,1,$y));
	$yn=date('Y',mktime(0,0,0,$m,1,$y)); // Year is calculated to display at the top of the calendar
	$j= date('w',mktime(0,0,0,$m,1,$y)); // This will calculate the week day of the first day of the month
	
	$first_day = 1; //start day for calendar 0=sunday, 1=Mon...
	$j = ($j + 7 - $first_day) % 7; #adjust for $first_day 
	$adj="";
	for($k=1; $k<=$j; $k++){ // Adjustment of date starting
		$adj .="<td>&nbsp;</td>";
	}

/* Mike Don't think this is needed
//////////////////////////////////
// Connect to database
dbCall($uName, $pWord, $dbName);
*/

$q = "SELECT opening, closing, is_closed, ymd, is_semester, is_exam, notes FROM `$dbTable` WHERE ymd LIKE '$yn-$mql-%'ORDER BY ymd";
/*Mike added $mysql_link for RMIT Connection */
$r = MYSQL_QUERY($q, $mysql_link);

	while($myrow =  mysql_fetch_array($r)){   
	//	list($year, $month, $day) = split("-", $myrow[3]);
		list($year, $month, $day) = preg_split("/-/", $myrow[3]); 
				// Get rid of the leading 0 so that things will match up below
		$day = preg_replace("/^0/", "", $day);
		$date_data[$day] = array ($myrow[0], $myrow[1], $myrow[2], $myrow[3], $myrow[4], $myrow[5], $myrow[6]);
	}
	
	$curM = date("m"); //Find todays month
	$calendar = "<div id=\"hours\">
		<h2 class=\"hours_header\"> ";
	//Print out back/forward links	
	if ($m<$curM){
		$calendar.= "	&#171;&nbsp;";
	}else{	
		$calendar.= "	<a href=\"?m=$m&c=-1&site=$site\" style=\"font-size:0.6em; text-decoration:none;\">&#171; previous</a>";
	}
	$calendar.= " &nbsp; $mn $yn &nbsp; ";
	if ($m>($curM+3)){
		$calendar.= "	&nbsp;&#187;";
	}else{	
		$calendar.= "	<a href=\"?m=$m&c=1&site=$site\" style=\"font-size:0.6em; text-decoration:none;\">next &#187;</a>";
	}

	$calendar.= "</h2>
	
<table>
	<tr id=\"dayheader\">
		<th width=\"100\">Monday</th>
		<th width=\"100\">Tuesday</th>
		<th width=\"100\">Wednesday</th>
		<th width=\"100\">Thursday</th>
		<th width=\"100\">Friday</th>
		<th width=\"100\">Saturday</th>
		<th width=\"100\">Sunday</th>
	</tr>
	<tr>\n";

////// End of the top line showing name of the days of the week//////////

//////// Starting of the days//////////
for($i=1;$i<=$no_of_days;$i++){
$calendar .= $adj . "<td class=\"hoursbox";

	$DayStyle ="";
	//Add color for semester
	if ($date_data[$i][4] == 1) { $DayStyle = "semester"; }
	//Add color for exam
	if ($date_data[$i][5] == 1) { $DayStyle = "exam"; }
	//Add color for closed 
	if ($date_data[$i][2] == 1) { $DayStyle = "closed"; }
	// Add the coloured box for today
	if ($i == $d && $m == date("m")) { $DayStyle = "hours_today"; } 
	$calendar.= " $DayStyle";
	
	$calendar.= "\">
	<div class=\"day";
	//add a style for today
	if ($i == $d && $m == date("m")) {
		$calendar .= " current";
	} 
	$calendar.= "\">$i</div>"; // This will display the date inside the calendar cell

	$notes = "";
	$notes = $date_data[$i][6];
	
	if ($date_data[$i][2] == 1) {
		// Enter the "Closed" Text	                                                 IZA ADDED &nbsp;  - IS IT OK?
		$calendar .= "Closed";
		if ($notes!=""){$calendar.= "<span class=\"ampm\">$notes</span>"; }
	} elseif ($date_data[$i][0] == "&nbsp;") {
		// No data for this day; leave blank
		$calendar .= "<br />";
		if ($notes!=""){$calendar.= "<span class=\"ampm\">$notes</span>"; }
	} else {

		$listing = str_replace(" am", "<span class=\"ampm\">am - </span>", $date_data[$i][0]); 
		$listing = str_replace(" pm", "<span class=\"ampm\">pm - </span>", $listing); 
		
		$listing2 = str_replace(" am", "<span class=\"ampm\">am</span>", $date_data[$i][1]); 
		$listing2 = str_replace(" pm", "<span class=\"ampm\">pm</span>", $listing2); 
	
		// Make sure there's a listing for this day (actually, just a closing hour)
		if ($listing2 != "") {
		$calendar.= $listing . $listing2; // Library's open
		}
		if ($notes!=""){$calendar.= "<br /><span class=\"ampm\">$notes</span>"; }
	}
	
$calendar.= "</td>\n";

$adj="";
$j++;
	if($j==7){$calendar.= "</tr>\n<tr>";
$j=0;}

}
$calendar.= "</tr>\n
</table>\n
<p><img src=\"images/hours-legend.png\" alt=\"\" style=\"margin-top:0.5em;\" /></p>
</div>";

// Uncomment the lines below to see an array of the values returned from the DB
/* print "<pre>";
print_r($date_data);
print "</pre>"; 
 */

?>
<!-- Mike comment out banner for Iframe 
<div id="headerArea">
				<div id="globalBar">
					<div id="logo">
							<a href="https://www.rmit.edu.au"><img border="0" alt="RMIT University" src="https://libapps.s3.amazonaws.com/customers/314/images/RMIT-on-navy.jpg"></a>
					</div>
						<br style="clear: both">
				</div> 
				

				<div id="banner">

	
						<h3 id="appName"><?php print $site_name; ?>  opening hours </h3>			
						<br style="clear: both;">			

					<div id="breadcrumbs" role="navigation">			
						<ul>
						<li><a href="http://www.rmit.edu.au/library">Library home</a></li>
						<li><a href="https://www.rmit.edu.au/library/about-and-contacts/hours-and-locations">Hours, contacts and locations</a></li>
						</ul>
					</div>	
	
				</div>
</div>-->
<div id="banner">
	
<h3 id="appName"><?php print $site_name; ?> </h3>			
<br style="clear: both;">	
</div>
<span class="libsitenav">
<ul>
<li><a href="hoursNoBanner.php?site=brun">Brunswick Library</a></li>
<li><a href="hoursNoBanner.php?site=bund">Bundoora Library</a></li>
<li><a href="hoursNoBanner.php?site=carl">Carlton Library</a></li>
<li><a href="hoursNoBanner.php?site=swan">Swanston Library</a></li>
<li><a href="hoursNoBanner.php?site=make">Makerspace</a></li>
</ul>
</span>
<!-- CONTENT START -->
<div id="contentArea">	

<span style="display: block;">
<div class="notice">
<?php print $site_message; ?>
<!-- <p>Opening hours are subject to change.</p>-->
</div> 

<div style="clear:both;"></div>
<?php error_reporting(0); print $calendar; ?>
<div class="clear"/>
<!--
<hr />
<span class="libsitenav">
<h2>Opening hours for all Library sites:</h2>
<ul>
<li><a href="hoursNoBanner.php?site=brun">Brunswick Library</a></li>
<li><a href="hoursNoBanner.php?site=bund">Bundoora Library</a></li>
<li><a href="hoursNoBanner.php?site=carl">Carlton Library</a></li>
<li><a href="hoursNoBanner.php?site=swan">Swanston Library</a></li>
<li><a href="hoursNoBanner.php?site=make">Makerspace</a></li>
</ul>
</span>
-->

						
						<!-- CONTENT END -->
</span>
<div style="clear:both;">
</div>	
			<div class="push"></div>	
			
		</div>

<!--		<div id="footer">
		
			<div id="footerContent">
			
				<p>Copyright &copy; 2018 RMIT University 
				<a href="http://www.rmit.edu.au/utilities/disclaimer" style="margin-left: 3px;">Disclaimer</a>
				<a href="http://www.rmit.edu.au/utilities/privacy">Privacy</a>
				<a href="http://www.rmit.edu.au/utilities/accessibility">Accessibility</a>
				<a href="http://www.rmit.edu.au/utilities/website-feedback">Website feedback</a><br> 
				ABN 49 781 030 034
				</p>
				
			</div>
		
		</div>
-->
	
<!-- RMIT CONNECTED TEMPLATE FOOTER END -->
