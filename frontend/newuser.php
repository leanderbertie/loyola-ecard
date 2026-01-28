<?php
session_start();
if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
    $current_page = 'users';
    date_default_timezone_set('Asia/Kolkata');
    if (isset($_GET['card_number'])) {
        $card_number = $_GET['card_number'];
    } else {
        include "../backend/db_conn.php"; 
        $query = "SELECT card_number, created_at FROM temp_cards ORDER BY created_at DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            $card_time = strtotime($row['created_at']);
            $current_time = time();
            if (($current_time - $card_time) <= 20) { 
                $card_number = $row['card_number'];
            } else {
                $card_number = ''; 
            }
        } else {
            $card_number = '';
        }
    }
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loyola eCard | Create New User</title>
    <link rel="stylesheet" href="./styles/common.css" />
    <link rel="stylesheet" href="./styles/newuser.css" />
    <script src="https://kit.fontawesome.com/bef2386e82.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
</head>

<body>
   
        <?php include './components/nav.php'; ?>
        
        <main class="main-content">
            <header class="top-header">
                <div class="user-welcome">
                    <i class="fa-solid fa-user-plus"></i>
                    <h2 class="registration-title">New User Registration</h2>
                </div>
        
            </header>

            <form action="../backend/create_user.php" method="POST" class="registration-form">
                <input type="hidden" name="card_number" value="<?php echo htmlspecialchars($card_number); ?>" />
                <div class="form-row">
                    <div class="form-group">
                        <label for="dept_no">
                            <i class="fa-solid fa-id-card"></i>
                            Department Number
                        </label>
                        <input 
                            type="text" 
                            id="dept_no"
                            name="dept_no" 
                            placeholder="Enter department number"
                            required
                        />
                    </div>

                    <div class="form-group">
                        <label for="name">
                            <i class="fa-solid fa-user"></i>
                            Student's Name
                        </label>
                        <input 
                            type="text" 
                            id="name"
                            name="name" 
                            placeholder="Enter student's full name"
                            required
                        />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="card_id">
                            <i class="fa-solid fa-credit-card"></i>
                            Card ID
                        </label>
                        <input 
                            type="text" 
                            id="card_id"
                            name="card_id" 
                            placeholder="Enter card ID"
                            required
                            value="<?php echo htmlspecialchars($card_number); ?>"
                            readonly
                        />
                        <button onclick="refreshPage()"class="submit-btn">card number</button>

                    </div>

                    <div class="form-group">
                        <label for="amount">
                            <i class="fa-solid fa-money-bill"></i>
                            Initial Balance
                        </label>
                        <div class="input-wrapper">
                            <span class="currency-symbol">₹</span>
                            <input 
                                type="number" 
                                id="amount"
                                name="amount" 
                                placeholder="Enter initial amount"
                                min="0"
                                step="0.01"
                                required
                            />
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">
                            <i class="fa-solid fa-lock"></i>
                            Password
                        </label>
                        <div class="password-group">
                            <input 
                                type="password" 
                                id="password"
                                name="password" 
                                placeholder="Enter your password"
                                required
                            />
                        </div>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="submit-btn">
                        <i class="fa-solid fa-user-plus"></i>
                        Submit
                    </button>
                    <button type="button" class="cancel-btn" onclick="window.location.href='dashboard.php'">
                        <i class="fa-solid fa-times"></i>
                        Cancel
                    </button>
                </div>
            </form>
        </main>
    </div>

<script>
function refreshPage() {
    location.reload(); // Reloads the current page
}
</script>
</body>
</html>
<?php 
} else {
    header("location: ./index.php");
}
?>
