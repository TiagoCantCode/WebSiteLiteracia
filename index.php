<?php
// Strict types and error reporting
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Session security
session_start();
session_regenerate_id(true);

// Secure includes
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

// Initialize variables
$questions = [];
$error = '';
$pageTitle = "Site Literacia para a Saúde";

try {
    // Validate PDO connection
    if (!($pdo instanceof PDO)) {
        throw new RuntimeException('Database connection failed');
    }
    
    $questions = getRecentQuestions($pdo);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $error = "We're experiencing technical difficulties. Please try again later.";
} catch (Throwable $e) {
    error_log("System error: " . $e->getMessage());
    $error = "An unexpected error occurred.";
}
?>

<?php include 'includes/header.php'; ?>

<div class="content-section">
    <main>
        <h1>Recent Health Questions</h1>
        <p class="subheading">Trusted health information from verified professionals</p>

        <?php if ($error): ?>
            <div class="alert alert-error" role="alert">
                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <section aria-label="Search questions">
            <div class="search-container">
                <form action="search.php" method="get" class="search-form" role="search">
                    <div class="search-box">
                        <input
                            type="search"  
                            name="q"
                            placeholder="Search health questions..."
                            aria-label="Search health questions"
                            required
                            minlength="3"
                            maxlength="100">
                        <button type="submit" class="search-button">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <section aria-label="Questions list">
            <div class="questions-list">
                <?php if (empty($questions)): ?>
                    <div class="empty-state" aria-live="polite">
                        <p>No questions found yet.</p>
                        <a href="ask.php" class="cta-button">Ask the First Question</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($questions as $question): ?>
                        <article class="question-card" id="question-<?php echo (int)$question['id']; ?>">
                            <h2>  <!-- Changed from h3 to h2 for better hierarchy -->
                                <a href="question.php?id=<?php echo (int)$question['id']; ?>">
                                    <?php echo htmlspecialchars($question['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h2>
                            <p><?php echo truncateText(htmlspecialchars($question['body'] ?? '', ENT_QUOTES, 'UTF-8'), 200); ?></p>
                            <div class="meta-info">
                                <?php if (!empty($question['category'])): ?>
                                    <span class="category"><?php echo htmlspecialchars($question['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <span aria-hidden="true">·</span>
                                <?php endif; ?>
                                <span class="answers">
                                    <?php echo (int)($question['answer_count'] ?? 0); ?> Answers
                                </span>
                                <span aria-hidden="true">·</span>
                                <time datetime="<?php echo htmlspecialchars(date('c', strtotime($question['created_at'] ?? 'now')), ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo formatDate($question['created_at'] ?? ''); ?>
                                </time>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>
</div>

<?php include 'includes/footer.php'; ?>