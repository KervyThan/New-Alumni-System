<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dean PORTAL</title>
    <link rel="icon" href="../assets/images/LOGO alumni.png">
    <link rel="stylesheet" href="../assets/landingpage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="navbar">
            <img src="../assets/images/LOGO alumni.png" alt="Logo" class="logo">
            <h1>DEAN PORTAL</h1>

            <nav>
                <ul>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="../login.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <label for="year">Year Graduated:</label>
                <select id="year" class="form-select" name="year">
                    <option value="all">All</option>
                    <option value="2020">2015-2018</option>
                    <option value="2021">2018-2021</option>
                    <option value="2022">2021-2024</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="batch">Batch:</label>
                <select id="batch" class="form-select" name="batch">
                    <option value="all">All</option>
                    <option value="batch1">Batch 1</option>
                    <option value="batch2">Batch 2</option>
                    <option value="batch3">Batch 3</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="course">Course:</label>
                <select id="course" class="form-select" name="course">
                    <option value="all">All</option>
                    <option value="BSCS">BSCS</option>
                    <option value="ACT">ACT</option>
                    <option value="BSIT">BSIT</option>
                </select>
            </div>
        </div>
        <button class="btn btn-primary mt-2" onclick="filterResults()">Filter</button>
    </div>

    <table class="table" style="margin: 30px; margin-top: 20px;">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Year Graduated</th>
                <th>Batch</th>
            </tr>
        </thead>
        <tbody>
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

            // Getting filter parameters from GET request
            $course = isset($_GET['course']) ? $_GET['course'] : 'BSCS'; // Default to BSCS
            $year = isset($_GET['year']) ? $_GET['year'] : 'all';
            $batch = isset($_GET['batch']) ? $_GET['batch'] : 'all';

            $recordsPerPage = 8;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $startFrom = ($currentPage - 1) * $recordsPerPage;

            // Constructing the SQL query
            $sql = "SELECT * FROM alumni_details WHERE course IN ('BSCS', 'ACT', 'BSIT')"; // Only show these 3 courses

            if ($year != 'all') {
                $sql .= " AND year_graduated = '$year'";
            }
            if ($batch != 'all') {
                $sql .= " AND batch = '$batch'";
            }

            $sql .= " LIMIT $startFrom, $recordsPerPage"; // Pagination

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row['first_name']."</td>
                            <td>".$row['middle_name']."</td>
                            <td>".$row['last_name']."</td>
                            <td>".$row['email']."</td>
                            <td>".$row['course']."</td>
                            <td>".$row['year_graduated']."</td>
                            <td>".$row['batch']."</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No results found</td></tr>";
            }

            // Calculate total records for pagination
            $sqlTotal = "SELECT COUNT(*) FROM alumni_details WHERE course IN ('BSCS', 'ACT', 'BSIT')";
            if ($year != 'all') {
                $sqlTotal .= " AND year_graduated = '$year'";
            }
            if ($batch != 'all') {
                $sqlTotal .= " AND batch = '$batch'";
            }
            $resultTotal = $conn->query($sqlTotal);
            $totalRecords = $resultTotal->fetch_row()[0];
            $totalPages = ceil($totalRecords / $recordsPerPage);

            $conn->close();
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
