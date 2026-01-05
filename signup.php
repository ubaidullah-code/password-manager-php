<?php
include './config/databaseConnection.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Signup - Password Manager</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background-color: #44444E;
            color: white;
        }

        .signup-card {
            background-color: #212529; /* Dark card background */
            border: 1px solid #495057;
            max-width: 500px;
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
    // Error Alert
    if (isset($_SESSION['SignupError'])) {
        echo "
        <div class='alert alert-warning alert-dismissible fade show
                    position-fixed top-0 start-50 translate-middle-x mt-3'
             style='z-index:1055;'>
            {$_SESSION['SignupError']}
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>
        ";
        unset($_SESSION['SignupError']);
    }
    // Success Alert
    else if (isset($_SESSION['SignUpSuccess'])) {
        echo "
        <div class='alert alert-success alert-dismissible fade show
                    position-fixed top-0 start-50 translate-middle-x mt-3'
             style='z-index:1055;'>
            {$_SESSION['SignUpSuccess']}
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>
        ";
        unset($_SESSION['SignUpSuccess']);
    }
    ?>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="signup-card shadow-lg p-4 rounded-3">
            <form method="post" action="./config/phpLogic.php">
                <h1 class="text-center mb-4">Create Account</h1>

                <div class="mb-3">
                    <label for="userName" class="form-label fs-5 fw-semibold">User Name</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="userName" 
                        id="userName" 
                        placeholder="Choose a username" 
                        required />
                </div>

                <div class="mb-3">
                    <label for="userEmail" class="form-label fs-5 fw-semibold">Email</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        name="userEmail" 
                        id="userEmail" 
                        placeholder="Enter your email" 
                        required />
                </div>

                <div class="mb-3">
                    <label for="userPass" class="form-label fs-5 fw-semibold">Password</label>
                    <input 
                        type="password" 
                        class="form-control" 
                        name="userPass" 
                        id="userPass" 
                        placeholder="Create a password" 
                        required />
                </div>

                <div class="mb-3">
                    <a class="text-info text-decoration-none" href="login.php">
                        Already have an account? Login here
                    </a>
                </div>

                <div class="d-grid">
                    <button 
                        type="submit" 
                        name="handleSignUp" 
                        class="btn text-white btn-lg mt-2 fw-semibold" 
                        style="background-color: #0c3635; border: 1px solid #145a58;">
                        Sign Up
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