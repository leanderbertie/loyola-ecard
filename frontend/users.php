<?php 
session_start();
if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $current_page = 'users';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loyola eCard | User Management</title>
    <link rel="stylesheet" href="./styles/common.css" />
    <link rel="stylesheet" href="./styles/users.css" />
    <script src="https://kit.fontawesome.com/bef2386e82.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <?php include './components/nav.php'; ?>
        <main class="main-content">
            <header class="top-header">
                <div class="header-content">
                    <h1>User Management</h1>
                    <div class="header-actions">
                        <div class="search-box">
                            <i class="fa-solid fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search users...">
                        </div>
                        <a href="newuser.php" class="create-user-btn">
                            <button type="submit" class="process-btn">
                                <i class="fa-solid fa-user-plus"></i>
                                <div class="header-content">
                                    <span>Create New User</span>
                                </div>
                            </button>
                        </a>
                    </div>
                </div>
            </header>

            <div class="users-content">
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Student Name</th>
                                    <th>Department Number</th>
                                    <th>Card Number</th>
                                    <th>Balance</th>
                                    <th>Registration Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../backend/db_conn.php";
                                $fetch_users = mysqli_query($conn, "SELECT * FROM students_data WHERE dept_no != 'Admin'");
                                
                                $sn = 1;
                                while($res = mysqli_fetch_assoc($fetch_users)){
                                ?>
                                <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td>
                                        <div class="user-info">
                                            <span><?php echo htmlspecialchars($res['name']); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($res['dept_no']); ?></td>
                                    <td><?php echo htmlspecialchars($res['card_number']); ?></td>
                                    <td>
                                        <span class="balance">
                                            ₹<?php echo number_format($res['balance'], 2); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($res['date_created'])); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn edit" title="Edit User">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button class="action-btn view" title="View Details">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php $sn++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let searchQuery = this.value.toLowerCase();
        let tableRows = document.querySelectorAll('.users-table tbody tr');
        
        tableRows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchQuery) ? '' : 'none';
        });
    });
    </script>
</body>
<?php 
}else{
	header("location: ./index.php");
} 
?>