<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<style>
		body{
			background: pink;
		}
	</style>
</head>
<body>
	<section id="app">
		<form action="/token/details" method="post">
			{{csrf_field()}}
			<input type="text" name="secret" placeholder="secret">
			<select name="grant_type" id="" v-model="grant_type">
				<option value="password">password</option>
				<option value="refresh_token">refresh_token</option>
			</select>
			<input type="email" name="userName" placeholder="userName">
			<input type="number" name="client_id" placeholder="client_id">
			<input type="number" name="vendor_id" placeholder="vendor_id">
			<input type="password" name="password" placeholder="password">
			<textarea name="refresh_token" cols="30" rows="10" v-show="checkGrant_type"></textarea>
			<input type="submit" value="get Token">
		</form>
	</section>
<script src="js/app.js"></script>
</body>
</html>