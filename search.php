<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

$search_term = isset($_GET['q']) ? trim($_GET['q']) : '';

if (!empty($search_term)) {
    $stmt = $pdo->prepare("SELECT * FROM questions 
                          WHERE title LIKE :term OR body LIKE :term 
                          ORDER BY created_at DESC");
    $stmt->execute(['term' => "%$search_term%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

include 'includes/header.php';
?>

<div class="container">
    <h2>Search Results for "<?php echo htmlspecialchars($search_term); ?>"</h2>
    
    <?php if (!empty($search_term) && !empty($results)): ?>
        <div class="search-results">
            <?php foreach ($results as $question): ?>
                <div class="question">
                    <h3><a href="question.php?id=<?php echo $question['id']; ?>">
                        <?php echo highlight_search_term(htmlspecialchars($question['title']), $search_term); ?>
                    </a></h3>
                    <p><?php echo highlight_search_term(truncateText(htmlspecialchars($question['body']), 200), $search_term); ?></p>
                    <div class="meta">
                        <span class="category"><?php echo htmlspecialchars($question['category']); ?></span>
                        <span class="date"><?php echo formatDate($question['created_at']); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (!empty($search_term)): ?>
        <p>No results found for your search.</p>
    <?php else: ?>
        <p>Please enter a search term.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>