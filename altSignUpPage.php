<!DOCTYPE html>

<html>
	<head>
		<title>Sign Up Page</title>
	</head>
	
	<style>
		h1 {
			width: 500px;
			margin: 50px auto;
		}
		.button {
			width: 249px;
			padding: 6px 15px;
			border: 2px solid #3498DB;
			background-color: #3498DB;
			color: white;
			font-size: 16px;
		}
		.button2 {
			position: absolute;
			top: 0;
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
		.button2:hover {
			background-color: #fafafa;
			color: #207cca;
		}
	</style>
	
	<body>
		<form action="loginPage.php">
			<input type="submit" class="button2" value="Back">
		</form>
		<font color="#3498DB"><center><h1>Create An Account</h1></center></font>
		<center><form>
			<font color="#3498DB"><b>Username:</b></font>
			<span style="display: inline-block; width: 3px;"></span>
			<input type="text" name="usr"><br><br>
			<font color="#3498DB"><b>Password:</b></font>
			<span style="display: inline-block; width: 7px;"></span>
			<input type="password" name="password"><br><br>
			<input type="submit" class="button" name="submit" value="Create Account"><br><br>
		</form></center>
	</body>
</html>