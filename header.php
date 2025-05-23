<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Health Q&A - Get answers to your health questions from verified professionals">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Health Q&A'; ?></title>
    <link rel="preload" href="css/style.css" as="style">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon.png">
</head>

<body>
    <header>
        <div class="container header-container">
            <a href="index.php" class="logo-link" aria-label="Home">
                <i class="fas fa-heartbeat logo-icon"></i>
                <span class="logo-text">Health Q&A</span>
            </a>

            <nav class="main-nav" aria-label="Main navigation">
                <ul class="nav-list">
                    <li class="nav-item"><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li class="nav-item"><a href="ask.php"><i class="fas fa-question-circle"></i> Ask</a></li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                        <li class="nav-item"><a href="profile.php"><i class="fas fa-user-edit"></i> Profile</a></li>
                        <li class="nav-item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a href="signin.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li class="nav-item highlight"><a href="signup.php"><i class="fas fa-user-plus"></i> Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">

    