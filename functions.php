<?php
function getRecentQuestions($pdo, $limit = 10)
{
    $stmt = $pdo->query("SELECT q.*, u.username 
                         FROM questions q 
                         JOIN users u ON q.user_id = u.id 
                         ORDER BY q.created_at DESC 
                         LIMIT $limit");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getQuestion($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT q.*, u.username 
                           FROM questions q 
                           JOIN users u ON q.user_id = u.id 
                           WHERE q.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAnswers($pdo, $question_id)
{
    $stmt = $pdo->prepare("SELECT a.*, u.username 
                           FROM answers a 
                           JOIN users u ON a.user_id = u.id 
                           WHERE a.question_id = ? 
                           ORDER BY a.is_creator_answer DESC, a.created_at ASC");
    $stmt->execute([$question_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function truncateText($text, $length)
{
    if (strlen($text) > $length) {
        return substr($text, 0, $length) . '...';
    }
    return $text;
}

function formatDate($date)
{
    return date('F j, Y', strtotime($date));
}

function highlight_search_term($text, $term)
{
    if (empty($term)) return $text;
    return preg_replace("/(" . preg_quote($term) . ")/i", "<span class=\"highlight\">$1</span>", $text);
}
