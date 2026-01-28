<?php
if (!isset($current_page)) {
    $current_page = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyola eCard</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="./styles/common.css">
    <link rel="stylesheet" href="./styles/nav.css">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <script src="https://kit.fontawesome.com/bef2386e82.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="assets/logo.png" alt="Loyola eCard" width="150px" height="150px" style="display: flex; justify-content: center; align-items: center;">
                <h1 class="logo-text">Loyola eCard</h1>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-gauge"></i>
                    <span>Dashboard</span>
                </a>
                <a href="funduser.php" class="nav-item <?php echo $current_page === 'funduser' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                    <span>Make Payment</span>
                </a>
                <a href="users.php" class="nav-item <?php echo $current_page === 'users' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-users"></i>
                    <span>User Management</span>
                </a>
                <a href="logs.php" class="nav-item <?php echo $current_page === 'logs' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-book"></i>
                    <span>Logs</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <form action="../backend/process_logout.php" method="POST" class="logout-form">
                    <button type="submit" class="logout-btn">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Top Navigation Header -->
            <header class="nav-header">
                <h2 class="nav-header-title">
                    <?php 
                    switch($current_page) {
                        case 'dashboard':
                            echo 'Dashboard';
                            break;
                        case 'funduser':
                            echo 'Make Payment';
                            break;
                        case 'users':
                            echo 'User Management';
                            break;
                        case 'logs':
                            echo 'Logs';
                            break;
                        default:
                            echo 'Loyola eCard';
                    }
                    ?>
                </h2>
                <div class="nav-header-user">
                    <div class="user-info">
                        <div class="user-name"><?php echo $_SESSION['username']; ?></div>
                    </div>
                </div>
            </header>

            <!-- Page content will be injected here -->
            <div class="content-wrapper">
                <?php if(isset($content)) echo $content; ?>
            </div>
        </main>
    </div>
</body>
</html>