<!DOCTYPE html>
<html>
<body>
<h1> Add Movie/Actor Relation</h1>

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

Actor: <select name="aid">
<?php
	if($connection){
		$query = "select * from Actor";
		$rs = mysql_query($query,$db_connection_addMovieInfo);
		if(!$rs){
			$errmsg = mysql_error($db_connection_addMovieInfo);
    		print "$errmsg <br>";
    		mysql_close($db_connection_addMovieInfo);	
    		exit(1);
		}
		else{
			while($row = mysql_fetch_row($rs)){
				echo "<option value='$row[0]'>$row[2] $row[1] ($row[4])</option>";
			}
			echo "</select><br>";			
		}		
	}

	// if($connection){
	// 	$query = "insert into MovieActor values ($mid,$aid,'$role')";
	// 	echo "$query<br>";
	// 	$rs = mysql_query($queryMovie,$db_connection_addMovieInfo);
	// 	if(!$rs){
	// 		$errmsg = mysql_error($db_connection_addMovieInfo);
 //    		print "$errmsg <br>";
 //    		mysql_close($db_connection_addMovieInfo);	
 //    		exit(1);
	// 	}
	// }

?>

Role: <input type = "text" name = "role"><br>
<input type = "submit" value = "add">
</form>
</p>

<?php
		$mid = $_GET["mid"];
		$aid = $_GET["aid"];
		$role = $_GET["role"];

	if(!empty($aid)&&!empty($mid)&&!empty($role)) {
		$query = "insert into MovieActor values ($mid,$aid,'$role')";
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

