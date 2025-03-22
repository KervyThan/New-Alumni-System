<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alumni Portal | Registration</title>
  <link rel="icon" href="./assets/images/LOGO alumni.png">
  <link rel="stylesheet" href="./assets/signup.css">
</head>

<body>
  <div class="container">
    <div class="title">
      <div class="logo-section">
        <img src="./assets/images/LOGO alumni.png" alt="Logo" class="logo">
      </div>
      <span>ALUMNI</span>
    </div>

    <div class="content">
      <form action="./config/signup.php" method="POST">
        <div class="user-details">

          <div class="input-box">
            <span class="details">First Name</span>
            <input type="text" placeholder="Enter your first name" required>
          </div>

          <div class="input-box">
            <span class="details">Middle Name</span>
            <input type="text" placeholder="Enter your middle name" required>
          </div>

          <div class="input-box">
            <span class="details">Last Name</span>
            <input type="text" placeholder="Enter your last name" required>
          </div>

          <div class="input-box">
            <span class="details">Course</span>
            <input type="text" placeholder="Enter your course" required>
          </div>
          <div class="input-box">
            <span class="details">Batch</span>
            <input type="text" placeholder="Enter your batch" required>
          </div>

          <div class="input-box">
            <span class="details">Year Graduated</span>
            <input type="text" placeholder="Enter the year graduated" required>
          </div>

          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" placeholder="Enter your email" required>
          </div>

          <div class="input-box">
            <span class="details">Alumni ID</span>
            <input type="text" placeholder="Enter your Alumni ID" required>
          </div>

          <div class="input-box">
            <span class="details">User Name</span>
            <input type="text" placeholder="Enter your user name" required>
          </div>

          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" placeholder="Enter your password" required>
          </div>
        </div>

        <div class="button">
          <input type="submit" value="Register">
        </div>

        <div class="button">
          <a href="login.php"><input type="button" value="Login"></a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
