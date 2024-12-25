<div class="side-nav">
    <div class="content">
        <h3>Enrollment System</h3>
        <ul>
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="enrolledStudent.php">Enrolled Students</a></li>
        </ul>
    </div>
    <a class="logout" href="#" id="logoutButton">Logout</a>
</div>

<div id="logoutModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span id="closeLogoutModal" class="close">&times;</span>
        <h2>Confirm Logout</h2>
        <p>Are you sure you want to log out?</p>
        <div class="modal-buttons">
            <button id="confirmLogout" class="confirm-button">Logout</button>
            <button id="cancelLogout" class="cancel-button">Cancel</button>
        </div>
    </div>
</div>


<style>
    .side-nav {
        width: 350px;
        height: 100vh;
        background-color: #2c3e50;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        padding: 20px;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .side-nav h3 {
        text-align: center;
        margin-bottom: 50px;
        color: #fff;
        font-size: 24px;
    }

    .side-nav ul {
        list-style-type: none;
        padding: 0;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .side-nav ul li {
        padding: 15px;
        text-align: center;
    }

    .side-nav ul li a {
        color: white;
        text-decoration: none;
        display: block;
        font-size: 18px;
        transition: background-color 0.3s ease;
    }

    .side-nav ul li a:hover {
        background-color: #2d3844;
    }

    .content a {
        display: block;
        text-align: center;
        padding: 15px;
        color: white;
        text-decoration: none;
        background-color: #3b5167;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .logout {
        display: block;
        text-align: center;
        padding: 15px;
        color: white;
        text-decoration: none;
        background-color: #e74c3c;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .logout:hover {
        background-color: #c0392b;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        width: 30%;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .modal-content h2 {
        color: #2c3e50;
        font-size: 28px;
        margin-bottom: 20px;
    }

    .modal-content p {
        color: #333;
        font-size: 20px;
        margin-bottom: 30px;
    }

    .modal-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 24px;
        cursor: pointer;
    }

    .close:hover {
        color: #333;
    }

    #confirmLogout {
        background-color: #e74c3c;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #confirmLogout:hover {
        background-color: #c0392b;
    }

    .cancel-button {
        background-color: #2c3e50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .cancel-button:hover {
        background-color: #3b5167;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const logoutButton = document.getElementById("logoutButton");
        const logoutModal = document.getElementById("logoutModal");
        const closeLogoutModal = document.getElementById("closeLogoutModal");
        const confirmLogout = document.getElementById("confirmLogout");
        const cancelLogout = document.getElementById("cancelLogout");

        logoutButton.addEventListener("click", (e) => {
            e.preventDefault();
            logoutModal.style.display = "block";
        });

        closeLogoutModal.addEventListener("click", () => {
            logoutModal.style.display = "none";
        });

        cancelLogout.addEventListener("click", () => {
            logoutModal.style.display = "none";
        });


        confirmLogout.addEventListener("click", () => {
            window.location.href = "logout.php";
        });


        window.addEventListener("click", (event) => {
            if (event.target === logoutModal) {
                logoutModal.style.display = "none";
            }
        });
    });
</script>