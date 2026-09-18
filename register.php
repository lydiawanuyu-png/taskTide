<?php

require_once "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $message = "Please fill in all fields.";
    } else {

        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Username already exists.";
        } else {

            // Securely hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $conn->prepare(
                "INSERT INTO users (username, password) VALUES (?, ?)"
            );

            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                $message = "Registration successful!";
            } else {
                $message = "Registration failed.";
            }
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

    <title>AttachTrack - Register</title>

    <link rel="stylesheet" href="register.css">
</head>

<body>

<div class="register-container">

    <h1>AttachTrack</h1>

    <p class="subtitle">Create your account</p>

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
                placeholder="Create a password"
                required
            >
        </div>

        <button type="submit" class="register-btn">
            Create Account
        </button>

    </form>

    <p class="login-link">
        Already have an account?
        <a href="login.php">Login</a>
    </p>

</div>

</body>
</html>
