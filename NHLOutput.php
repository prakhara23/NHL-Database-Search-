<?php
	$db=mysql_connect("localhost","root") or die('Not connected : ' . mysql_error());
	mysql_select_db("nhl",$db) or die (mysql_error());
?>
<?php
$e0=" ";
$e1=" ";
$e2=" ";
$e3=" ";
$e4=" ";
$e5=" ";
$e6=" ";
$e7=" ";
$e8=" ";
$e9=" ";
$e10=" ";
session_start();
if (isset($_SESSION['e0']))
	{$e0=$_SESSION['e0'];}
if (isset($_SESSION['e1']))
	{$e1=$_SESSION['e1'];}
if (isset($_SESSION['e2']))
	{$e2=$_SESSION['e2'];}	
if (isset($_SESSION['e3']))
	{$e3=$_SESSION['e3'];}	
if (isset($_SESSION['e4']))
	{$e4=$_SESSION['e4'];}	
if (isset($_SESSION['e5']))
	{$e5=$_SESSION['e5'];}	
if (isset($_SESSION['e6']))
	{$e6=$_SESSION['e6'];}	
if (isset($_SESSION['e7']))
	{$e7=$_SESSION['e7'];}	
if (isset($_SESSION['e8']))
	{$e8=$_SESSION['e8'];}
if (isset($_SESSION['e9']))
	{$e9=$_SESSION['e9'];}	
if (isset($_SESSION['e10']))
	{$e10=$_SESSION['e10'];}		
session_destroy();	


?>
<form action="NHLprocessing.php?" method="POST">
<h1><img src="http://www.law.com/image/cc/128_pics/NHL_Logo_128.jpg">NHL Database</h1>
<p>
	<?php
	echo "<font color='red'><b>".$e8."</b></font>";
	?>
</p>	
<p><b>Stats to be Displayed:</b></p>
	<?php
		$stats=array("team","country","shoots","position","jersey_num","games_played","points","goals","assists","salary");
				
		foreach ($stats as $statvalues)
			{ echo "<input type='checkbox' name='checkbox[]' value=".$statvalues." checked>".ucfirst($statvalues);}
	?>
<p><b>Rows per Page:</b> <input type="number" name="maxrow" value="10">
		<?php
		echo "<font color='red'><b>".$e1."</b></font>";
		?></p>

<table border="1">
	<tr>
		<td><b>Team:</b></td>
		<td>
			<?php
				$SQL="SELECT DISTINCT team FROM stats ORDER BY team ASC"; 
				$result=mysql_query($SQL) or die(mysql_error());
				$num_results=mysql_num_rows($result);
					for ($i=0;$i<$num_results;$i++)
					{
					if ($i=="10" or $i=="20" or $i=="30")
						{ echo "<br>";}
					$row=mysql_fetch_array($result);
					echo "<input type='checkbox' name='team[]' value='".$row["team"]."' checked>".$row["team"]."\n";
					}
			?>
		</td>
		<td>
			<?php
			echo "<font color='red'><b>".$e2."</b></font>";
			?>
		</td>	
	</tr>
	<tr>
		<td><b>Position:</b></td>
		<td>
			<?php
				$SQL="SELECT DISTINCT position FROM stats ORDER BY position ASC"; 
				$result=mysql_query($SQL) or die(mysql_error());
				$num_results=mysql_num_rows($result);
					for ($i=0;$i<$num_results;$i++)
					{
					$row=mysql_fetch_array($result);
					echo "<input type='checkbox' name='position[]' value='".$row["position"]."' checked>".$row["position"]."\n";
					}
			?>
		</td>
		<td>
			<?php
			echo "<font color='red'><b>".$e3."</b></font>";
			?>
		</td>	
	</tr>
	<tr>
		<td><b>Shoots:</b></td>
		<td>
			<?php
				$SQL="SELECT DISTINCT shoots FROM stats ORDER BY shoots ASC"; 
				$result=mysql_query($SQL) or die(mysql_error());
				$num_results=mysql_num_rows($result);
					for ($i=0;$i<$num_results;$i++)
					{
					$row=mysql_fetch_array($result);
					echo "<input type='checkbox' name='shoots[]' value='".$row["shoots"]."' checked>".$row["shoots"]."\n";
					}
			?>
		</td>
		<td>
			<?php
			echo "<font color='red'><b>".$e4."</b></font>";
			?>
		</td>	
	</tr>
	<tr>
		<td><b>Country:</b></td>
		<td>
			<?php
				$SQL="SELECT DISTINCT country FROM stats ORDER BY country ASC"; 
				$result=mysql_query($SQL) or die(mysql_error());
				$num_results=mysql_num_rows($result);
					for ($i=0;$i<$num_results;$i++)
					{
					if ($i=="9" or $i=="18")
						{ echo "<br>";}
					$row=mysql_fetch_array($result);
					echo "<input type='checkbox' name='country[]' value='".$row["country"]."' checked>".$row["country"]."\n";
					}
			?>
		</td>
		<td>
			<?php
			echo "<font color='red'><b>".$e5."</b></font>";
			?>
		</td>	
	</tr>
	<tr>
		<td><b>Jersey Number:</td>
		<td>Minimun:<input type="number" name="jersey_num" value="0">
		Maximum:<input type="number" name="jersey_num1" value="100"></td>
	</tr>
	<tr>
		<td><b>Games Played:</td>
		<td>Minimun:<input type="number" name="games_played" value="0">
		Maximum:<input type="number" name="games_played1" value="82"></td>
	</tr>	
	<tr>
		<td><b>Points:</td>
		<td>Minimun:<input type="number" name="points" value="0">
		Maximum:<input type="number" name="points1" value="150"></td>
	</tr>	
	<tr>
		<td><b>Goals:</td>
		<td>Minimun:<input type="number" name="goals" value="0">
		Maximum:<input type="number" name="goals1" value="100"></td>
	</tr>
	<tr>
		<td><b>Assists:</td>
		<td>Minimun:<input type="number" name="assists" value="0">
		Maximum:<input type="number" name="assists1" value="100"></td>
	</tr>
	<tr>
		<td><b>Salary:</td>
		<td>Minimun:<input type="number" name="salary" value="0">
		Maximum:<input type="number" name="salary1" value="10000000"></td>
	</tr>	
	<tr>
		<td align="center" colspan="3">	
			<?php
			echo "<font color='red'><b>".$e6.$e7.$e10."</b></font>";
			?>
		</td>
	</tr>		
</table>	
<p><input type="submit" name="submit" value="Search"></p>
<p><b>Top 10 Players:</b></p>
<table>
	<tr>
		<?php
		echo "<td colspan='2'><font color='red'><b>".$e9."</b></font></td>";
		?>	
	</tr>
	<tr>
		<td colspan="5"><b>Stats to be Displayed:</b></td>
	</tr>
	<tr>
		<td colspan="2">
			<?php
				$stats=array("team","country","shoots","position","jersey_num","games_played");
				
				foreach ($stats as $statvalues)
					{echo "<input type='checkbox' name='checkbox2[]' value=".$statvalues." checked>".ucfirst($statvalues);}
				?>
		</td>
	</tr>
	<tr>
		<td><b>Top 10 Players based on:</b>
			<select name="top10">
				<option value="x">Select</option>
				<?php
				$top10=array("goals", "assists", "points", "salary");
				
				foreach ($top10 as $topvalues)
					{ echo "<option value=".$topvalues.">".ucfirst(strtolower($topvalues))."</option>";}
				?>
			</select>
		</td>
	<tr>	
		<td colspan="3"><input type="submit" name="submit1" value="Search"></td>	
		<input type="hidden" name="form_status" value="ok">
	</tr>
</table>	
		