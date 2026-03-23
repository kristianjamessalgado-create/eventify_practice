<?php
session_start();
include 'db.php';

$error = '';

if (isset($_POST['submit'])) {
    $email = trim($_POST['email'] ?? '');
    $password = ($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'Please enter both email and password.';
    } else {
        $emailEscaped = mysqli_real_escape_string($conn, $email);
        $passwordEscaped = mysqli_real_escape_string($conn, $password);

        $sql = "SELECT id, name, email, role FROM users WHERE email = '$emailEscaped' AND password = '$passwordEscaped' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role']; 
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Eventify</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-card">
            <h1>Login</h1>
            <p class="muted">Access your Eventify dashboard.</p>

            <?php if ($error): ?>
                <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="login.php" method="post" class="form">
                <label>
                    <span>Email</span>
                    <input type="email" name="email" placeholder="you@example.com" required>
                </label>
                <label>
                    <span>Password</span>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                        <button type="button" class="link-button" onclick="togglePassword()">Show</button>
                    </div>
                </label>

                <button type="submit" name="submit" class="btn primary full-width">Login</button>
            </form>

            <p class="muted small">No account yet?
                <a href="register.php">Register as student or organizer</a>
            </p>
            <p class="muted small"><a href="index.php">Back to home</a></p>
        </div>
    </div>

    <script>
    function togglePassword() {
      var passwordField = document.getElementById('password');
      if (passwordField.type === "password") {
        passwordField.type = "text";
      } else {
        passwordField.type = "password";
      }
    }
    </script>
</body>
</html>