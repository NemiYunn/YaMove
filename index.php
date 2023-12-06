<?php
// include auth.php
include_once('lib/functions/auth.php');

if (isset($_POST['btn_submit'])) {
  // create an object of the Authentication class and call login
  $objAuth = new Authentication();
  $result = $objAuth->login($_POST['userName'], $_POST['userPwd']);
  
  echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
  echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
  echo '<script>';
  echo '$(document).ready(function() {
    Swal.fire({
      title: "",
      text: "' . $result . '",
      icon: "warning",
      confirmButtonText: "OK"
    });
  });';
  echo '</script>';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="<?php echo ($_SERVER['PHP_SELF']); ?>" method="POST" class="sign-in-form">
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="userName" id="userName" placeholder="Enter Your Name" required>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="userPwd" id="userPwd" placeholder="Enter Your Password" required>
          </div>
          <div style="margin-top:4px ;">
            <span>Forgot Password? <a href="#">Click Here</a></span>
          </div>
          <input type="submit" value="Login" class="btn solid" name="btn_submit" />
<!-- 
          <p class="social-text">Or Sign in with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div> -->
        </form>
      </div>
    </div>
    <div class="panels-container">
      <div class="panel left-panel">
        <img src="lib/images/7164125.png" class="image" alt="" />
      </div>
    </div>
  </div>
  <script>
    // Your other JavaScript code can go here if needed
  </script>
</body>

</html>
