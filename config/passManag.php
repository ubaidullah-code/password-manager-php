<?php
    include "databaseConnection.php";

?>
<?php

    define('CIPHER', 'AES-256-CBC');
    define('IV_LENGTH', 16); // 16 bytes for AES
    define('ENCRYPTION_KEY', hex2bin('0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef')); 
// ↑ MUST be exactly 32 bytes

    function encrypt($text)
    {
        $iv = random_bytes(IV_LENGTH);

        $encrypted = openssl_encrypt(
            $text,
            CIPHER,
            ENCRYPTION_KEY,
            OPENSSL_RAW_DATA,
            $iv
        );

        return bin2hex($iv) . ':' . bin2hex($encrypted);
    }
?>

<?php

    function decrypt($text)
    {
        list($ivHex, $encryptedHex) = explode(':', $text);

        $iv = hex2bin($ivHex);
        $encryptedText = hex2bin($encryptedHex);

        $decrypted = openssl_decrypt(
            $encryptedText,
            CIPHER,
            ENCRYPTION_KEY,
            OPENSSL_RAW_DATA,
            $iv
        );

        return $decrypted;
    }
?>



<?php 

if(isset($_POST['handleSave']))
{
    session_start();
    $webname = trim($_POST['webName']) ?? ""; // serviceName
    $weburl = trim($_POST['weburl']) ?? ""; //website url
    $webpass = trim($_POST['webpass']) ?? ""; // website password
    if($webname === "" || $weburl === ""|| $webpass === "")
        {
            $_SESSION['managePassError']  = "Required Perameter is missing";
            
            header("location: ../passManage.php");
            exit;
        }
        /// encrypted
        $encrypted = encrypt($webpass);
        // decrypted
        
// $decrypted = decrypt($encrypted);

    $sql = "INSERT INTO password_store (user_id ,serivceName , userName , password ,siteUrl) VALUES (?,?,?,?,?)";
    $result = $conn->prepare($sql);
    $result->bind_param('issss',  $_SESSION['user_id'], $webname , $_SESSION['email'] ,$encrypted , $weburl);
    $result->execute();

    header('location: ../passManage.php');
   
    exit;

   



}
?>

<!-- Delete  -->

<?php 
    if(isset($_POST['handleDelete']))
    {
        $pass_id = $_POST['pass_id']?? "";

        try {
            $sql = "DELETE FROM password_store WHERE pass_id = ?";
            $result = $conn->prepare($sql);
            $result->bind_param('i', $pass_id);
            $result->execute();
            header('location: ../passManage.php');
            exit();
          
        } catch (error $err) {
        echo "$err";
        }
    }
  
    

?>

<!-- Logout password -->

<?php 

if (isset($_POST['handleLogout'])) {
    session_start();
    session_destroy();
    session_unset();

    header('location: ../login.php');
    exit();
}
?>

<?php

if (isset($_POST['handleUpdate'])) {
    $id = $_POST['pass_id'];
    $name = $_POST['webName'];
    $url = $_POST['weburl'];
    $pass = encrypt($_POST['webpass']); // Encrypt again before saving

    $sql = "UPDATE password_store SET serivceName=?, siteUrl=?, password=? WHERE pass_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $url, $pass, $id);
    
    if($stmt->execute()) {
        header("Location: ../passManage.php?success=updated");
    } else {
        $_SESSION['managePassError'] = "Update failed.";
        header("Location: ../passManage.php");
    }
}
?>