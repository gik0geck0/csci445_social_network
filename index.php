<?php include("header.php") ?>
<div>
	<h1>Welcome to The Social Network (v3.1)!</h1>
	<p>
		The Social Network is a Classic spin on social media sites! By having an account, you will be able to find friends who are online, chat with them, share photos with them, and view their status updates.
	</p>
	<p>
		Why choose The Social Network (v3.1) over other sites? Simple: unlike our competitors, we haven't been taken over by trolls, internet memes, or your parents.
	</p>
</div>
<form name="loginForm" action="validateLogin.php" method="post">
	<table border="1">
		<tr>
			<td>
				Email: 
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
		<?php 
			if($_GET['error']==1) {
				echo "<p>Invalid username or password</p>";
			}
		?>
	</div>
</form>
<?php include("footer.php"); ?>
