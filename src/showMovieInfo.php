<!DOCTYPE html>
<html>
<body>
<h1> Show Movie Info </h1>
	
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
</form>
</p>

<?php
	$connection = False;
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		if (!empty($_GET["mid"])){
			$mID = $_GET["mid"];
			$query[0] = "select * from Movie where id = $mID ";	
			$query[1] = "select Actor.id,Actor.first,Actor.last,MovieActor.role from Actor,MovieActor where Actor.id = MovieActor.aid and MovieActor.mid = $mID";
			

			$db_connection_movieInfo = mysql_connect("localhost", "cs143", "");
			if ($db_connection_movieInfo){
				mysql_select_db("CS143",$db_connection_movieInfo);
				$connection = True;
			}
			else{
				$errmsg = mysql_error($db_connection_movieInfo);
				print "$errmsg <br>";
				mysql_close($db_connection_movieInfo);
				exit(1);
			}
		}
		if($connection){
			$rs = mysql_query($query[0],$db_connection_movieInfo);
			if(!$rs){
				$errmsg = mysql_error($db_connection_movieInfo);
	    		print "$errmsg <br>";
	    		mysql_close($db_connection_movieInfo);	
	    		exit(1);
			}
			else{
				while($row = mysql_fetch_row($rs)){
					echo "Title: $row[1]($row[2])<br>";
					echo "MPAA Rating: $row[3]<br>";
					echo "Company: $row[4]<br>";
				}
			}

			$queryDirector = "select * from Director d,MovieDirector md where d.id = md.did and md.mid = $mID";
			$rs = mysql_query($queryDirector,$db_connection_movieInfo);
			if(!$rs){
				$errmsg = mysql_error($db_connection_movieInfo);
	    		print "$errmsg <br>";
	    		mysql_close($db_connection_movieInfo);	
	    		exit(1);
			}
			else{
				echo"Director: ";
				$length = mysql_num_rows($rs);
				for($i=0;$i<$length-1;$i++){
					$row = mysql_fetch_row($rs);
					echo "$row[2] $row[1], ";
				}
				$row = mysql_fetch_row($rs);
				echo "$row[2] $row[1]<br>";
			}			

			$queryGenre = "select * from MovieGenre where mid = $mID";
			$rs = mysql_query($queryGenre,$db_connection_movieInfo);
			if(!$rs){
				$errmsg = mysql_error($db_connection_movieInfo);
	    		print "$errmsg <br>";
	    		mysql_close($db_connection_movieInfo);	
	    		exit(1);
			}
			else{
				echo"Genre: ";
				$length = mysql_num_rows($rs);
				for($i=0;$i<$length-1;$i++){
					$row = mysql_fetch_row($rs);
					echo "$row[1], ";
				}
				$row = mysql_fetch_row($rs);
				echo "$row[1]";
				echo "<br><br>";
			}


			echo "Actor in This Movie<br>";
			$rs = mysql_query($query[1],$db_connection_movieInfo);
			if(!$rs){
				$errmsg = mysql_error($db_connection_movieInfo);
	    		print "$errmsg <br>";
	    		mysql_close($db_connection_movieInfo);	
	    		exit(1);
			}
			else{
				while($row = mysql_fetch_row($rs)){	
					echo"<a href = './showActorInfo.php?aid=$row[0]''>$row[1] $row[2]</a> act as '$row[3]'<br>";
				}
			}			

			echo "<br>Comment for This Movie<br>";
			$query = "select avg(rating) from Review where mid = $mID";
			$rs = mysql_query($query,$db_connection_movieInfo);
			$avg = mysql_fetch_row($rs);
			$query = "select count(*) from Review where mid = $mID";
			$rs = mysql_query($query,$db_connection_movieInfo);
			$num = mysql_fetch_row($rs);

			if(!empty($avg[0])){
				echo "Average Rating is $avg[0]/5.0000 by $num[0] users<br>";
			}
			else{
				echo "There is no rating right now<br>";	
			}

			$query = "select * from Review where mid = $mID";
			$rs = mysql_query($query,$db_connection_movieInfo);
			while($comment = mysql_fetch_row($rs)){
				echo "Users $comment[0] gives this movie $comment[3]/5 rating in $comment[1] and the comment is following<br>";
				echo "$comment[4]<br><br>";
			}

		}
		mysql_close($db_connection_movieInfo);	
		echo "<br>";
		echo"<a href = './addComment.php?mid=$mID' >add comment</a><br>";
	}
?>

</body>
</html>

