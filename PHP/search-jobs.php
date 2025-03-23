<?php
require 'db_connect.php';

$keyword = isset($_GET['keyword']) ? '%' . strtolower($_GET['keyword']) . '%' : '%';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Jobs per page
$offset = ($page - 1) * $limit;

$stmt = $conn->prepare("
    SELECT id, title, company, location, job_description
    FROM jobs
    WHERE LOWER(title) LIKE ?
    ORDER BY posted_at DESC
    LIMIT ? OFFSET ?
");
$stmt->bind_param("sii", $keyword, $limit, $offset);
$stmt->execute();

$result = $stmt->get_result();
$jobs = [];

while ($row = $result->fetch_assoc()) {
    $jobs[] = $row;
}

// Get total number of jobs (for total pages)
$totalResult = $conn->prepare("SELECT COUNT(*) FROM jobs WHERE LOWER(title) LIKE ?");
$totalResult->bind_param("s", $keyword);
$totalResult->execute();
$totalResult->bind_result($totalJobs);
$totalResult->fetch();
$totalPages = ceil($totalJobs / $limit);

header('Content-Type: application/json');
echo json_encode([
    'jobs' => $jobs,
    'totalPages' => $totalPages,
    'currentPage' => $page
]);

$stmt->close();
$conn->close();
?>
