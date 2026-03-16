<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventify</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="page">
        <header class="top-bar">
            <h1 class="logo">Eventify</h1>
            <nav>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="btn primary">Go to Dashboard</a>
                    <a href="logout.php" class="btn ghost">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn primary">Login</a>
                    <a href="register.php" class="btn ghost">Register</a>
                <?php endif; ?>
            </nav>
        </header>

        <main class="hero">
            <div class="hero-text">
                <h2>Simple event portal for organizers and students</h2>
                <p>Organizers can manage events, students can browse and book them – all in a very small demo app.</p>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <div class="hero-actions">
                        <a href="register.php" class="btn primary">Get Started</a>
                        <a href="login.php" class="btn ghost">I already have an account</a>
                    </div>
                <?php else: ?>
                    <div class="hero-actions">
                        <a href="dashboard.php" class="btn primary">Open my dashboard</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
