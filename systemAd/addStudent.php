<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

require 'config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $program = trim($_POST['program'] ?? '');

    if (empty($student_id) || empty($first_name) || empty($last_name) || empty($age) || empty($course) || empty($program)) {
        $message = "All fields are required.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM enrollments WHERE student_id = :student_id");
            $stmt->execute(['student_id' => $student_id]);

            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                $message = "Student ID is already in use.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO enrollments (student_id, first_name, last_name, age, course, program) VALUES (:student_id, :first_name, :last_name, :age, :course, :program)");
                $stmt->execute([
                    'student_id' => $student_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'age' => $age,
                    'course' => $course,
                    'program' => $program,
                ]);
                $message = "Enrollment added successfully!";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll Student</title>
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <?php include('sideNav.php'); ?>

    <div class="main-content" style="margin-left: 260px; padding: 20px;">
        <h1>Enroll New Student</h1>

        <?php if (!empty($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="POST" action="addStudent.php">
            <input type="text" name="student_id" placeholder="Student ID" required><br><br>
            <input type="text" name="first_name" placeholder="First Name" required><br><br>
            <input type="text" name="last_name" placeholder="Last Name" required><br><br>
            <input type="number" name="age" placeholder="Age" required><br><br>
            <select name="course" required>
                <option value="" disabled selected>Select Course</option>
                <option value="CCS">CCS</option>
                <option value="COE">COE</option>
                <option value="CED">CED</option>
                <option value="CAS">CAS</option>
                <option value="COC">COC</option>
                <option value="CBA">CBA</option>
            </select><br><br>
            <input type="text" name="program" placeholder="Program" required><br><br>
            <button type="submit">Enroll Student</button>
        </form>
    </div>
</body>

</html>