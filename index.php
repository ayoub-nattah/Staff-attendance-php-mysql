
<?php
    ob_start();
	//start session
	session_start();
	//redirect if logged in
	if(isset($_SESSION['user'])){
		header('location:dashboard.php');
	}
	ob_end_flush(); // send output to browser

?>
<!DOCTYPE html>
<html>
<head>
	<style>
		body {
	background-image: url("images/airport.jpg");
	background-size: cover;
	background-position: center;
	}
	
	nav {
    color:  #0c4da3;
    background:#ffffff;
    position: fixed;
    width: 100%;
    height: 50px;
}
.side-menu {
    position: fixed;
    background: #fff;
    width: 220px;
    height: 100%;
    margin-top: 50px;
}

.side-menu center img {
    height: 100px;
    width: 100px;
    border-radius: 50%;
    border: 3px solid white;
}

.side-menu center h2 {
    color: white;
    line-height: 20px;
    margin-bottom: 40px;
    font-size: 25px;
    font-weight: 200;
}


   
	</style>
	<title>PHP Login using OOP Approach</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

	

</head>
<body>
		

		



	<div class="container">
		<p style="text-align:center; "><img src="spacelogin.png" alt="Logo" class="logo" ></p>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title" ><span class="glyphicon glyphicon-lock"></span> Login
						</h3>
					</div>
					<div class="panel-body">
						<form method="POST" action="login.php">
							<fieldset>
								<div class="form-group">
									<input class="form-control" placeholder="Username" type="text" name="username" autofocus required>
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Password" type="password" name="password" required>
								</div>
								<button type="submit" name="login" class="btn btn-lg btn-primary btn-block"><span class="glyphicon glyphicon-log-in"></span> Login</button>
								<div class="text-center"><a type="submit" href="adminlog.php"> <span class="glyphicon glyphicon-log-in"></span> Register User</a></div>
							</fieldset>
						</form>
					</div>
				</div>
				<?php
					if(isset($_SESSION['message'])){
						?>
						<div class="alert alert-info text-center">
							<?php echo $_SESSION['message']; ?>
						</div>
					<?php
					unset($_SESSION['message']);
					}
				?>
			</div>
		</div>
	</div>
</body>
</html>