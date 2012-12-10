<!DOCTYPE HTML>
<html>
	<head>
		<title>Create a Profile</title>
		<script src="create.js" type="text/javascript"></script>
		<script src="validate.js" type="text/javascript"></script>
	    <link href="team10Style.css" rel="stylesheet">
	</head>
	<body>
		<div class="column">
		<div id="create" class="windows">
			<div class="windowHeader">
				<img class="FlairClose" src="Flair_Close.png" alt="Close (not clickable" height="20" width="20">
				<p class="windowHeaderText">Create a New Profile</p>
			</div> 
			<div class="windowBody">
				<form enctype="multipart/form-data" name="createUser" action="processCreate.php" method="post">
					<table>
						<tr>
							<td>
								First Name: 
							</td>
							<td>
								<input type="text" name="firstName">
							</td>
							<td>
								<div id="firstNameError"></div>
							</td>
						</tr>
						<tr>
							<td>
								Last Name:
							</td>
							<td>
								<input type="text" name="lastName">
							</td>
							<td>
								<div id="lastNameError"></div>
							</td>
						</tr>
						<tr>
							<td>
								Email:
							</td>
							<td>
								<input type="text" name="email">
							</td>
							<td>
								<div id="emailError"></div>
							</td>
						</tr>
						<tr>
							<td>
								Password:
							</td>
							<td>
								<input type="password" name="password">
							</td>
							<td>
								<div id="passwordError"></div>
							</td>
						</tr>
						<tr>
							<td>
								Verify Password:
							</td>
							<td>
								<input type="password" name="veriPassword">
							</td>
							<td>
								<div id="veriPasswordError"></div>
							</td>
						</tr>
						<tr>
							<td>
								Avatar:
							</td>
							<td>
								<input type="file" name="avatar">
								<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
							</td>
							<td>
								<div id="avatarError"></div>
							</td>
						</tr>
						<tr>
							<td>
								Gender:
							</td>
							<td>
								Male: <input type="radio" name="gender" value="Male" checked = "true"> 
								Female: <input type="radio" name="gender" value="Female">
								Other: <input type="radio" name="gender" value="Other">
							</td>
							<td>
								<div id="genderError"></div>
							</td>
						</tr>
						<tr>
							<td>
								Age:
							</td>
							<td>
								<input type="text" name="age" width="3">
							</td>
							<td>
								<div id="ageError"></div>
							</td>
						</tr>
						<tr>
							<td>
								Location:
							</td>
							<td>
								<input type="text" name="location">
							</td>
							<td>
								<div id="locationError"></div>
							</td>
						</tr>
					</table>
					<input type="button" value="Create Profile" id="submitButton" />
				</form>
			</div>
		</div>
		</div>
	</body>
</html>
