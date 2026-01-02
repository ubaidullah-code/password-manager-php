<?php
include './databaseConnection.php';
?>

<!-- Sign-Up logic -->

<?php
    if(isset($_POST['handleSignUp']))
    {
       extract($_POST);
       $username = $userName;
       $email = $userEmail;
       $pass = $userPass;
    if($username === "" || $email === "" || $pass === "")
    {
        $_SESSION['SignupError'] = "Please fill all the requirements";
    }
    $email = strtolower($email);
    $hash = password_hash($password, PASSWORD_ARGON2ID);

    $loginTIme = date('Y-m-d H:i:s');
    $sqlQuery = "INSERT INTO users (userName, email , password, last_login) VALUES (?,?,?,?)";
    $result = $conn->prepare($sqlQuery);
    $result->bind_param('ssss',$username , $email ,$hash ,$loginTIme);
  try {
    $result->execute();
    $_SESSION['SignupSuccess'] = "Registration successful!";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) { // 1062 = Duplicate entry
        $_SESSION['SignupError'] = "Email already exists!";
    } else {
        $_SESSION['SignupError'] = "Something went wrong: " . $e->getMessage();
    }
}
$_SESSION['SignUpSuccess'] ="user successFully added";
header("Location: ../signup.php");
exit;
    
    }

?>

<!-- Login Logic -->
<?php
    if(isset($_POST['handleLogin']))
    {
        echo "Login";
    }

?>