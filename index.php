<?php
// MUST be at very top - no whitespace before!
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

try {
    $questions = getRecentQuestions($pdo);
    $pageTitle = "Site Literacia para a Saúde";
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $questions = [];
    $error = "We're experiencing technical difficulties. Please try again later.";
}
?>

<?php include 'includes/header.php'; ?>

<div class="content-section">
    <h2>Recent Health Questions</h2>
    <p class="subheading">Trusted health information from verified professionals</p>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="search-container">
        <form action="search.php" method="get" class="search-form" role="search">
            <div class="search-box">
                <input
                    type="text"
                    name="q"
                    placeholder="Search health questions..."
                    aria-label="Search health questions"
                    required>
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </form>
    </div>

    <div class="questions-list">
        <?php if (empty($questions)): ?>
            <div class="no-results">
                <p>No questions found. Be the first to <a href="ask.php">ask a question</a>!</p>
            </div>
        <?php else: ?>
            <?php foreach ($questions as $question): ?>
                <article class="question-card">
                    <h3>
                        <a href="question.php?id=<?php echo $question['id']; ?>">
                            <?php echo htmlspecialchars($question['title']); ?>
                        </a>
                    </h3>
                    <p><?php echo truncateText(htmlspecialchars($question['body']), 200); ?></p>
                    <div class="meta-info">
                        <span class="category"><?php echo htmlspecialchars($question['category']); ?></span>
                        <span aria-hidden="true">·</span>
                        <span class="answers"><?php echo $question['answer_count'] ?? 0; ?> Answers</span>
                        <span aria-hidden="true">·</span>
                        <time datetime="<?php echo date('c', strtotime($question['created_at'])); ?>">
                            <?php echo formatDate($question['created_at']); ?>
                        </time>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>