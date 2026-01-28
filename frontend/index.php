<?php 
session_start();
if(isset($_SESSION['dept_no'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loyola eCard | Login</title>
    <link rel="stylesheet" href="./styles/common.css" />
    <link rel="stylesheet" href="./styles/index.css" />
    <script src="https://kit.fontawesome.com/bef2386e82.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="card-header">
                <img src="./assets/logo.png" class="logo">
                <h1>Loyola eCard</h1>
                <p class="subtitle">Welcome Back</p>
            </div>

            <?php 
            if(isset($_GET['error']) || isset($_GET['err'])): 
                $errorMessage = isset($_GET['error']) ? $_GET['error'] : $_GET['err'];
            ?>
            <div class="error-message">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
            <?php endif; ?>

            <form action="../backend/process_login.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="dept_no">
                        <i class="fa-regular fa-user"></i>
                        Department Number
                    </label>
                    <input 
                        type="text" 
                        id="dept_no"
                        name="dept_no" 
                        placeholder="Enter your department number"
                        required
                 />
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fa-solid fa-lock"></i>
                        Password
                    </label>
                    <div class="password-input">
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            placeholder="Enter your password"
                            required
                        />
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Sign In
                </button>
            </form>

            <div class="card-footer">
                <p>Loyola eCard. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>