<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
// Redirect to home page if user is already logged in
if (isset($_SESSION['username'])) {
    header("location: " . APPURL . "");
}

$errors = [];
$registrationSuccess = false;

if (isset($_POST['submit'])) {
    // Gather user input
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $avatar = $_FILES['avatar']['name'];
    $about = $_POST['about'];

    // List of required fields
    $requiredFields = ['name', 'email', 'username', 'password', 'password2'];

    // Check and show errors for missing fields
    foreach ($requiredFields as $field) {
        if (empty($$field)) {
            $errors[$field] = "* " . ucfirst($field) . " is required";
        }
    }

    // Checking the passwords
    if ($password !== $password2) {
        $errors['password_match'] = "* Passwords do not match";
    }

    // Proceed with registration if no errors
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // hash the password

        $dir = __DIR__ . "/../img/" . basename($avatar); // define avatar directory

        // Insert data into database
        $insert = $conn->prepare("INSERT INTO users (name, email, username, password, about, avatar) 
        VALUES (:name, :email, :username, :password, :about, :avatar)");

        $insert->execute([
            ":name" => $name,
            ":email" => $email,
            ":username" => $username,
            ":password" => $hashedPassword,
            ":about" => $about,
            ":avatar" => $avatar,
        ]);

        // Move uploaded avatar
        move_uploaded_file($_FILES['avatar']['tmp_name'], $dir);
        
        $registrationSuccess = true;
    }
}
?>

<!-- Main content container -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="main-col">
                <div class="block">
                    <h1 class="pull-left">Register</h1>
                    <h4 class="pull-right">A Simple Forum</h4>
                    <div class="clearfix"></div>
                    <hr>

                    <!-- Successful Registration Box -->
                    <?php if($registrationSuccess): ?>
                        <div class="alert alert-success">
                            Registration successful! Please <a href="<?php echo APPURL; ?>/auth/login.php">Login</a> to continue.
                        </div>
                    <?php endif; ?>

                    <!-- Register form -->
                    <form role="form" enctype="multipart/form-data" method="post" action="register.php">

                        <!-- Name Field -->
                        <div class="form-group">
                            <label>Name*</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Your Name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>"/>
                            <?php if(isset($errors['name'])) echo "<p class='text-danger'>" . $errors['name'] . "</p>"; ?>
                        </div>

                        <!-- Email Field -->
                        <div class="form-group">
                            <label>Email Address*</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Your Email Address" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"/>
                            <?php if(isset($errors['email'])) echo "<p class='text-danger'>" . $errors['email'] . "</p>"; ?>
                        </div>

                        <!-- Username Field -->
                        <div class="form-group">
                            <label>Choose Username*</label>
                            <input type="text" class="form-control" name="username" placeholder="Create A Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"/>
                            <?php if(isset($errors['username'])) echo "<p class='text-danger'>" . $errors['username'] . "</p>"; ?>
                        </div>

                        <!-- Password Fields -->
                        <div class="form-group">
                            <label>Password*</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter A Password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>"/>
                            <?php if(isset($errors['password'])) echo "<p class='text-danger'>" . $errors['password'] . "</p>"; ?>
                        </div>

                        <div class="form-group">
                            <label>Confirm Password*</label>
                            <input type="password" class="form-control" name="password2" placeholder="Enter Password Again"/>
                            <?php if(isset($errors['password_match'])) echo "<p class='text-danger'>" . $errors['password_match'] . "</p>"; ?>
                        </div>

                        <!-- Avatar Field -->
                        <div class="form-group">
                            <label>Upload Avatar</label>
                            <input type="file" name="avatar" />
                            <p class="help-block"></p>
                        </div>

                        <!-- About Field -->
                        <div class="form-group">
                            <label>About Me</label>
                            <textarea id="about" rows="6" cols="80" class="form-control" name="about" 
                                      placeholder="Tell us about yourself (Optional)"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <input name="submit" type="submit" class="color btn btn-default" value="Register"/>
                    </form>
                </div>
            </div>
        </div>

<?php require "../includes/footer.php"; ?>