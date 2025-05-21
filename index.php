<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

$questions = getRecentQuestions($pdo);
?>

<?php include 'includes/header.php'; ?>

<div class="content-section">
    <h2>Recent Health Questions</h2>
    <p class="subheading">Trusted health information from verified professionals</p>

    <div class="search-container">
        <form action="search.php" method="get" class="search-form">
            <div class="search-box">
                <input type="text" name="q" placeholder="Search health questions..." aria-label="Search health questions">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </form>
    </div>

    <div class="questions-list">
        <?php foreach ($questions as $question): ?>
            <div class="question-card">
                <h3><a href="question.php?id=<?php echo $question['id']; ?>"><?php echo htmlspecialchars($question['title']); ?></a></h3>
                <p><?php echo truncateText(htmlspecialchars($question['body']), 200); ?></p>
                <div class="meta-info">
                    <span class="category"><?php echo htmlspecialchars($question['category']); ?></span>
                    <span>·</span>
                    <span class="answers"><?php echo $question['answer_count'] ?? 0; ?> Answers</span>
                    <span>·</span>
                    <span class="date"><?php echo formatDate($question['created_at']); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>