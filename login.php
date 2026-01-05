<?php
include './config/databaseConnection.php';

// Start session if not already started (required for session alerts)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Login - Password Manager</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background-color: #44444E;
            color: white;
        }

        .login-card {
            background-color: #212529;
            /* Dark grey/black card */
            border: 1px solid #495057;
            max-width: 450px;
            width: 100%;
        }

        .form-control {
            background-color: #2b2f32;
            border: 1px solid #495057;
            color: white;
        }

        .form-control:focus {
            background-color: #2b2f32;
            color: white;
            border-color: #0d6efd;
            box-shadow: none;
        }

        .form-control::placeholder {
            color: #adb5bd;
        }
    </style>
</head>

<body>

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

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-card shadow-lg p-4 rounded-3">
            <form method="post" action="./config/phpLogic.php">
                <h1 class="text-center mb-4">Login</h1>

                <div class="mb-3">
                    <label for="userEmail" class="form-label fs-5 fw-semibold">Email</label>
                    <input 
                        type="email" 
                        class="form-control form-control-lg" 
                        name="userEmail" 
                        id="userEmail" 
                        placeholder="Enter your email" 
                        required />
                </div>

                <div class="mb-3">
                    <label for="userPass" class="form-label fs-5 fw-semibold">Password</label>
                    <input 
                        type="password" 
                        class="form-control form-control-lg" 
                        name="userPass" 
                        id="userPass" 
                        placeholder="Enter your password" 
                        required />
                </div>

                <div class="mb-3">
                    <a class="text-info text-decoration-none" href="signup.php">
                        Don't have an account yet? Signup
                    </a>
                </div>

                <div class="d-grid">
                    <button 
                        name="handleLogin" 
                        type="submit" 
                        class="btn text-white btn-lg mt-2" 
                        style="background-color: #0c3635; border: 1px solid #145a58;">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>