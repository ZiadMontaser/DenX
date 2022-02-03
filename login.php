<html lang=en>

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="public/lib/bootstrap.min.css">
    <script src="public/lib/jquery.min.js"></script>
    <script src="public/lib/bootstrap.min.js"></script>

</head>

<body>
<div class = "container">
         
<?php
		// This section processes submissions from the login form
		// Check if the form has been submitted:
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				//connect to database
				require ('connect-mysql.php'); 
				// Validate the email address
				if (!empty($_POST['uname'])) {
				$e = mysqli_real_escape_string($dbcon, $_POST['uname']);
				} else {
				$e = FALSE;
				echo '<p class="error">You forgot to enter your email address.</p>';
				}
				// Validate the password
				if (!empty($_POST['psw'])) {
				$p = mysqli_real_escape_string($dbcon, $_POST['psw']);
				} else {
				$p = FALSE;
				echo '<p class="error">You forgot to enter your password.</p>';
				}


				if ($e && $p)
				{           //if no problems 
							// Retrieve the user_id, first_name and user_level for that email/password combination
							$q = "SELECT id, type, name, hidden FROM staff WHERE (name='$e' AND password='$p')";
							// Run the query and assign it to the variable $result
							$result = @mysqli_query ($dbcon, $q);
							// Count the number of rows that match the email/password combination

                             

							if (@mysqli_num_rows($result) == 1) 
							{       //if one database row (record) matches the input:-
									// Start the session, fetch the record and insert the three values in an array
                                    
                                    
									session_start(); 
									$_SESSION = mysqli_fetch_array ($result, MYSQLI_ASSOC);
									// Ensure that the user level is an integer.
									$_SESSION['type'] = (int) $_SESSION['type'];
									$_SESSION['id'];
									$_SESSION['name'];
									// Use a ternary operation to set the URL 
									if($_SESSION['hidden'] === '1'){
										echo 'You have been blocked by the admin!!';
										exit();
									}
									if($_SESSION['type'] === 1){
                                        $url = 'admin.php';
                                    }
                                    if($_SESSION['type'] === 2){
                                        $url = 'receptionist.php';
                                    }
                                    if($_SESSION['type'] === 3){
                                        $url = 'dentist.php';
                                    }
									header('Location: ' . $url); // Make the browser load either the members’ or the admin page
									exit(); // Cancel the rest of the script
									mysqli_free_result($result);
									mysqli_close($dbcon);
							} 

							else { // No match was made.
									echo '<p class="error">The e-mail address and password entered do not match our records 
									<br>Perhaps you need to register, just click the Register button on the header menu</p>';
							       }

				} 
				else { // If there was a problem.
				        echo '<p class="error">Please try again.</p>';
				       }
				mysqli_close($dbcon);
		} // End of SUBMIT conditional.
?>
      </div>
    <div class="vertical-center">
<h2 class="text-center" style="margin-top: 128px">Welcome back...</h2>

<form role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
<div class="container col-md-4 col-md-offset-4 text-center" style="margin-top: 28px">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" class="form-control" style="margin-bottom: 20px" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" class="form-control" style="margin-bottom: 20px" required>
        
    <button type="submit" class="btn btn-primary" name = "login">Login</button>

  </div>
  </div>

</form>

</body>

</html>
