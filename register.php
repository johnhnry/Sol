<?php session_start(); ?>
<?php
    include('connect/connection.php');

    if(isset($_POST["register"])){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $check_query = mysqli_query($connect, "SELECT * FROM login where email ='$email'");
        $rowCount = mysqli_num_rows($check_query);

        if(!empty($email) && !empty($password)){
            if($rowCount > 0){
                ?>
                <script>
                    alert("User with email already exist!");
                </script>
                <?php
            }else{
                $password_hash = password_hash($password, PASSWORD_BCRYPT);
                $form = mysqli_query($connect, "INSERT INTO forms (Form1Status,Form2Status, Form3Status, Form4Status) VALUES (0,0,0,0)");
                $result = mysqli_query($connect, "INSERT INTO login (fname, lname, email, password, status) VALUES ('$fname','$lname','$email', '$password_hash', 0)");
    
                if($result){
                    $otp = rand(100000,999999);
                    $_SESSION['otp'] = $otp;
                    $_SESSION['mail'] = $email;
                    require "Mail/phpmailer/PHPMailerAutoload.php";
                    $mail = new PHPMailer;
    
                    $mail->isSMTP();
                    $mail->Host='smtp.gmail.com';
                    $mail->Port=587;
                    $mail->SMTPAuth=true;
                    $mail->SMTPSecure='tls';
    
                    $mail->Username='ktorreliza49@gmail.com';
                    $mail->Password='tesuuwlboqrpnknx';
    
                    $mail->setFrom('ktorreliza49@gmail.com', 'OTP Verification');
                    $mail->addAddress($_POST["email"]);
    
                    $mail->isHTML(true);
                    $mail->Subject="Welcome to E MOOD";
                    $mail->Body="<p>Dear user, </p> <h3>Your verify OTP code is $otp <br></h3>
                    <br><br>
                    <p>Thank you for Choosing Emood,</p>";
    
                            if(!$mail->send()){
                                ?>
                                    <script>
                                        alert("<?php echo "Register Failed, Invalid Email "?>");
                                    </script>
                                <?php
                            }else{
                                ?>
                                <script>
                                    alert("<?php echo "Register Successfully, OTP sent to " . $email ?>");
                                    window.location.replace('verification.php');
                                </script>
                                <?php
                            }
                }
            }
        }
    }

?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>Register Form</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">Register Form</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php" >Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php" style="font-weight:bold; color:black; text-decoration:underline">Register</a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form action="#" method="POST" name="register">
                        <div class="name-details">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">First Name</label>
                            <div class="col-md-6">
                                <input type="text" name="fname" class="form-control" placeholder="First name" required>
                        </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Last Name</label>
                            <div class="col-md-6"> 
                                <input type="text" name="lname" class="form-control" placeholder="Last name" required>
                        </div>
                        </div>
                        </div>
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" placeholder="Email" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="password" required>
                                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                                </div>
                            </div>
                            


                            <div class="form-group row">
                            
                             <label class="col-md-4 col-form-label text-md-right">Select Image</label>
                             <div class="col-md-6">
                                 <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                              </div>
                                
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Register" name="register">
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>
</body>
</html>
<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function(){
        if(password.type === "password"){
            password.type = 'text';
        }else{
            password.type = 'password';
        }
        this.classList.toggle('bi-eye');
    });
</script>
