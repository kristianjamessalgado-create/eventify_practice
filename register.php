<?php
session_start();
include 'db.php';

$error = '';
$success = '';

if (isset($_POST['submit'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm_password'] ?? '');
    $role = $_POST['role'] ?? 'student';

    if ($name === '' || $email === '' || $password === '' || $confirm === '') {
        $error = 'All fields are required.';
    } elseif (!in_array($role, ['organizer', 'student'], true)) {
        $error = 'Invalid role.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $nameEscaped = mysqli_real_escape_string($conn, $name);
        $emailEscaped = mysqli_real_escape_string($conn, $email);
        $passwordEscaped = mysqli_real_escape_string($conn, $password);
        $roleEscaped = mysqli_real_escape_string($conn, $role);

        // Check for existing email
        $checkSql = "SELECT id FROM users WHERE email = '$emailEscaped' LIMIT 1";
        $checkResult = mysqli_query($conn, $checkSql);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            $error = 'Email is already registered.';
        } else {
            $insertSql = "INSERT INTO users (name, email, password, role) 
                          VALUES ('$nameEscaped', '$emailEscaped', '$passwordEscaped', '$roleEscaped')";
            if (mysqli_query($conn, $insertSql)) {
                $success = 'Registration successful. You can now log in.';
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Eventify</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-card">
            <h1>Create account</h1>
            <p class="muted">Sign up as an organizer or student.</p>

            <?php if ($error): ?>
                <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form action="register.php" method="post" class="form">
                <label>
                    <span>Name</span>
                    <input type="text" name="name" placeholder="Your name" required>
                </label>
                <label>
                    <span>Email</span>
                    <input type="email" name="email" placeholder="you@example.com" required>
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" placeholder="Choose a password" required>
                </label>
                <label>
                    <span>Confirm password</span>
                    <input type="password" name="confirm_password" placeholder="Repeat password" required>
                </label>
                <label>
                    <span>Role</span>
                    <select name="role" required>
                        <option value="student">Student</option>
                        <option value="organizer">Organizer</option>
                    </select>
                </label>

                <button type="submit" name="submit" class="btn primary full-width">Register</button>
            </form>

            <p class="muted small">Already have an account? <a href="login.php">Login</a></p>
            <p class="muted small"><a href="index.php">Back to home</a></p>
        </div>
    </div>
</body>
</html>

