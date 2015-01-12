<?php
if(!isset($_POST['form_status']) and !isset($_GET['1']) and !isset($_GET['2']) and !isset($_GET['3']) and !isset($_GET['4']) and !isset($_GET['order']) and !isset($_GET['head']))
	{
		header ('Location: NHLOutput.php');
		exit ();
	}	


$db=mysql_connect("localhost","root") or die('Not connected : ' . mysql_error());
	mysql_select_db("nhl",$db) or die (mysql_error());

session_start();

if(isset($_POST['submit1']))
{
	$search=$_POST['top10'];
	$searchcriteria=array();
	
	if (isset($_POST['checkbox2']))
		{
		foreach ($_POST['checkbox2'] as $array)
			{ $searchcriteria[]=$array;}
		}	
	
	if ($search=="x")
		{ $_SESSION['e9']="Please select an option.<br>" ;
		  header ( "Location: NHLOutput.php");
		exit(); }
	echo "<h1>Top<img src='http://profile.ak.fbcdn.net/hprofile-ak-ash4/276485_187703334632592_6717793_q.jpg'> Players For ".ucfirst($search)."</h1>";	
	echo "<table border='3' bordercolor='navy'>";
	$SQL="SELECT * FROM stats WHERE ".$search." ORDER BY ".$search." DESC LIMIT 0,10 "; 	
	echo "<tr><td align='center'><b>Name</b></td><td align='center'><b>".ucfirst($search)."</b></td>";
	foreach ($searchcriteria as $head)
		{
			echo "<td align='center'><b>".ucfirst($head)."</b></td>";
		}	
	echo "</tr>";
	$result=mysql_query($SQL) or die(mysql_error());
	$num_results=mysql_num_rows($result);
	for ($i=0;$i<$num_results;$i++)
		{	 
			$row=mysql_fetch_array($result);
			echo "<tr><td>".$row["name"]."</td>";
			echo "<td align='center'>".$row[$search]."</td>";
			for ($j=0;$j<count($searchcriteria);$j++)
			{ echo "<td align='center'>".$row[$searchcriteria[$j]]."</td>";}
	
		}
	echo "</table>";
	echo "<br><a href='NHLOutput.php'>Return to Home</a>";
	exit();	
}
		
if (isset($_SESSION['order1']))
	{$order=$_SESSION['order1'];}	
if (isset($_SESSION['orderby1']))
	{$orderby=$_SESSION['orderby1'];}	
	

if (isset($_SESSION['sql1']))
		{$SQL1=$_SESSION['sql1'];
		$searchcriteria=$_SESSION['array[]'];}
	if (isset($_SESSION['start']) and isset($_SESSION['max']))
		{$start=$_SESSION['start'];
		$maxrow=$_SESSION['max'];
		$last=$_SESSION['last'];
		if (isset($_GET['2']))
			{$start=$start+$maxrow;}
		if (isset($_GET['1']))
			{$start=$start-$maxrow;}
		if (isset($_GET['3']))
			{$start=0;}	
		if (isset($_GET['4']))
			{$start=($last-1)*($maxrow);}	
		}
		
if (isset($_GET['order']))
	{
		if ($_GET['order']=="ASC")
		{ $order="DESC";}
		if ($_GET['order']=="DESC")
		{ $order="ASC";}
	}
if (isset($_GET['head']))
	{
		$start=0;
		$maxrow=$_SESSION['max'];
		$orderby=$_GET['head'];
	}		
			
		
if (isset($_POST['submit']))
{	
	$start=0;
	$maxrow=$_POST['maxrow'];
	$order="ASC";
	$orderby="name";
	$confirm="true";
		
	if ($maxrow<1)
			{$_SESSION['e1']="Max row value must be greater than 0. <br>";
			$confirm="false";}
	if (ctype_alpha($maxrow))
			{$_SESSION['e1']="Max row value must be numerical. <br>";
			$confirm="false";}		
	if (!isset($_POST['team']))
			{$_SESSION['e2']="Please select at least one team."; 
			$confirm="false";}	
	if (!isset($_POST['position']))
			{$_SESSION['e3']="Please select at least one position."; 
			$confirm="false";}	
	if (!isset($_POST['shoots']))
			{$_SESSION['e4']="Please select at least one shooting option."; 
			 $confirm="false";}	
	if (!isset($_POST['country']))
			{$_SESSION['e5']="Please select at least one country."; 
			 $confirm="false";}	
	if ($confirm=="false")
			{ header ("Location: NHLOutput.php");
			exit();}

	$searchcriteria=array();
	if (isset($_POST['checkbox']))
		{
		foreach ($_POST['checkbox'] as $array)
			{ $searchcriteria[]=$array;}
		}

	$team=array();
		if (isset($_POST['team']))
			{
			foreach ($_POST['team'] as $array)
				{
				$team[]=$array;
				}
			$team2=" team in (";	
			for ($a=0;$a<count($team);$a++)
				{ if ($a!=(count($team)-1))
					{ $team1="'".$team[$a]."',";}
				else
					{ $team1="'".$team[$a]."'";}
				$team2=$team2.$team1;
				}
			$team2=$team2.")";
			}
	$position=array();
		if (isset($_POST['position']))
			{
			foreach ($_POST['position'] as $array)
				{
				$position[]=$array;
				}
			$position2=" position in (";	
			for ($b=0;$b<count($position);$b++)
				{ if ($b!=(count($position)-1))
					{ $position1="'".$position[$b]."',";}
				else
					{ $position1="'".$position[$b]."'";}
				$position2=$position2.$position1;
				}
			$position2=$position2.")";
			}	
	$shoots=array();
		if (isset($_POST['shoots']))
			{
			foreach ($_POST['shoots'] as $array)
				{
				$shoots[]=$array;
				}
			$shoots2=" shoots in (";	
			for ($c=0;$c<count($shoots);$c++)
				{ if ($c!=(count($shoots)-1))
					{ $shoots1="'".$shoots[$c]."',";}
				else
					{ $shoots1="'".$shoots[$c]."'";}
				$shoots2=$shoots2.$shoots1;
				}
			$shoots2=$shoots2.")";
			}		
	$country=array();
		if (isset($_POST['country']))
			{
			foreach ($_POST['country'] as $array)
				{
				$country[]=$array;
				}
			$country2=" country in (";	
			for ($c=0;$c<count($country);$c++)
				{ if ($c!=(count($country)-1))
					{ $country1="'".$country[$c]."',";}
				else
					{ $country1="'".$country[$c]."'";}
				$country2=$country2.$country1;
				}
			$country2=$country2.")";
			}		
	
	$jerseymin=$_POST['jersey_num'];		
	$jerseymax=$_POST['jersey_num1'];	
	$gamesmin=$_POST['games_played'];		
	$gamesmax=$_POST['games_played1'];	
	$pointsmin=$_POST['points'];	
	$pointsmax=$_POST['points1'];	
	$goalsmin=$_POST['goals'];	
	$goalsmax=$_POST['goals1'];
	$assistsmin=$_POST['assists'];	
	$assistsmax=$_POST['assists1'];
	$salarymin=$_POST['salary'];	
	$salarymax=$_POST['salary1'];
	
	if (trim($jerseymin)=="" or trim($jerseymax)==""
		or trim($gamesmin)=="" or trim($gamesmax)==""
		or trim($pointsmin)=="" or trim($pointsmax)==""
		or trim($goalsmin)=="" or trim($goalsmax)==""
		or trim($assistsmin)=="" or trim($assistsmax)==""
		or trim($salarymin)=="" or trim($salarymax)==" ")
			{$_SESSION['e10']="Min and max fields must be filled in. <br>";
			header ("Location: NHLOutput.php");
			exit();}
	
	if ($jerseymin<0 or $jerseymax<0 
		or $gamesmin<0 or $gamesmax<0
		or $pointsmin<0 or $pointsmax<0
		or $goalsmin<0 or $goalsmax<0
		or $assistsmin<0 or $assistsmax<0
		or $salarymin<0 or $salarymax<0)
			{$_SESSION['e6']="Min and max values must be greater than 0. <br>";
			header ("Location: NHLOutput.php");
			exit();}
			
	if ($jerseymin>$jerseymax
		or $gamesmin>$gamesmax
		or $pointsmin>$pointsmax
		or $goalsmin>$goalsmax
		or $assistsmin>$assistsmax
		or $salarymin>$salarymax)
			{$_SESSION['e7']="Min values must be less than max value. <br>";
			header ("Location: NHLOutput.php");
			exit();}
			
	$SQL1="SELECT * FROM stats WHERE ".$team2." 
		AND ".$position2." 
		AND ".$shoots2." AND ".$country2." 
		AND jersey_num>=".$jerseymin." AND jersey_num<=".$jerseymax."
		AND games_played>=".$gamesmin." AND games_played<=".$gamesmax." 
		AND points>=".$pointsmin." AND points<=".$pointsmax." 
		AND goals>=".$goalsmin." AND goals<=".$goalsmax." 
		AND assists>=".$assistsmin." AND assists<=".$assistsmax." 
		AND salary>=".$salarymin." AND salary<=".$salarymax."";
}	
	$result1=mysql_query($SQL1) or die(mysql_error());
	$num_results1=mysql_num_rows($result1);
	$last=ceil($num_results1/$maxrow);
		
	if ($num_results1=="0")
		{$_SESSION['e8']="No results were found.";
		header ("Location: NHLOutput.php");
		exit();}
			
	echo "<h1>Your Search Results:</h1>";
	echo "<table border='5' bordercolor='navy'>";
	echo "<tr><td align='center'><b><a href=project5proL4.php?head=name&order=$order>Name</a></b></td>";
	foreach ($searchcriteria as $head)
		{
			echo "<td align='center'><b><a href=project5proL4.php?head=$head&order=$order>".ucfirst($head)."</a></b></td>";
		}	
	echo "</tr>";	
	$SQL=$SQL1." ORDER BY ".$orderby." ".$order.", name ASC LIMIT ".$start.", ".$maxrow."";
	$result=mysql_query($SQL) or die(mysql_error());
	$num_results=mysql_num_rows($result);
	for ($i=0;$i<$num_results;$i++)
		{	 
			$row=mysql_fetch_array($result);
			echo "<tr><td>".$row["name"]."</td>";
			for ($j=0;$j<count($searchcriteria);$j++)
			{ echo "<td align='center'>".$row[$searchcriteria[$j]]."</td>";}
	
		}
	echo "</table>";
	
	
	if ($start=="0" and $num_results<$maxrow)
		{ echo " "; }
	elseif ($maxrow==$num_results1)
		{ echo " ";}
	elseif ($start=="0")
		{	
			echo "<br><a href='project5proL4.php?2'>Next</a><br>";
			echo "<br><a href='project5proL4.php?4'>Last</a><br>";
		}
	elseif ($start==($last-1)*($maxrow))
		{	
			echo "<br><a href='project5proL4.php?3'>First</a><br>";
			echo "<br><a href='project5proL4.php?1'>Previous</a><br>";
		}
	elseif ($num_results<$maxrow)	
		{	
			echo "<br><a href='project5proL4.php?3'>First</a><br>";
			echo "<br><a href='project5proL4.php?1'>Previous</a><br>";
		}
	else
		{	
			echo "<br><a href='project5proL4.php?3'>First</a><br>";
			echo "<br><a href='project5proL4.php?2'>Next</a><br>";
			echo "<a href='project5proL4.php?1'>Previous</a><br>";
			echo "<br><a href='project5proL4.php?4'>Last</a><br>";
		}	
	echo "<br><a href='NHLOutput.php'>Return Home</a>";

		
		
	$_SESSION['sql1']=$SQL1;
	$_SESSION['start']=$start;
	$_SESSION['max']=$maxrow;
	$_SESSION['array[]']=$searchcriteria;		
	$_SESSION['order1']=$order;		
	$_SESSION['orderby1']=$orderby;	
	$_SESSION['last']=$last;	

mysql_close($db);	
?>