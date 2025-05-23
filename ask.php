<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

$pageTitle = "Ask a Health Question";
$error = '';
$success = '';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Invalid CSRF token. Please try again.";
    } else {
        $title = trim($_POST['title'] ?? '');
        $body = trim($_POST['body'] ?? '');
        $category = trim($_POST['category'] ?? '');

        if (empty($title) || empty($body) || empty($category)) {
            $error = "All fields are required.";
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO questions (user_id, title, body, category) VALUES (?, ?, ?, ?)");
                $stmt->execute([$_SESSION['user_id'], $title, $body, $category]);
                $success = "Your question has been submitted successfully!";
                // Clear form fields
                $title = $body = $category = '';
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                $error = "We couldn't submit your question. Please try again later.";
            }
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="content-section">
    <h2>Ask a Health Question</h2>
    <p class="subheading">Get answers from verified professionals</p>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST" class="question-form">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
        <div class="form-group">
            <label for="title">Question Title*</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                value="<?php echo isset($title) ? htmlspecialchars($title) : ''; ?>" 
                required
                aria-required="true"
                placeholder="What's your health question?"
            >
        </div>
        
        <div class="form-group">
            <label for="category">Category*</label>
            <select id="category" name="category" required aria-required="true">
                <option value="">Select a category</option>
                <option value="General Health" <?php echo (isset($category) && $category === 'General Health') ? 'selected' : ''; ?>>General Health</option>
                <option value="Nutrition" <?php echo (isset($category) && $category === 'Nutrition') ? 'selected' : ''; ?>>Nutrition</option>
                <option value="Mental Health" <?php echo (isset($category) && $category === 'Mental Health') ? 'selected' : ''; ?>>Mental Health</option>
                <option value="Medications" <?php echo (isset($category) && $category === 'Medications') ? 'selected' : ''; ?>>Medications</option>
                <option value="Other" <?php echo (isset($category) && $category === 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="body">Details*</label>
            <textarea 
                id="body" 
                name="body" 
                required
                aria-required="true"
                placeholder="Provide more details about your question..."
                rows="6"
            ><?php echo isset($body) ? htmlspecialchars($body) : ''; ?></textarea>
        </div>
        
        <button type="submit" class="btn-primary">
            <i class="fas fa-paper-plane"></i> Submit Question
        </button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>