<?php
// include './config/databaseConnection.php';
include "./config/passManag.php";
?>
<?php

$SQL = "SELECT * FROM password_store WHERE user_id = {$_SESSION['user_id']}  ";
$result = $conn->query($SQL);;


?>

<?php
if (isset($_SESSION['managePassError'])) {
    echo "
    <div class='alert alert-warning alert-dismissible fade show
                position-fixed top-0 start-50 translate-middle-x mt-3'
         style='z-index:1055;'>
        {$_SESSION['managePassError']}
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>
    ";
    unset($_SESSION['managePassError']);
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <style>
        body>.main,
        html {
            background-color: #44444E;
        }
        .div-table{
             min-height: calc(100vh - 70px - 60px);
        }
    </style>

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
</head>

<body>
    <nav
        class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm"
    >
        <div class="container">
            <a class="navbar-brand" href="#">Password Manager</a>
         
            
                <form class="d-flex my-2 my-lg-0">
                   <button
            type="button"
            class="btn btn-dark border btn-md me-2"
            data-bs-toggle="modal"
            data-bs-target="#modalId">
            Add Details
        </button>
          <button
            type="button"
            class="btn btn-dark border-start border-end  btn-md"
        >
            Logout
        </button>
                </form>
            </div>
        </div>
    </nav>
    
    <div>

        <div
            class="modal fade"
            id="modalId"
            tabindex="-1"
            data-bs-backdrop="static"
            data-bs-keyboard="false"

            role="dialog"
            aria-labelledby="modalTitleId"
            aria-hidden="true">
            <div
                class="modal-dialog text-light modal-dialog-scrollable  modal-dialog-centered modal-lg"
                role="document">
                <form method="post" action="./config/passManag.php" class="modal-content bg-dark">
                    <div class="modal-header">
                        <h2 class="modal-title" id="modalTitleId">
                            Add Password
                        </h2>
                        <button
                            type="button"
                            class="btn-close bg-light text-light"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label fs-5 fw-semibold">Website Name</label>
                            <input
                                type="text"
                                class="form-control "
                                name="webName"
                                id=""
                                aria-describedby="helpId"
                                placeholder="Enter website name" />
                            <label for="" class="form-label fs-5 fw-semibold">Website Url</label>
                            <input
                                type="text"
                                class="form-control"
                                name="weburl"
                                id=""
                                aria-describedby="helpId"
                                placeholder="Enter website url" />
                            <label for="" class="form-label fs-5 fw-semibold">Website Password</label>
                            <input
                                type="text"
                                class="form-control"
                                name="webpass"
                                id=""
                                aria-describedby="helpId"
                                placeholder="Enter password" />

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" name="handleSave" class="btn border text-light" data-bs-dismiss="modal">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Optional: Place to the bottom of scripts -->


    </div>
    <div class="main ">
        <div
            class="table-responsive div-table ">
            <table
                class=" mt-2  table table-striped table-hover table-borderless table-dark align-middle">
                <thead class="table-light ">
                    <caption class="text-light text-center text-decoration-underline ">
                        Password Manager
                    </caption>
                    <tr class="text-center">
                        <th>Website Name</th>
                        <th>Website Url</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider text-center ">
                 
                    <?php
                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['serivceName']}</td>";
                            echo "<td><a class='fs-5 text-info' target=_blank href={$row['siteUrl']}
                    >Website Link</a></td>";
                            echo "<td>" . decrypt($row['password']) . "</td>";
                            echo "<td>
                            <button class='btn btn-danger'>Delete</button>
                            <button class='btn border-bottom text-light px-3 '>Edit</button>
                            </td>";
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>

            </table>
        </div>
     
    </div>
    <footer class="bg-dark text-light text-center py-3 mt-3">
  <div class="container">
    <p class="mb-0">
      © <?php echo date('Y'); ?> Password Manager. All rights reserved.
    </p>
  </div>
</footer>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script>
        const myModal = new bootstrap.Modal(
            document.getElementById("modalId"),
            options,
        );
    </script>
</body>

</html>