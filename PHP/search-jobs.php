<?php
require 'db_connect.php';

// Enable full error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$keyword = $_GET['keyword'] ?? '';
$page = (int) ($_GET['page'] ?? 1);
$location = $_GET['location'] ?? '';
$industry = $_GET['industry'] ?? '';
$sort = $_GET['sort'] ?? 'date';

$limit = 10;
$offset = ($page - 1) * $limit;

// Begin building the query safely
$sql = "SELECT * FROM jobs WHERE 1=1";
$params = [];
$types = "";

// Only add WHERE clauses if filters exist
if (!empty($keyword)) {
    $sql .= " AND title LIKE ?";
    $params[] = "%$keyword%";
    $types .= "s";
}

if (!empty($location)) {
    $sql .= " AND location = ?";
    $params[] = $location;
    $types .= "s";
}

if (!empty($industry)) {
    $sql .= " AND industry = ?";
    $params[] = $industry;
    $types .= "s";
}

// Sorting
$sql .= ($sort === 'title') ? " ORDER BY title ASC" : " ORDER BY posted_at DESC";

// Pagination
$sql .= " LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= "ii";

// Prepare the statement
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(["error" => "Prepare failed: " . $conn->error, "sql" => $sql]));
}
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$jobs = [];
while ($row = $result->fetch_assoc()) {
    $jobs[] = $row;
}

// Total count query for pagination
$countSql = "SELECT COUNT(*) as count FROM jobs WHERE 1=1";
$countParams = [];
$countTypes = "";

if (!empty($keyword)) {
    $countSql .= " AND title LIKE ?";
    $countParams[] = "%$keyword%";
    $countTypes .= "s";
}

if (!empty($location)) {
    $countSql .= " AND location = ?";
    $countParams[] = $location;
    $countTypes .= "s";
}

if (!empty($industry)) {
    $countSql .= " AND industry = ?";
    $countParams[] = $industry;
    $countTypes .= "s";
}

$countStmt = $conn->prepare($countSql);
if (!$countStmt) {
    die(json_encode(["error" => "Count prepare failed: " . $conn->error, "sql" => $countSql]));
}
if (!empty($countParams)) {
    $countStmt->bind_param($countTypes, ...$countParams);
}
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalCount = $countResult->fetch_assoc()['count'];
$totalPages = ceil($totalCount / $limit);

header('Content-Type: application/json');
echo json_encode([
    'jobs' => $jobs,
    'totalCount' => $totalCount,
    'totalPages' => $totalPages,
    'currentPage' => $page
]);
?>
