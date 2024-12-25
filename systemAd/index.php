<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'config.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = MD5(:password)");
    $stmt->execute([
        'username' => $username,
        'password' => $password,
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="leftpage">
                <div class="left-content">
                    <img src="./images/spc-logo.png" alt="image">
                </div>
            </div>
            <div class="rightpage">
                <form action="" method="POST">
                    <h2>LOGIN</h2>
                    <?php if (isset($error)) { ?>
                        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
                    <?php } ?>
                    <input type="text" name="username" placeholder="Enter your email" required>
                    <input type="password" name="password" placeholder="Enter your password" required>
                    <button type="submit">Log In</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>