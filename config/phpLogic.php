<?php
include './databaseConnection.php';
session_start();
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
        $_SESSION['SignupError'] = "Required perameter is missing";
        header("location: ../signup.php");
        exit();
    }
    $email = strtolower($email);
    $hash = password_hash($pass, PASSWORD_ARGON2ID);

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

header("Location: ../login.php");
exit;
    
    }

?>

<!-- Login Logic -->
<?php
    if(isset($_POST['handleLogin']))
    {

      $email = trim($_POST['userEmail'] ?? '');
    $pass  = trim($_POST['userPass'] ?? '');

    if($email === "" || $pass === "")
    {
        $_SESSION['loginError'] = "Required perameter is missing";
         header('location: ../login.php');
     exit; 
       
    }
$email = strtolower($email);
$sqlQuery = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sqlQuery);
$stmt->bind_param('s', $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['loginError'] = "User doesn't exist with this email";
    header('location: ../login.php');
    exit;
}
  $user = $result->fetch_assoc();
  $check = password_verify($pass, $user['password']); 
   
    if(!password_verify($pass , $user['password']))
    { 
         $_SESSION['loginError'] = "Password does not match";
          header('location: ../login.php');
    exit;
    }
    $_SESSION['username'] = $user['userName'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['user_id'] = $user['user_id'];
        header('location: ../passManage.php');
    exit;
    


    }
   



?>