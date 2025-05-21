<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Q&A</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="container header-container">
            <a href="index.php" class="logo-link">
                <i class="fas fa-heartbeat logo-icon"></i>
                <span class="logo-text">Health Q&A</span>
            </a>
            
            <button class="mobile-menu-toggle" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>
            
            <nav class="main-nav">
                <ul class="nav-list">
                    <li class="nav-item"><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li class="nav-item"><a href="ask.php"><i class="fas fa-question-circle"></i> Ask</a></li>
                    <li class="nav-item"><a href="categories.php"><i class="fas fa-tags"></i> Categories</a></li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="dropdown-toggle">
                                <i class="fas fa-user-circle"></i> My Account
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                <li><a href="profile.php"><i class="fas fa-user-edit"></i> Profile</a></li>
                                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li class="nav-item highlight"><a href="register.php"><i class="fas fa-user-plus"></i> Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">