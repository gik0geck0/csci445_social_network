<!doctype html>
<html>
	<head>
	</head>
	<body>
		<div>
			<h1>Welcome to YASMS!</h1>
			<p>
				YASMS is Yet Another Social Media Site! By having an account, you will be able to find friends who are online, chat with them, share photos with them, and view their status updates.
			</p>
			<p>
				Why choose YASMS over other sites? Simple: unlike our competitors, we haven't been taken over by trolls, internet memes, or your parents.
			</p>
		</div>
		<form name="loginForm" action="validateLogin.php" method="post">
			<table border="1">
				<tr>
					<td>
						Username: 
					</td>
					<td>
						<input type="text" name="username">
					</td>
				</tr>
				<tr>
					<td>
						Password:
					</td>
					<td>
						<input type="password" name="password">
					</td>
				</tr>
			</table>
			<div>
				<input id="submitButton" type="submit" value="Log Me In!"/>
				<a href="create.php">Need to create an account?</a>
			</div>
			<div id="errors">
			</div>
		</form>
	</body>
</html>
