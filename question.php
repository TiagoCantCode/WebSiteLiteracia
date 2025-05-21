<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$question_id = $_GET['id'];
$question = getQuestion($pdo, $question_id);
$answers = getAnswers($pdo, $question_id);

if (!$question) {
    header('Location: index.php');
    exit;
}
?>

<?php include 'includes/header.php'; ?>

<div class="question-detail">
    <h2><?php echo htmlspecialchars($question['title']); ?></h2>
    <div class="meta">
        <span class="category"><?php echo htmlspecialchars($question['category']); ?></span>
        <span class="date">Asked on <?php echo formatDate($question['created_at']); ?></span>
    </div>
    <p><?php echo nl2br(htmlspecialchars($question['body'])); ?></p>
</div>

<div class="answers">
    <h3>Answers</h3>
    
    <?php if (empty($answers)): ?>
        <p>No answers yet. Be the first to answer!</p>
    <?php else: ?>
        <?php foreach ($answers as $answer): ?>
            <div class="answer <?php echo $answer['is_creator_answer'] ? 'creator-answer' : ''; ?>">
                <p><?php echo nl2br(htmlspecialchars($answer['body'])); ?></p>
                <div class="meta">
                    <span class="date">Answered on <?php echo formatDate($answer['created_at']); ?></span>
                    <?php if ($answer['is_creator_answer']): ?>
                        <span class="badge">Verified Health Professional</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if (isset($_SESSION['user_id'])): ?>
    <div class="answer-form">
        <h3>Post Your Answer</h3>
        <form action="post_answer.php" method="post">
            <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
            <textarea name="body" required placeholder="Write your answer here..."></textarea>
            <?php if (isset($_SESSION['is_creator']) && $_SESSION['is_creator']): ?>
                <label>
                    <input type="checkbox" name="is_creator_answer"> Post as verified health professional
                </label>
            <?php endif; ?>
            <button type="submit">Submit Answer</button>
        </form>
    </div>
<?php else: ?>
    <p><a href="login.php">Login</a> to post an answer.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>