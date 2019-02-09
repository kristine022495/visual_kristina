<!DOCTYPE html>
<html>
<head>
	<title>Create Superuser</title>
</head>
<body>

	<h1>You're not supposed to be here.</h1>

	<p color="red">{{ Session::get('error') }}</p>

	<form method="post" action="createsuperuser">
		@csrf

		<label>Name</label>
		<input type="text" name="name"><br>

		<label>Username</label>
		<input type="text" name="username"><br>

		<label>Password</label>
		<input type="password" name="password"><br>

		<label>Verification Code</label>
		<input type="text" name="verification_code"><br>

		<input type="submit" value="Submit">
	</form>

</body>
</html>