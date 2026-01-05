<?php
include './middleware/auth.php';
include "./config/passManag.php";

$SQL = "SELECT * FROM password_store WHERE user_id = {$_SESSION['user_id']}  ";
// $SQL = "SELECT * FROM password_store";
$result = $conn->query($SQL);
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
    <title>Password Manager</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <style>
        body>.main, html { background-color: #44444E; }
        .div-table { min-height: calc(100vh - 70px - 60px); }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">Password Manager</a>
            <form method="POST" action="./config/passManag.php" class="d-flex my-2 my-lg-0">
                <button type="button" class="btn btn-dark border btn-md me-2" data-bs-toggle="modal" data-bs-target="#modalId" id="addBtn"> 
                    Add Details
                </button>
                <button class="btn btn-dark border-start border-end btn-md" name="handleLogout" type="submit">
                    Logout
                </button>
            </form>
        </div>
    </nav>
    
    <!-- Modal -->
    <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog text-light modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <form method="post" action="./config/passManag.php" class="modal-content bg-dark">
                <div class="modal-header">
                    <h2 class="modal-title" id="modalTitleId">Add Password</h2>
                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Hidden input to store ID for updating -->
                    <input type="hidden" name="pass_id" id="form-pass-id">
                    
                    <div class="mb-3">
                        <label class="form-label fs-5 fw-semibold">Website Name</label>
                        <input type="text" class="form-control" name="webName" id="form-webName" placeholder="Enter website name" required />
                        
                        <label class="form-label fs-5 fw-semibold mt-2">Website Url</label>
                        <input type="text" class="form-control" name="weburl" id="form-weburl" placeholder="Enter website url" required />
                        
                        <label class="form-label fs-5 fw-semibold mt-2">Website Password</label>
                        <input type="text" class="form-control" name="webpass" id="form-webpass" placeholder="Enter password" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- Change name dynamically to handleUpdate if editing -->
                    <button type="submit" id="modalSubmitBtn" name="handleSave" class="btn border text-light">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="main ">
        <div class="table-responsive div-table ">
            <table class=" mt-2 table table-striped table-hover table-borderless table-dark align-middle">
                <thead class="table-light ">
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
                            $decryptedPass = decrypt($row['password']);
                            echo "<tr>";
                            echo "<td>{$row['serivceName']}</td>";
                            echo "<td><a class='fs-5 text-info' target=_blank href='{$row['siteUrl']}'>Link</a></td>";
                            echo "<td>" . $decryptedPass . "</td>";
                            echo "<td>
                                <!-- DELETE -->
                                <form action='./config/passManag.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='pass_id' value='{$row['pass_id']}'>
                                    <button type='submit' name='handleDelete' class='btn btn-danger btn-sm'>Delete</button>
                                </form>

                                <!-- EDIT BUTTON -->
                                <button 
                                    class='btn btn-sm border text-light edit-btn'
                                    data-bs-toggle='modal'
                                    data-bs-target='#modalId'
                                    data-id='{$row['pass_id']}'
                                    data-name='{$row['serivceName']}'
                                    data-url='{$row['siteUrl']}'
                                    data-pass='{$decryptedPass}'
                                    type='button'>
                                    Edit
                                </button>
                            </td>";
                            echo '</tr>';
                        }
                    }
                    else{
                        echo "<tr><td colspan=4>No rows Founded</td></tr>";

                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="bg-dark text-light text-center py-3 mt-3">
        <p class="mb-0">© <?php echo date('Y'); ?> Password Manager.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <script>
        const modalId = document.getElementById('modalId');
        
        modalId.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget;
            
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const url = button.getAttribute('data-url');
            const pass = button.getAttribute('data-pass');

            // Form elements
            const modalTitle = modalId.querySelector('.modal-title');
            const inputId = document.getElementById('form-pass-id');
            const inputName = document.getElementById('form-webName');
            const inputUrl = document.getElementById('form-weburl');
            const inputPass = document.getElementById('form-webpass');
            const submitBtn = document.getElementById('modalSubmitBtn');

            if (id) {
                // EDIT MODE
                modalTitle.textContent = 'Edit Password';
                inputId.value = id;
                inputName.value = name;
                inputUrl.value = url;
                inputPass.value = pass;
                submitBtn.name = 'handleUpdate'; // Change POST name for backend logic
                submitBtn.textContent = 'Update Changes';
            } else {
                // ADD MODE (Reset form)
                modalTitle.textContent = 'Add Password';
                inputId.value = '';
                inputName.value = '';
                inputUrl.value = '';
                inputPass.value = '';
                submitBtn.name = 'handleSave';
                submitBtn.textContent = 'Save';
            }
        });
    </script>
</body>
</html>