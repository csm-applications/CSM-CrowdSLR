<?php

################################################

//Setup here your admin user and password
$user = "admin";
$password = "1234";
################################################




session_start();

if (isset($_POST['username']) && isset($_POST['password'])){
    if($_POST['username'] == $user && $_POST['password'] == $password){
        $_SESSION['username']= $_POST['username'];
        $_SESSION['password']= $_POST['password'];
        $redirect = $_GET['redirect'];
        header('Location: ' . $redirect . '.php');
    }
}


?>
<html>

<?php include 'elements/head.php' ?>

<body class="container">

    <div style="width: 30%; margin: 15vw auto; text-align: center">
        <form method="POST">
            <h1>Login</h1>
            <div class="form-group">
                <input style="margin:10px" class="form-control" type="text" name="username" placeholder="Type your Username">
                <input style="margin:10px" class="form-control" type="password" name="password" placeholder="Type your password">
            </div>
            <input type="submit" class="btn btn-primary" value="Login!">
        </form>
    </div>
</body>
</html>

