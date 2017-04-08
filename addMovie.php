<!DOCTYPE html>

<html>
	<head>
		<title>Add Movie</title>
	</head>
	
	<style>
		h1 {
			width: 500px;
			margin: 50px auto;
		}
		form {
			display: inline;
		}
		.button {
			width: 250px;
			padding: 6px 15px;
			border: 2px solid #3498DB;
			background-color: #3498DB;
			color: white;
		}
		.button5 {
			position: absolute;
			bottom: 0;
			left: 0;
			padding: 6px 15px;
			border: 2px solid #3498DB;
			background-color: #3498DB;
			color: #fafafa;
		}
		.button:hover {
			background-color: #fafafa;
			color: #207cca;
		}
		.button5:hover {
			background-color: #fafafa;
			color: #207cca;
		}
	</style>
<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', 'films_db');
	$db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	
	if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	} 
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		// username and password sent from form
		
		$filmname = mysqli_real_escape_string($db,$_POST['name']);
		$year = mysqli_real_escape_string($db,$_POST['year']);
		$budget = mysqli_real_escape_string($db,$_POST['budget']);
		$boxOffice = mysqli_real_escape_string($db,$_POST['boxOffice']);
		$description = mysqli_real_escape_string($db,$_POST['description']);
		$director = mysqli_real_escape_string($db,$_POST['director']);
			
		$sql = "SELECT name 
				FROM films 
				WHERE name = '$filmname' 
				";
				
		$result = $db->query($sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$active = $row['active'];
		
		$count = mysqli_num_rows($result);
		
		// if result matched $myusername and $mypassword, table row must be 1 row
		// means the account is already made
		if ($count == 1) {
			
			session_destroy();
			$message = "Film name already taken.";
			$db->close();
			echo "<script type='text/javascript'>alert('$message'); location='addMovie.php';</script>";
			
			
		}
		else {
			
	
			$query = "INSERT INTO films (name, year, budget,boxOffice,description,director)
			VALUES('$filmname', '$year', '$budget','$boxOffice','$description','$director')";
			
			
			$db->query($query);
			$accmessage = "Film Added";
			$db->close();
			echo "<script type='text/javascript'>alert('$accmessage'); location='modPage.php';</script>";
		}
	}
?>		
	<body>
		<?php include 'header.php' ?>
		
		<font color="#3498DB"><center><h1>Add Movie</h1></center></font>
		<center><form action = "" method = "post">
			
			<font color="#3498DB"><b>Film Name:</b></font>
			<span style="display: inline-block; width: 3px;"></span>
			<input type="text" name="name"><br><br>
			
			<font color="#3498DB"><b>Year:</b></font>
			<span style="display: inline-block; width: 7px;"></span>
			<input type="number" min="1900" max="2017" name="year"><br><br>

			<font color="#3498DB"><b>Runtime(in Minutes): </b></font>
			<span style="display: inline-block; width: 7px;"></span>
			<input type="number" name="runtime"><br><br>

			<font color="#3498DB"><b>Budget:</b></font>
			<span style="display: inline-block; width: 7px;"></span>
			<input type="number" name="budget"><br><br>	

			<font color="#3498DB"><b>Box Office:</b></font>
			<span style="display: inline-block; width: 7px;"></span>
			<input type="number" name="boxOffice"><br><br>

			<font color="#3498DB"><b>Description:</b></font>
			<span style="display: inline-block; width: 7px;"></span>
			<input type="text" name="description"><br><br>
			
			<font color="#3498DB"><b>Director(use ID):</b></font>
			<span style="display: inline-block; width: 7px;"></span>
			<input type="number" name="director"><br><br>

			
			<input type="submit" class="button" name="submit" value="Add Film"><br><br>
		</form></center>
		Directors
		<?php

		$conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		
		$sql = "SELECT d.ID, name FROM directors AS d, persons AS p
		WHERE d.ID = p.ID
		GROUP BY ID";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			echo "<table><tr><th>ID</th><th>Name</th></tr>";
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo "<tr><td>".$row["ID"]."</td><td>".$row["name"]."</td></tr>";
			}
		echo "</table>";
		} else {
			echo "0 results";
		}
		
		$conn->close();
		?> 
				
	</body>
</html>