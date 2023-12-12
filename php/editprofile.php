<?php 
     include_once "config.php";
     session_start();

    // Validate and sanitize input
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$new_password = $_POST['password'];
$current_password = md5($_POST['current_password']);

// Get the user's ID from the session
$user_id = $_SESSION['unique_id'];

// Retrieve the current password from the database
$sql_select = "SELECT password FROM users WHERE unique_id = $user_id";
$result = mysqli_query($conn, $sql_select);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $stored_password = $row['password'];
    
    // Verify the current password
    if ($current_password !== $stored_password) {
        $_SESSION['update_profile_error'] = "Current password is incorrect. Profile not updated.";
    } else {
        // If the current password is correct, update the profile
        $password_hash = md5($new_password); // Hash the new password
        $sql_update = "UPDATE users SET fname = '$firstName', lname = '$lastName', password = '$password_hash' WHERE unique_id = $user_id";

        if (mysqli_query($conn, $sql_update)) {
            $_SESSION['update_profile_success'] = "Profile updated successfully!";
        } else {
            $_SESSION['update_profile_error'] = "Error updating profile: " . mysqli_error($conn);
        }
    //   header("location: ../users.php"); 
    }
} else {
    $_SESSION['update_profile_error'] = "Error retrieving current password: " . mysqli_error($conn);
}
// Redirect back to the previous page
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();

?>