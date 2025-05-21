<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $body = trim($_POST['body']);
    $category = trim($_POST['category']);
    $user_id = $_SESSION['user_id'];
    
    if (!empty($title) && !empty($body)) {
        $stmt = $pdo->prepare("INSERT INTO questions (user_id, title, body, category) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $body, $category]);
        header('Location: index.php');
        exit;
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2>Ask a Health Question</h2>

<form action="ask.php" method="post">
    <label for="title">Question Title*</label>
    <input type="text" id="title" name="title" required>
    
    <label for="category">Category</label>
    <select id="category" name="category">
        <option value="General">General Health</option>
        <option value="Nutrition">Nutrition</option>
        <option value="Fitness">Fitness</option>
        <option value="Mental">Mental Health</option>
        <option value="Chronic">Chronic Conditions</option>
    </select>
    
    <label for="body">Question Details*</label>
    <textarea id="body" name="body" required></textarea>
    
    <button type="submit">Submit Question</button>
</form>

<?php include 'includes/footer.php'; ?>