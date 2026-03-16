<?php
include 'auth.php';
include 'db.php';

$userName = $_SESSION['user_name'] ?? 'User';
$userRole = $_SESSION['user_role'] ?? 'student';

$events = [];
$eventSql = "SELECT * FROM event ORDER BY event_date ASC";
$result = mysqli_query($conn, $eventSql);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Eventify</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="page">
        <header class="top-bar">
            <h1 class="logo">Eventify</h1>
            <div class="top-bar-right">
                <span class="chip"><?php echo htmlspecialchars($userRole); ?></span>
                <span class="muted small">Hi, <?php echo htmlspecialchars($userName); ?></span>
                <a href="logout.php" class="btn ghost">Logout</a>
            </div>
        </header>

        <main class="dashboard">
            <section class="dashboard-summary">
                <?php if ($userRole === 'organizer'): ?>
                    <h2>Organizer dashboard</h2>
                    <p class="muted">See all events and manage them. (In this simple demo, delete is wired, "Create event" is just a placeholder.)</p>
                    <div class="summary-actions">
                        <a href="#" class="btn primary disabled">+ Create event (demo only)</a>
                    </div>
                <?php else: ?>
                    <h2>Student dashboard</h2>
                    <p class="muted">Browse upcoming events and book a spot.</p>
                <?php endif; ?>
            </section>

            <section class="card">
                <h3>Events</h3>
                <?php if (empty($events)): ?>
                    <p class="muted">No events yet.</p>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Slots</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['title']); ?></td>
                                <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                                <td><?php echo htmlspecialchars($event['location']); ?></td>
                                <td><?php echo htmlspecialchars($event['slots']); ?></td>
                                <td>
                                    <?php if ($userRole === 'student'): ?>
                                        <a href="book_event.php?id=<?php echo $event['id']; ?>" class="link">Book</a>
                                    <?php endif; ?>
                                    <?php if ($userRole === 'organizer'): ?>
                                        <a href="delete_event.php?id=<?php echo $event['id']; ?>" class="link danger">Delete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>

