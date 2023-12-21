<?php
//session_start();
require 'config.php';

// Redirect the user to the index page if already logged in
if (!empty($_SESSION["id"])) {
  header("Location: index.php");
  exit();
}

// Registration Logic
if (isset($_POST["register_submit"])) {
  $name = mysqli_real_escape_string($conn, $_POST["name"]);
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);
  $confirmpassword = mysqli_real_escape_string($conn, $_POST["confirmpassword"]);

  $duplicate = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username' OR email = '$email'");
  
  if (mysqli_num_rows($duplicate) > 0) {
    echo "<script> alert('Username or Email Has Already Been Taken'); </script>";
  } else {
    if ($password == $confirmpassword) {
      // Hash the password before storing it
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      
      $query = "INSERT INTO tb_user (name, username, email, password) VALUES ('$name', '$username', '$email', '$hashed_password')";
      mysqli_query($conn, $query);
      echo "<script> alert('Registration Successful'); </script>";
    } else {
      echo "<script> alert('Password Does Not Match'); </script>";
    }
  }
}

// Login Logic
if (isset($_POST["login_submit"])) {
  $usernameemail = mysqli_real_escape_string($conn, $_POST["usernameemail"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);

  $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$usernameemail' OR email = '$usernameemail'");
  $row = mysqli_fetch_assoc($result);

  if (mysqli_num_rows($result) > 0) {
    if (password_verify($password, $row['password'])) {
      $_SESSION["login"] = true;
      $_SESSION["id"] = $row["id"];
      header("Location: index.php");
    } else {
      echo "<script> alert('Wrong Password'); </script>";
    }
  } else {
    echo "<script> alert('User Not Registered'); </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> 
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Document</title>
</head>
<body>
    <!--Header-->
    <!-- <header>
        <nav>
          <div class="logo">
            <a href="#">EKH EKH</a>
          </div>
  
          <div class="list">
            <ul>
              <li><a href="#artikel">Artikel</a></li>
              <li><a href="#kepribadian">Kepribadian</a></li>
              <li><a href="#cariTeman">Cari Teman</a></li>
            </ul>
          </div>
  
          <div class="login">
            <button class="login" id="form-open">Login</button>
          </div>
        </nav>
    </header> -->

    <!--Home-->
   

        <!-- Signup Form -->
        <div class="form signup_form">
          <form action="" method="post">
            <h2>Signup</h2>
            <div class="input_box">
              <input type="text" name="name" placeholder="Name" required>
            </div>
            <div class="input_box">
              <input type="text" name="username" placeholder="Username" required>
              <i class='bx bx-user user' ></i>
            </div>
            <div class="input_box">
              <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input_box">
              <input type="password" name="password" placeholder="Create Password" required>
              <i class='bx bx-lock-alt pass'></i>
              <i class='uil uil-eye-slash pass_hide' ></i>
            </div>
            <div class="input_box">
              <input type="password" name="confirmpassword" placeholder="Confirm Password" required>
              <i class='bx bx-lock-alt pass'></i>
              <i class='uil uil-eye-slash pass_hide' ></i>
            </div>

            <button class="button" name="register_submit" type="submit">Signup</button>

            <div class="login_signup">
              Already have an account? <a href="login.php" id="login">Login</a>
            </div>
          </form>
        </div>
      </div>
    </section>

    <script src="script.js"></script>
</body>
</html>
