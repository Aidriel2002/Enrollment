<?php
require 'config.php';

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM enrollments WHERE student_id = ?");
    $stmt->execute([$student_id]);

    header("Location: enrolledStudent.php");
    exit;
}
