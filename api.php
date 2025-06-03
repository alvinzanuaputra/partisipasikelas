<?php
// api.php - API Endpoints untuk Aplikasi Partisipasi Kelas
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once 'config.php';

// Get request method and action
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'get_classes':
            getClasses();
            break;
        case 'get_student_results':
            getStudentResults();
            break;
        case 'save_assessment':
            saveAssessment();
            break;
        case 'get_admin_stats':
            getAdminStats();
            break;
        case 'get_recent_assessments':
            getRecentAssessments();
            break;
        case 'validate_student':
            validateStudent();
            break;
        case 'validate_assessor':
            validateAssessor();
            break;
        default:
            http_response_code(400);
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}

// Get all classes
function getClasses() {
    $pdo = getConnection();
    
    $stmt = $pdo->query("SELECT class_code, class_name, instructor FROM classes ORDER BY class_code");
    $classes = $stmt->fetchAll();
    
    echo json_encode(['success' => true, 'data' => $classes]);
}

// Get student results
function getStudentResults() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        return;
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    $student_id = $input['student_id'] ?? '';
    $class_code = $input['class_code'] ?? '';
    
    if (empty($student_id) || empty($class_code)) {
        http_response_code(400);
        echo json_encode(['error' => 'Student ID and Class Code are required']);
        return;
    }
    
    $pdo = getConnection();
    
    // Check if student is enrolled in the class
    $enrollCheck = $pdo->prepare("
        SELECT s.name as student_name, c.class_name 
        FROM students s 
        JOIN enrollments e ON s.student_id = e.student_id 
        JOIN classes c ON e.class_code = c.class_code 
        WHERE s.student_id = ? AND c.class_code = ?
    ");
    $enrollCheck->execute([$student_id, $class_code]);
    $enrollment = $enrollCheck->fetch();
    
    if (!$enrollment) {
        echo json_encode(['success' => false, 'message' => 'Student is not enrolled in this class or data not found']);
        return;
    }
    
    // Get assessments
    $stmt = $pdo->prepare("
        SELECT p.*, a.name as assessor_name, a.role as assessor_role
        FROM participations p
        JOIN assessors a ON p.assessor_id = a.assessor_id
        WHERE p.student_id = ? AND p.class_code = ?
        ORDER BY p.assessment_date DESC
    ");
    $stmt->execute([$student_id, $class_code]);
    $assessments = $stmt->fetchAll();
    
    // Calculate averages
    $avg_participation = 0;
    $avg_speaking = 0;
    $avg_engagement = 0;
    
    if (!empty($assessments)) {
        $total_assessments = count($assessments);
        $sum_participation = array_sum(array_column($assessments, 'participation_score'));
        $sum_speaking = array_sum(array_column($assessments, 'speaking_quality'));
        $sum_engagement = array_sum(array_column($assessments, 'engagement_level'));
        
        $avg_participation = round($sum_participation / $total_assessments, 1);
        $avg_speaking = round($sum_speaking / $total_assessments, 1);
        $avg_engagement = round($sum_engagement / $total_assessments, 1);
    }
    
    echo json_encode([
        'success' => true,
        'data' => [
            'student_name' => $enrollment['student_name'],
            'class_name' => $enrollment['class_name'],
            'assessments' => $assessments,
            'averages' => [
                'participation' => $avg_participation,
                'speaking' => $avg_speaking,
                'engagement' => $avg_engagement
            ],
            'total_assessments' => count($assessments)
        ]
    ]);
}

// Save assessment
function saveAssessment() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        return;
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate required fields
    $required_fields = ['assessor_id', 'student_id', 'class_code', 'participation_score', 
                       'speaking_quality', 'engagement_level', 'assessment_date'];
    
    foreach ($required_fields as $field) {
        if (!isset($input[$field]) || $input[$field] === '') {
            http_response_code(400);
            echo json_encode(['error' => "Field '$field' is required"]);
            return;
        }
    }
    
    $pdo = getConnection();
    
    // Validate assessor exists
    $assessorCheck = $pdo->prepare("SELECT id FROM assessors WHERE assessor_id = ?");
    $assessorCheck->execute([$input['assessor_id']]);
    if (!$assessorCheck->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Invalid Assessor ID']);
        return;
    }
    
    // Validate student exists and is enrolled in class
    $studentCheck = $pdo->prepare("
        SELECT s.id 
        FROM students s 
        JOIN enrollments e ON s.student_id = e.student_id 
        WHERE s.student_id = ? AND e.class_code = ?
    ");
    $studentCheck->execute([$input['student_id'], $input['class_code']]);
    if (!$studentCheck->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Student is not enrolled in this class']);
        return;
    }
    
    // Insert assessment
    $stmt = $pdo->prepare("
        INSERT INTO participations 
        (student_id, class_code, assessor_id, participation_score, speaking_quality, 
         engagement_level, feedback, assessment_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    $result = $stmt->execute([
        $input['student_id'],
        $input['class_code'],
        $input['assessor_id'],
        $input['participation_score'],
        $input['speaking_quality'],
        $input['engagement_level'],
        $input['feedback'] ?? '',
        $input['assessment_date']
    ]);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Assessment saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save assessment']);
    }
}

// Get admin statistics
function getAdminStats() {
    $pdo = getConnection();
    
    // Get total students
    $totalStudents = $pdo->query("SELECT COUNT(*) as count FROM students")->fetch()['count'];
    
    // Get total classes
    $totalClasses = $pdo->query("SELECT COUNT(*) as count FROM classes")->fetch()['count'];
    
    // Get total assessments
    $totalAssessments = $pdo->query("SELECT COUNT(*) as count FROM participations")->fetch()['count'];
    
    // Get average participation score
    $avgParticipation = $pdo->query("SELECT AVG(participation_score) as avg FROM participations")->fetch()['avg'];
    $avgParticipation = $avgParticipation ? round($avgParticipation, 1) : 0;
    
    // Get assessments per month (last 12 months)
    $monthlyStats = $pdo->query("
        SELECT 
            DATE_FORMAT(assessment_date, '%Y-%m') as month,
            COUNT(*) as count
        FROM participations 
        WHERE assessment_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
        GROUP BY DATE_FORMAT(assessment_date, '%Y-%m')
        ORDER BY month DESC
    ")->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => [
            'total_students' => $totalStudents,
            'total_classes' => $totalClasses,
            'total_assessments' => $totalAssessments,
            'avg_participation' => $avgParticipation,
            'monthly_stats' => $monthlyStats
        ]
    ]);
}

// Get recent assessments
function getRecentAssessments() {
    $limit = $_GET['limit'] ?? 10;
    
    $pdo = getConnection();
    
    $stmt = $pdo->prepare("
        SELECT 
            p.*, 
            s.name as student_name,
            c.class_name,
            a.name as assessor_name
        FROM participations p
        JOIN students s ON p.student_id = s.student_id
        JOIN classes c ON p.class_code = c.class_code
        JOIN assessors a ON p.assessor_id = a.assessor_id
        ORDER BY p.created_at DESC
        LIMIT ?
    ");
    $stmt->execute([$limit]);
    $assessments = $stmt->fetchAll();
    
    echo json_encode(['success' => true, 'data' => $assessments]);
}

// Validate student
function validateStudent() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        return;
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    $student_id = $input['student_id'] ?? '';
    
    if (empty($student_id)) {
        http_response_code(400);
        echo json_encode(['error' => 'Student ID is required']);
        return;
    }
    
    $pdo = getConnection();
    
    $stmt = $pdo->prepare("SELECT student_id, name FROM students WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch();
    
    if ($student) {
        echo json_encode(['success' => true, 'data' => $student]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Student ID not found']);
    }
}

// Validate assessor
function validateAssessor() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        return;
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    $assessor_id = $input['assessor_id'] ?? '';
    
    if (empty($assessor_id)) {
        http_response_code(400);
        echo json_encode(['error' => 'Assessor ID is required']);
        return;
    }
    
    $pdo = getConnection();
    
    $stmt = $pdo->prepare("SELECT assessor_id, name, role FROM assessors WHERE assessor_id = ?");
    $stmt->execute([$assessor_id]);
    $assessor = $stmt->fetch();
    
    if ($assessor) {
        echo json_encode(['success' => true, 'data' => $assessor]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Assessor ID not found']);
    }
}
?>