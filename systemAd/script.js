document.addEventListener("DOMContentLoaded", () => {
    const editModal = document.getElementById('editModal');
    const closeEditModal = document.getElementById('closeEditModal');
    const editButtons = document.querySelectorAll('.btn-edit');

    editButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const student = JSON.parse(event.target.dataset.student);

            document.getElementById('editId').value = student.student_id;
            document.getElementById('editFirstName').value = student.first_name;
            document.getElementById('editLastName').value = student.last_name;
            document.getElementById('editAge').value = student.age;
            document.getElementById('editCourse').value = student.course;
            document.getElementById('editProgram').value = student.program;

            editModal.style.display = 'block';
        });
    });

    closeEditModal.addEventListener('click', () => {
        editModal.style.display = 'none';
    });

    window.onclick = (event) => {
        if (event.target === editModal) {
            editModal.style.display = 'none';
        }
    };
});
