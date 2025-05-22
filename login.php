<?php
// MUST be at very top
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

$pageTitle = "Login - Health Q&A";
$error = '';

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = "Invalid form submission. Please try again.";
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $error = "Both email and password are required.";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    header("Location: index.php");
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

<div class="content-section auth-page">
    <div class="auth-container">
        <div class="auth-left">
            <div class="auth-header">
                <h1>Welcome Back</h1>
                <p class="subheading">Login to access your health questions and answers</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES); ?>">

                <div class="form-group floating">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo isset($email) ? htmlspecialchars($email, ENT_QUOTES) : ''; ?>"
                        required
                        aria-required="true"
                        placeholder=" "
                        autocomplete="email">
                    <label for="email">Email Address</label>
                    <i class="fas fa-envelope input-icon"></i>
                </div>

                <div class="form-group floating">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        aria-required="true"
                        placeholder=" "
                        autocomplete="current-password">
                    <label for="password">Password</label>
                    <i class="fas fa-lock input-icon"></i>
                    <button type="button" class="toggle-password" aria-label="Show password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember" id="remember">
                        <span class="checkmark"></span>
                        Remember me
                    </label>
                    <a href="forgot-password.php" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="cta-button login-button">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>

                <div class="auth-divider">
                    <span>or</span>
                </div>

                <button type="button" class="social-login google">
                    <i class="fab fa-google"></i> Continue with Google
                </button>

                <button type="button" class="social-login facebook">
                    <i class="fab fa-facebook-f"></i> Continue with Facebook
                </button>

                <div class="auth-footer">
                    Don't have an account? <a href="register.php" class="auth-link">Create one</a>
                </div>
            </form>
        </div>

        <div class="auth-right">
            <div class="auth-illustration">
                <img src="images/login-illustration.svg" alt="Health professionals discussing" aria-hidden="true">
                <div class="auth-quote">
                    <blockquote>
                        "Your health questions answered by verified professionals"
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password visibility toggle
document.querySelector('.toggle-password').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});
</script>

<?php include 'includes/footer.php'; ?>