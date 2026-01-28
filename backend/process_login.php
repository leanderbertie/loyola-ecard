<?php
session_start();
include "./db_conn.php";

if(isset($_POST['dept_no']) && isset($_POST['password'])) {
    
    // Validate inputs are not empty
    if(empty($_POST['dept_no']) || empty($_POST['password'])) {
        header("Location: ../frontend/index.php?err=Please fill in all fields");
        exit();
    }

    // Sanitize inputs
    $dept_no = mysqli_real_escape_string($conn, $_POST['dept_no']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // First check if user exists
    $check_sql = "SELECT * FROM students_data WHERE dept_no = ? LIMIT 1";
    $check_stmt = $conn->prepare($check_sql);
    
    if(!$check_stmt) {
        error_log("Prepare failed: " . $conn->error);
        header("Location: ../frontend/index.php?err=Database error");
        exit();
    }

    $check_stmt->bind_param("s", $dept_no);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if($result->num_rows === 0) {
        header("Location: ../frontend/index.php?err=User does not exist!&dept_no=" . urlencode($dept_no));
        exit();
    }

    $user = $result->fetch_assoc();

    // Verify password
    if($user['password'] === $password) {  // In production, use password_verify()
        // Check if user is admin
        $isAdmin = strtolower($user['dept_no']) === 'admin';
        
        // Set session variables
        $_SESSION['username'] = $user['dept_no'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['user_type'] = $isAdmin ? 'admin' : 'student';

        // Redirect based on user type
        if($isAdmin) {
            header("Location: ../frontend/dashboard.php");
        } else {
            header("Location: ../frontend/students/index.php");
        }
        exit();
    } else {
        header("Location: ../frontend/index.php?err=Incorrect password&dept_no=" . urlencode($dept_no));
        exit();
    }
} else {
    header("Location: ../frontend/index.php?err=Invalid request");
    exit();
}

// Add this to catch any unexpected flow
header("Location: ../frontend/index.php?err=Something went wrong");
exit();
?>