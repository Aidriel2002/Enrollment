<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $course = $_POST['course'];
    $program = $_POST['program'];

    $stmt = $pdo->prepare("UPDATE enrollments SET first_name = ?, last_name = ?, age = ?, course = ?, program = ? WHERE student_id = ?");
    $stmt->execute([$first_name, $last_name, $age, $course, $program, $student_id]);

    header("Location: enrolledStudent.php");
    exit;
}
