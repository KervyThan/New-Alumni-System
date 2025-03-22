<?php
// Database connection
$servername = "localhost";
$username = "root";       
$password = "";
$dbname = "alumni_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Getting filter parameters from GET request and initializing default values
$course = isset($_GET['course']) ? $_GET['course'] : 'all';  // Default to 'all'
$year = isset($_GET['year']) ? $_GET['year'] : 'all';
$batch = isset($_GET['batch']) ? $_GET['batch'] : 'all';

$recordsPerPage = 8;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$startFrom = ($currentPage - 1) * $recordsPerPage;

// Constructing the SQL query with prepared statements
$sql = "SELECT ad.*, u.username FROM alumni_details ad
        JOIN users u ON ad.alumni_id = u.alumni_id
        WHERE ad.course IN ('BSCS', 'ACT', 'BSIT')";

// Apply filters
if ($year != 'all') {
    $sql .= " AND ad.year_graduated = ?";
}
if ($batch != 'all') {
    $sql .= " AND ad.batch = ?";
}

$sql .= " LIMIT ?, ?";

// Preparing and executing the query
$stmt = $conn->prepare($sql);

if ($year != 'all' && $batch != 'all') {
    $stmt->bind_param("ssii", $year, $batch, $startFrom, $recordsPerPage);
} elseif ($year != 'all') {
    $stmt->bind_param("sii", $year, $startFrom, $recordsPerPage);
} elseif ($batch != 'all') {
    $stmt->bind_param("sii", $batch, $startFrom, $recordsPerPage);
} else {
    $stmt->bind_param("ii", $startFrom, $recordsPerPage);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch total records for pagination
$sqlTotal = "SELECT COUNT(*) FROM alumni_details ad
               JOIN users u ON ad.alumni_id = u.alumni_id
               WHERE ad.course IN ('BSCS', 'ACT', 'BSIT')";

if ($year != 'all') {
    $sqlTotal .= " AND ad.year_graduated = ?";
}
if ($batch != 'all') {
    $sqlTotal .= " AND ad.batch = ?";
}

$stmtTotal = $conn->prepare($sqlTotal);

if ($year != 'all' && $batch != 'all') {
    $stmtTotal->bind_param("ss", $year, $batch);
} elseif ($year != 'all') {
    $stmtTotal->bind_param("s", $year);
} elseif ($batch != 'all') {
    $stmtTotal->bind_param("s", $batch);
}

$stmtTotal->execute();
$resultTotal = $stmtTotal->get_result();
$totalRecords = $resultTotal->fetch_row()[0];
$totalPages = ceil($totalRecords / $recordsPerPage);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar PORTAL</title>
    <link rel="stylesheet" href="../assets/landingpage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
    <div class="navbar">
        <img src="../assets/images/LOGO alumni.png" alt="Logo" class="logo">
        <h1>REGISTRAR PORTAL</h1>
        <nav>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="../login.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<form method="GET" action="">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <label for="year">Year Graduated:</label>
                <select id="year" class="form-select" name="year">
                    <option value="all" <?php if ($year == 'all') echo 'selected'; ?>>All</option>
                    <option value="2020" <?php if ($year == '2020') echo 'selected'; ?>>2020</option>
                    <option value="2021" <?php if ($year == '2021') echo 'selected'; ?>>2021</option>
                    <option value="2022" <?php if ($year == '2022') echo 'selected'; ?>>2022</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="batch">Batch:</label>
                <select id="batch" class="form-select" name="batch">
                    <option value="all" <?php if ($batch == 'all') echo 'selected'; ?>>All</option>
                    <option value="Batch 2019" <?php if ($batch == 'Batch 2019') echo 'selected'; ?>>Batch 2019</option>
                    <option value="Batch 2020" <?php if ($batch == 'Batch 2020') echo 'selected'; ?>>Batch 2020</option>
                    <option value="Batch 2021" <?php if ($batch == 'Batch 2021') echo 'selected'; ?>>Batch 2021</option>
                    <option value="Batch 2022" <?php if ($batch == 'Batch 2022') echo 'selected'; ?>>Batch 2022</option>
                    <option value="Batch 2023" <?php if ($batch == 'Batch 2023') echo 'selected'; ?>>Batch 2023</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="course">Course:</label>
                <select id="course" class="form-select" name="course">
                    <option value="BSCS" <?php if ($course == 'BSCS') echo 'selected'; ?>>BSCS</option>
                    <option value="ACT" <?php if ($course == 'ACT') echo 'selected'; ?>>ACT</option>
                    <option value="BSIT" <?php if ($course == 'BSIT') echo 'selected'; ?>>BSIT</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Filter</button>
    </div>
</form>

<div class="container mt-4">
    <button class="btn btn-success mb-3">Create New Alumni</button> <!-- Create button separated -->
</div>

<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Year Graduated</th>
            <th>Batch</th>
            <th>Username</th>
            <th>Actions</th> <!-- Actions column for Update and Delete -->
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['first_name']}</td>
                    <td>{$row['middle_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['course']}</td>
                    <td>{$row['year_graduated']}</td>
                    <td>{$row['batch']}</td>
                    <td>{$row['username']}</td>
                    <td>
                        <button class='btn btn-warning btn-sm'>Update</button>
                        <button class='btn btn-danger btn-sm'>Delete</button>
                    </td>
                </tr>";
            }
        } else {
            echo '<tr><td colspan="9" class="text-center">No results found.</td></tr>';
        }
        ?>
    </tbody>
</table>


    <!-- Pagination Container -->
    <div class="pagination-container">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($currentPage <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&course=<?php echo $course; ?>&year=<?php echo $year; ?>&batch=<?php echo $batch; ?>">Previous</a>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?php if ($i == $currentPage) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&course=<?php echo $course; ?>&year=<?php echo $year; ?>&batch=<?php echo $batch; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>

                <li class="page-item <?php if ($currentPage >= $totalPages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&course=<?php echo $course; ?>&year=<?php echo $year; ?>&batch=<?php echo $batch; ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    <footer>
        <p>&copy; 2025 Alumni System. All rights reserved.</p>
    </footer>
</body>
</html>
