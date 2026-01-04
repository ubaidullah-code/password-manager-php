<?php
include './config/databaseConnection.php';
?>
<?php 
if (isset($_SESSION['loginError'])) {
    echo "
    <div class='alert alert-warning alert-dismissible fade show
                position-fixed top-0 start-50 translate-middle-x mt-3'
         style='z-index:1055;'>
        {$_SESSION['loginError']}
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>
    ";
    unset($_SESSION['loginError']);
}

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Login Form</title>
       
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <div class="d-flex justify-content-center align-items-center min-vh-100">
        <form method="post" action="./config/phpLogic.php" class="mb-3 w-50 d-flex flex-column gap-1 shadow-lg py-4 px-3 rounded-3">
                <h1 class="text-center ">Login Form</h1>
                <label for="" class="form-label fs-5 fw-semibold">Email</label>
                <input
                type="email"
                class="form-control"
                name="userEmail"
                id=""
                aria-describedby="helpId"
                placeholder="Please Enter Your Email"
                />
               <label for="" class="form-label fs-5 fw-semibold">Password</label>
               <input
                type="text"
                class="form-control"
                name="userPass"
                id=""
                aria-describedby="helpId"
                placeholder="Please Enter Your Password"
                />
                <a class="fs-5 text-info" href="signup.php"
                    >Don't have an account yet?</a>
                
               
                <button
                    name="handleLogin"
                    type="submit"
                    class="btn  text-white mt-2"
                    style="background-color: 	#0c3635;"
                >
                    Login
                </button>
                
            </div>
        </form>
        
      







        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
