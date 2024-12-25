<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
require 'config.php';
function getCoursesCount($pdo)
{
    $courses_query = $pdo->query("SELECT course, COUNT(*) AS count FROM enrollments GROUP BY course");
    return $courses_query->fetchAll(PDO::FETCH_ASSOC);
}
$courses_count = getCoursesCount($pdo);

$courses = [
    'CCS' => ['name' => 'COLLEGE OF COMPUTER STUDIES', 'image' => 'images/ccs.png'],
    'COE' => ['name' => 'COLLEGE OF ENGINEERING', 'image' => 'images/coe.jpg'],
    'CED' => ['name' => 'COLLEGE OF EDUCATION', 'image' => 'images/ced.png'],
    'CAS' => ['name' => 'COLLEGE OF ARTS AND SCIENCES', 'image' => 'images/cas.png'],
    'COC' => ['name' => 'COLLEGE OF CRIMINOLOGY', 'image' => 'images/coc.png'],
    'CBA' => ['name' => 'COLLEGE OF BUSINESS ADMINISTRATION', 'image' => 'images/cba.png']
];

if (isset($_GET['action']) && $_GET['action'] === 'getCourseData') {
    header('Content-Type: application/json');
    echo json_encode(getCoursesCount($pdo));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">

</head>

<body>
    <?php include('sideNav.php'); ?>

    <div class="main-content" style="margin-left: 360px; padding: 20px;">
        <div class="home-dashboard">
            <div class="top">
                <h2>Dashboard</h2>
                <button class="btn-add-student" onclick="openModal()">Add New Student</button>
            </div>


            <h3>Enrolled Students by Course</h3>

            <div id="courseContainer" class="course-container">
                <?php foreach ($courses as $abbreviation => $course_info): ?>
                    <?php
                    $count = 0;
                    foreach ($courses_count as $course_data) {
                        if ($course_data['course'] === $abbreviation) {
                            $count = $course_data['count'];
                            break;
                        }
                    }
                    ?>
                    <div class="course-box" data-course="<?php echo $abbreviation; ?>">
                        <img src="<?php echo htmlspecialchars($course_info['image']); ?>" alt="<?php echo htmlspecialchars($course_info['name']); ?>">
                        <h4><?php echo htmlspecialchars($course_info['name']); ?></h4>
                        <p class="student-count"><?php echo $count; ?> Students Enrolled</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add New Student</h2>
            <form id="addStudentForm">
                <input type="text" name="student_id" placeholder="Student ID" required><br><br>
                <input type="text" name="first_name" placeholder="First Name" required><br><br>
                <input type="text" name="last_name" placeholder="Last Name" required><br><br>
                <input type="number" name="age" placeholder="Age" required><br><br>
                <select name="course" required>
                    <option value="" disabled selected>Select Department</option>
                    <?php foreach ($courses as $abbreviation => $course_info): ?>
                        <option value="<?php echo $abbreviation; ?>"><?php echo htmlspecialchars($course_info['name']); ?></option>
                    <?php endforeach; ?>
                </select><br><br>
                <input type="text" name="program" placeholder="Program" required><br><br>
                <button type="submit">Enroll Student</button>
            </form>
            <div id="successMessage" style="display: none;">Student enrolled successfully!</div>
            <div id="errorMessage" style="display: none;">Failed to enroll student. Please try again.</div>
        </div>
    </div>

    <script>
        const modal = document.getElementById("addStudentModal");

        function openModal() {
            modal.style.display = "block";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target === modal) {
                closeModal();
            }
        };

        document.getElementById("addStudentForm").addEventListener("submit", async function(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            try {
                const response = await fetch("addStudent.php", {
                    method: "POST",
                    body: formData,
                });

                if (response.ok) {
                    document.getElementById("successMessage").style.display = "block";
                    document.getElementById("errorMessage").style.display = "none";
                    updateCourseData();
                    setTimeout(() => {
                        document.getElementById("successMessage").style.display = "none";
                        form.reset();
                        closeModal();
                    }, 3000);
                } else {
                    throw new Error("Failed to enroll student.");
                }
            } catch (error) {
                document.getElementById("errorMessage").style.display = "block";
                document.getElementById("successMessage").style.display = "none";
            }
        });

        async function updateCourseData() {
            try {
                const response = await fetch("?action=getCourseData");
                if (response.ok) {
                    const data = await response.json();
                    const courseContainer = document.getElementById("courseContainer");
                    const courseBoxes = courseContainer.getElementsByClassName("course-box");

                    for (let box of courseBoxes) {
                        const course = box.getAttribute("data-course");
                        const studentCount = data.find(item => item.course === course)?.count || 0;
                        box.querySelector(".student-count").textContent = `${studentCount} Students Enrolled`;
                    }
                }
            } catch (error) {
                console.error("Error updating course data:", error);
            }
        }
    </script>
</body>

</html>