<!DOCTYPE html>
<html>
<body>
<h1> Add Movie Comment</h1>
	
	<a href = './addActorDirector.php'>Add Actor or Director</a>
 	<a href = './addMovieInfo.php'>Add Movie</a>
 	<a href = './addMovieActor.php'>Add Actor to Movie</a>
 	<a href = './addMovieDirector.php'>Add Director to Movie</a>
	<form method = "get" action = "./search.php">
		Search:<input type = "text" name = "keyWord">
		<input type = "submit" value="Submit">
	</form>

<?php
	$connection = False;
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		$mid = $_GET["mid"];	
		$name = $_GET["name"];	
		$comment = $_GET["comment"];
		$rating = $_GET["rating"];

		// echo "mid = $mid <br>";
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
	}
	if($connection){
		$queryMovie = "select title from Movie where id = $mid ";
		// echo "$queryMovie<br>";
		$rs = mysql_query($queryMovie,$db_connection_addMovieInfo);
		if(!$rs){
			$errmsg = mysql_error($db_connection_addMovieInfo);
    		print "$errmsg <br>";
    		mysql_close($db_connection_addMovieInfo);	
    		exit(1);
		}
		else{
			$row = mysql_fetch_row($rs);
			$title = $row[0];
			// echo "title = $title<br>";
		}
	}

?>

<p>
<form method = "get" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Movie: <select name="title"><option> <?php echo $title; ?> </select><br>
Your name: <input type = "text" name = "name"><br>
Rating: <select name="rating"><option>5(awesome)<option>4(excellent)<option>3(fine)<option>2(good)<option>1(not bad)</select><br>
Comments:<br>
<textarea name="comment" cols="60" rows="8"></textarea><br>
<input type = "submit" value = "add comment!">
<input type = "hidden" name="mid" value= <?php echo $mid; ?> >
</form>
</p>

<?php
	$queryTime ="select now()";
	$rs = mysql_query($queryTime,$db_connection_addMovieInfo);		
	$row = mysql_fetch_row($rs);
	$time = $row[0];

	if(!empty($name)){
		$rs = mysql_query($queryTime,$db_connection_addMovieInfo);
		$query = "insert into Review values ('$name',NULL,$mid,$rating[0],'$comment')";
		// echo "$query<br>";
		$rs = mysql_query($query,$db_connection_addMovieInfo);
		if(!$rs){
			$errmsg = mysql_error($db_connection_addMovieInfo);
    		print "$errmsg <br>";
    		mysql_close($db_connection_addMovieInfo);	
    		exit(1);
		}
		else{
			echo "Add successfully<br>";
		}
	}
	mysql_close($db_connection_addMovieInfo);	
?>


</body>
</html>

