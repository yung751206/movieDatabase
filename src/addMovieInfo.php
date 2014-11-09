<!DOCTYPE html>
<html>
<body>
<h1> Add Movie Information</h1>

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

Title: <input type = "text" name = "title"><br>
Company: <input type = "text" name = "company"><br>
Year: <input type = "text" name = "year"><br>
MPAA Rating: <select name="rating"><option>G<option>NC-17<option>PG<option>PG-13<option>R<option>surrendere</select><br>
Genre: 
	<input type="checkbox" name="genre[0]" value="Action">Action
	<input type="checkbox" name="genre[1]" value="Adult">Adult
	<input type="checkbox" name="genre[2]" value="Adventure">Adventure
	<input type="checkbox" name="genre[3]" value="Animation">Animation
	<input type="checkbox" name="genre[4]" value="Comedy">Comedy
	<input type="checkbox" name="genre[5]" value="Crime">Crime
	<input type="checkbox" name="genre[6]" value="Documentary">Documentary
	<input type="checkbox" name="genre[7]" value="Drama">Drama
	<input type="checkbox" name="genre[8]" value="Family">Family
	<input type="checkbox" name="genre[9]" value="Fantasy">Fantasy
	<input type="checkbox" name="genre[10]" value="Horror">Horror
	<input type="checkbox" name="genre[11]" value="Musical">Musical
	<input type="checkbox" name="genre[12]" value="Mystery">Mystery
	<input type="checkbox" name="genre[13]" value="Romance">Romance
	<input type="checkbox" name="genre[14]" value="Sci-Fi">Sci-Fi
	<input type="checkbox" name="genre[15]" value="Short">Short
	<input type="checkbox" name="genre[16]" value="Thriller">Thriller
	<input type="checkbox" name="genre[17]" value="War">War
	<input type="checkbox" name="genre[18]" value="Western">Western<br>
<input type = "submit" value = "add">
</form>
</p>


<?php


	$connection = False;
	if(!empty($_GET["title"])){
		if($_SERVER["REQUEST_METHOD"] == "GET") {
			$title = $_GET["title"];
			$company = $_GET["company"];
			$year = $_GET["year"];
			$rating = $_GET["rating"];
			$genreSum;
			$genre = $_GET["genre"];
			// for($i=0;$i<19;$i++){
			// 	if(!empty($genre[$i])){
			// 		if(empty($genreSum)){
			// 			$genreSum[$i] = "$genre[$i]";
			// 		}
			// 		else{
			// 			$genreSum = $genreSum . "&$genre[$i]";
			// 		}
			// 	}		
			// }
			// $genre = $genreSum;

			// echo "$title $company $year $rating $genre<br>";

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
	}
	if($connection){
		$queryMaxMovieID = "select * from MaxMovieID";
		$rs = mysql_query($queryMaxMovieID,$db_connection_addMovieInfo);
		if(!$rs){
			$errmsg = mysql_error($db_connection_addMovieInfo);
    		print "$errmsg <br>";
    		mysql_close($db_connection_addMovieInfo);	
    		exit(1);
		}
		else{
			while($row = mysql_fetch_row($rs)){
				$id = $row[0]+1;
			}
		}

		$query = "insert into Movie values ($id,'$title',$year,'$rating','$company')";
		// echo "$query<br>";
		$rs = mysql_query($query,$db_connection_addMovieInfo);
		if(!$rs){
			$errmsg = mysql_error($db_connection_addMovieInfo);
    		print "$errmsg <br>";
    		mysql_close($db_connection_addMovieInfo);	
    		exit(1);
		}

		for($i=0;$i<19;$i++){
			if(!empty($genre[$i])){
				$query = "insert into MovieGenre values ($id,'$genre[$i]')";
				// echo "$query<br>";
				$rs = mysql_query($query,$db_connection_addMovieInfo);
				if(!$rs){
					$errmsg = mysql_error($db_connection_addMovieInfo);
		    		print "$errmsg <br>";
		    		mysql_close($db_connection_addMovieInfo);	
		    		exit(1);
				}
			}
		}
		echo "Add successfully<br>";

		$queryMaxMovieID = "update MaxMovieID set id = $id";
		// echo "$queryMaxMovieID<br>";
		$rs = mysql_query($queryMaxMovieID,$db_connection_addMovieInfo);
		if(!$rs){
			$errmsg = mysql_error($db_connection_addMovieInfo);
    		print "$errmsg <br>";
    		mysql_close($db_connection_addMovieInfo);	
    		exit(1);
		}				
		mysql_close($db_connection_addMovieInfo);
	}
		
?>

</body>
</html>

