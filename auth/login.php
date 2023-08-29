<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
// Redirect to home page if user is already logged in
if (isset($_SESSION['username'])) {
  header("location: " . APPURL . "");
}

$errors = [];

if (isset($_POST['login'])) {
    //Get user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Error messages
    $errors['email'] = empty($email) ? "* Email is required" : "";
    $errors['password'] = empty($password) ? "* Password is required" : "";

    //Proceed if email and password are provided
    if (empty($errors['email']) && empty($errors['password'])) {
        //Go through the database
        $login = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $login->execute([":email" => $email]);
        $user = $login->fetch();

        //Check the provided password
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            header("location: ". APPURL . "");
        } else {
            $errors['login_failed'] = "* Email or password is incorrect";
        }
    }
}
?>

<!-- Main content container -->
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="main-col">
        <div class="block">
          <h1 class="pull-left">Login</h1>
          <h4 class="pull-right">A Simple Forum</h4>
          <div class="clearfix"></div>
          <hr>

          <!-- Login form -->
          <form role="form" method="post" action="login.php">

            <!-- Email Field -->
            <div class="form-group">
              <label>Email Address*</label>
              <input type="email" class="form-control" name="email" placeholder="Enter Your Email Address" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"/>
              <?php if (isset($errors['email'])) echo "<p class='text-danger'>" . $errors['email'] . "</p>"; ?>
            </div>

            <!-- Password Field -->
            <div class="form-group">
              <label>Password*</label>
              <input type="password" class="form-control" name="password" placeholder="Enter A Password"/>
              <?php if (isset($errors['password'])) echo "<p class='text-danger'>" . $errors['password'] . "</p>"; ?>
              <?php if (isset($errors['login_failed'])) echo "<p class='text-danger'>" . $errors['login_failed'] . "</p>"; ?>
            </div>

            <!-- Login Button -->
            <input name="login" type="submit" class="color btn btn-default" value="Login"/>
          </form>
          
        </div>
      </div>
    </div>

<?php require "../includes/footer.php"; ?>
