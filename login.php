<?php
// MUST be at very top
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

$pageTitle = "Login";
$error = '';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Invalid form submission. Please try again.";
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $error = "Both email and password are required.";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Invalid email or password.";
                }
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                $error = "We couldn't log you in. Please try again later.";
            }
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="content-section">
    <h2>Login to Your Account</h2>
    <p class="subheading">Access your health questions and answers</p>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" class="auth-form">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <div class="form-group">
            <label for="email">Email*</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                required
                aria-required="true"
                placeholder="your@email.com"
                autocomplete="email">
        </div>

        <div class="form-group">
            <label for="password">Password*</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                aria-required="true"
                placeholder="Your password"
                autocomplete="current-password">
        </div>

        <button type="submit" class="btn-primary">
            <i class="fas fa-sign-in-alt"></i> Login
        </button>

        <div class="auth-links">
            <a href="register.php">Don't have an account? Register</a>
            <a href="forgot-password.php">Forgot password?</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>