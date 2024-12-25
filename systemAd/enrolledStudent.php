<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

require 'config.php';

$course_filter = isset($_GET['course']) ? $_GET['course'] : '';
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'new_to_old';

$query = "SELECT * FROM enrollments";
$query_params = [];

if ($course_filter) {
    $query .= " WHERE course = :course";
    $query_params['course'] = $course_filter;
}

$query .= " ORDER BY date_enrolled " . ($sort_order === 'new_to_old' ? "DESC" : "ASC");

$stmt = $pdo->prepare($query);
$stmt->execute($query_params);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

$courses_query = $pdo->query("SELECT DISTINCT course FROM enrollments");
$courses = $courses_query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrolled Students</title>
    <link rel="stylesheet" href="enrolled.css">
</head>

<body>
    <?php include('sideNav.php'); ?>

    <div class="main-content" style="margin-left: 360px; padding: 20px;">
        <h1>Enrolled Students</h1>

        <form method="GET" action="enrolledStudent.php" class="filter-form">
            <label for="course">Filter by Department: </label>
            <select name="course" id="course">
                <option value="">All</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?php echo htmlspecialchars($course['course']); ?>" <?php echo $course_filter == $course['course'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($course['course']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="sort">Sort by: </label>
            <select name="sort" id="sort">
                <option value="new_to_old" <?php echo $sort_order === 'new_to_old' ? 'selected' : ''; ?>>Newest First</option>
                <option value="old_to_new" <?php echo $sort_order === 'old_to_new' ? 'selected' : ''; ?>>Oldest First</option>
            </select>

            <button type="submit">Filter</button>
        </form>

        <h2>Enrolled Students</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Course</th>
                    <th>Program</th>
                    <th>Date Enrolled</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['age']); ?></td>
                        <td><?php echo htmlspecialchars($student['course']); ?></td>
                        <td><?php echo htmlspecialchars($student['program']); ?></td>
                        <td><?php echo date('M d, Y - g:iA', strtotime($student['date_enrolled'])); ?></td>
                        <td>
                            <div class="btns">
                                <button class="btn-edit" data-student='<?php echo json_encode($student); ?>'>Edit</button>
                                <a href="deleteStudent.php?id=<?php echo $student['student_id']; ?>" class="btn-delete">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div id="editModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span id="closeEditModal" class="close">&times;</span>
                <h2>Edit Student</h2>
                <form id="editStudentForm" method="POST" action="editStudent.php">
                    <input type="hidden" id="editId" name="student_id">
                    <label>First Name:</label>
                    <input type="text" id="editFirstName" name="first_name" required><br>
                    <label>Last Name:</label>
                    <input type="text" id="editLastName" name="last_name" required><br>
                    <label>Age:</label>
                    <input type="number" id="editAge" name="age" required><br>
                    <label>Course:</label>
                    <select id="editCourse" name="course" required>
                        <option value="CCS">CCS</option>
                        <option value="COE">COE</option>
                        <option value="CED">CED</option>
                        <option value="CAS">CAS</option>
                        <option value="COC">COC</option>
                        <option value="CBA">CBA</option>
                    </select><br>
                    <label>Program:</label>
                    <input type="text" id="editProgram" name="program" required><br>
                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </div>

    </div>
    <script src="script.js"></script>
</body>

</html>