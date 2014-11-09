<!DOCTYPE html>
<html>
<body>
<h1> Add Movie/Director Relation</h1>

	<a href = './addActorDirector.php'>Add Actor or Director</a>
 	<a href = './addMovieInfo.php'>Add Movie</a>
 	<a href = './addMovieActor.php'>Add Actor to Movie</a>
 	<a href = './addMovieDirector.php'>Add Director to Movie</a>
	<form method = "get" action = "./search.php">
		Search:<input type = "text" name = "keyWord">
		<input type = "submit" value="Submit">
	</form>

<p>
<form method = "get" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

Movie: <select name="mid">

<?php
	$db_connection_addMovieInfo = mysql_connect("localhost", "cs143", "");
	if ($db_connection_addMovieInfo){
		mysql_select_db("CS143",$db_connection_addMovieInfo);
		$connection = True;
	}
	else{
		$errmsg = mysql_error($db_connection_addMovieInfo);
		print "$errmsg <br>";
		mysql_close($db_connection_addMovieInfo);
		exit(1);
	}
	if($connection){
		$query = "select * from Movie";
		$rs = mysql_query($query,$db_connection_addMovieInfo);
		if(!$rs){
			$errmsg = mysql_error($db_connection_addMovieInfo);
    		print "$errmsg <br>";
    		mysql_close($db_connection_addMovieInfo);	
    		exit(1);
		}
		else{
			while($row = mysql_fetch_row($rs)){
				echo "<option value='$row[0]'>$row[1] ($row[2])</option>";
			}
			echo "</select><br>";			
		}		
	}
?>

Director: <select name="did">
<?php
	if($connection){
		$query = "select * from Director";
		$rs = mysql_query($query,$db_connection_addMovieInfo);
		if(!$rs){
			$errmsg = mysql_error($db_connection_addMovieInfo);
    		print "$errmsg <br>";
    		mysql_close($db_connection_addMovieInfo);	
    		exit(1);
		}
		else{
			while($row = mysql_fetch_row($rs)){
				echo "<option value='$row[0]'>$row[2] $row[1] ($row[3])</option>";
			}
			echo "</select><br>";			
		}		
	}
?>

<input type = "submit" value = "add">
</form>
</p>

<?php
	$mid = $_GET["mid"];
	$did = $_GET["did"];
	if(!empty($did)&&!empty($mid)) {
		$query = "insert into MovieDirector values ($mid,$did)";
		// echo "$query<br>";
		$rs = mysql_query($query,$db_connection_addMovieInfo);
		if(!$rs){
			$errmsg = mysql_error($db_connection_addMovieInfo);
    		print "$errmsg <br>";
    		mysql_close($db_connection_addMovieInfo);	
    		exit(1);
		}
		echo "add it<br>";
	}	
?>

</body>
</html>

