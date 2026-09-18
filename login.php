<?php

session_start();

require_once "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {

        $message = "Please enter your username and password.";

    } else {

        $stmt = $conn->prepare(
            "SELECT id, username, password FROM users WHERE username = ?"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                // Store user information in the session
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];

                // Send user to dashboard
                header("Location: dashboard.php");
                exit;

            } else {
                $message = "Incorrect username or password.";
            }

        } else {
            $message = "Incorrect username or password.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AttachTrack - Login</title>

    <link rel="stylesheet" href="register.css">

</head>

<body>

<div class="register-container">

    <h1>AttachTrack</h1>

    <p class="subtitle">Welcome back</p>

    <?php if (!empty($message)): ?>

        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="form-group">

            <label for="username">Username</label>

            <input
                type="text"
                id="username"
                name="username"
                placeholder="Enter your username"
                required
            >

        </div>

        <div class="form-group">

            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >

        </div>

        <button type="submit" class="register-btn">
            Login
        </button>

    </form>

    <p class="login-link">
        Don't have an account?
        <a href="register.php">Create Account</a>
    </p>

</div>

</body>

</html>