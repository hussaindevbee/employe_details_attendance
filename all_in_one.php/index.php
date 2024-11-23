<?php
$con = mysqli_connect("localhost", "root", "", "dummy");
if ($con->connect_errno) {
    echo $con->connect_error;
}

// Number of records per page
$records_per_page = 10;

// Calculate the current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $records_per_page;

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_query = '';
if ($search) {
    $search_query = "WHERE Name LIKE '%$search%' OR Age LIKE '%$search%' OR Phone LIKE '%$search%'";
}

// Query with LIMIT for pagination and search
$sql = "SELECT EmployeeId, Name, Phone, Address, Age, Gender, Salary, City, State 
        FROM employee_details 
        $search_query
        ORDER BY EmployeeId DESC 
        LIMIT $start_from, $records_per_page";
$result = $con->query($sql);

// Total records
$total_records_query = "SELECT COUNT(*) AS total FROM employee_details $search_query";
$total_records_result = $con->query($total_records_query);
$total_records_row = $total_records_result->fetch_assoc();
$total_records = $total_records_row['total'];
$total_pages = ceil($total_records / $records_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COLLECTING EMPLOYEE DETAILS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container"> 
        <div class="cd-md-9"> 
            <div class="card">
                <div class="card-header">
                    <h1>EMPLOYEE ALL DETAILS</h1>
                </div>
                
                <!-- Search Form -->
                <form class="mb-3" method="GET" action="">
                    <input type="text" name="search" class="form-control" placeholder="Search by Name, Age, or Phone" value="<?= htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-primary mt-2">Search</button>
                    <a href="index.php" class="btn btn-secondary mt-2">Reset</a>
                </form>

                <div class="d-flex">
                <!-- Attendance page -->
                <form action="attendance.php">
                 <button class="btn btn-danger">Attendance</button>
                </form>

                <!-- New user data button -->
                 <form action="details.php">
                <button class="btn btn-secondary">NEW USER</button>
                </form>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">S.NO</th>
                                <th scope="col">NAME</th>
                                <th scope="col">PHONE</th>
                                <th scope="col">ADDRESS</th>
                                <th scope="col">AGE</th>
                                <th scope="col">GENDER</th>
                                <th scope="col">SALARY</th>
                                <th scope="col">CITY</th>
                                <th scope="col">STATE</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ($result->num_rows) {
                                while ($row = $result->fetch_object()) { ?>
                                    <tr>
                                        <td scope="col"><?= $row->EmployeeId; ?></td>
                                        <td scope="col"><?= $row->Name; ?></td>
                                        <td scope="col"><?= $row->Phone; ?></td>
                                        <td scope="col"><?= $row->Address; ?></td>
                                        <td scope="col"><?= $row->Age; ?></td>
                                        <td scope="col"><?= $row->Gender; ?></td>
                                        <td scope="col"><?= $row->Salary; ?></td>
                                        <td scope="col"><?= $row->City; ?></td>
                                        <td scope="col"><?= $row->State; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-danger">
                                                <a href="edit.php?id=<?= $row->EmployeeId; ?>" class="text-light">EDIT</a>
                                            </button>
                                            <button type="button" onclick="confirmDelete(<?= $row->EmployeeId; ?>)" class="btn btn-danger">DELETE</button>
                                        </td>
                                    </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page - 1; ?>&search=<?= urlencode($search); ?>">&laquo;</a>
                            </li>
                        <?php endif; ?>
                        <li class="page-item <?= ($page == 1) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=1&search=<?= urlencode($search); ?>">1</a>
                        </li>
                        <?php if ($page > 3): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <?php for ($i = max(2, $page - 1); $i <= min($total_pages - 1, $page + 1); $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($page < $total_pages - 2): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <?php if ($total_pages > 1): ?>
                            <li class="page-item <?= ($page == $total_pages) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $total_pages; ?>&search=<?= urlencode($search); ?>"><?= $total_pages; ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page + 1; ?>&search=<?= urlencode($search); ?>">&raquo;</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(employeeId) {
            let confirmAction = confirm("Are you sure you want to delete this data?");
            if (confirmAction) {   
                window.location.href = "delet.php?id=" + employeeId;
            } else {
                alert("Data will not be deleted");
            }
        }
    </script>
</body>
</html>
