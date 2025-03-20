<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Portal</title> 
     <link rel="icon" href="./assets/images/LOGO alumni.png">
     <link rel="stylesheet" href="./assets/login.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
  <body>
    <div class="content">
    <div class="container">
    <div class="wrapper">
    <div class="title">
    <div class="logo-section">
      <img src="./assets/images/LOGO alumni.png" alt="Logo" class="logo">
    </div>
        <span>ALUMNI</span>
    </div>
    <form action="" method="POST">
    <div class="row">
        <i class="fa fa-id-badge"></i>
          <input type="text" name="alumni ID" placeholder="Alumni ID" required>
    </div>
          <div class="row">
             <i class="fas fa-user"></i>
             <input type="password" name="username" placeholder="Username" required>
          </div>
          <div class="row">
             <i class="fas fa-lock"></i>
             <input type="password" name="password" placeholder="Password" required>
          </div>
          <div class="row button">
             <input type="submit" value="Login">
          </div>
        </form>
        <div class="sign button">
          <a href="signup.php"><button type="button">Sign Up</button></a>
        </div>
    </div>
  </body>
</html>