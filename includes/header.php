<?php
  session_start();
  define("APPURL", "http://localhost/forum");
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Meta information -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome To Forum</title>

  <!-- CSS Stylesheets -->
  <link href="<?php echo APPURL; ?>/css/bootstrap.css" rel="stylesheet">
  <link href="<?php echo APPURL; ?>/css/custom.css" rel="stylesheet">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo APPURL; ?>">Forum</a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="<?php echo APPURL; ?>">Home</a></li>

          <?php if(isset($_SESSION['username'])): ?>

            <!-- User is logged in -->
            <li><a href="create.html">Create Topic</a></li>

             <!-- Dropdown menu for logged-in user -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <?php echo $_SESSION['username']; ?>
                <span class="caret"></span></a>
              <ul class="dropdown-menu"> 
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="<?php echo APPURL; ?>/auth/logout.php">Logout</a></li>
              </ul>
            </li>

          <?php else: ?>

            <!-- User is not logged in -->
            <li><a href="<?php echo APPURL; ?>/auth/login.php">Login</a></li>
            <li><a href="<?php echo APPURL; ?>/auth/register.php">Register</a></li>
          <?php endif; ?>

        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>

</body>
</html>
