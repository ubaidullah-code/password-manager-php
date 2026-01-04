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