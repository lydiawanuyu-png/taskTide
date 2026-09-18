<?php

session_start();

header("Content-Type: application/json");

require_once "../config/database.php";

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode([
        "success" => false,
        "message" => "User not logged in"
    ]);
    exit;
}

$user_id = $_SESSION["user_id"];

/* =========================
   GET PROFILE
========================= */

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $sql = "SELECT id, user_id, name, organization, course, supervisor,
                   start_date, end_date, bio, created_at, updated_at
            FROM profiles
            WHERE user_id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode([
            "success" => false,
            "message" => "SQL prepare failed: " . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $profile = $result->fetch_assoc();

        echo json_encode([
            "success" => true,
            "data" => $profile
        ]);

    } else {

        echo json_encode([
            "success" => true,
            "data" => null
        ]);
    }

    $stmt->close();
    exit;
}


/* =========================
   POST PROFILE
========================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $input = json_decode(file_get_contents("php://input"), true);

    $name = $input["name"] ?? "";
    $organization = $input["organization"] ?? "";
    $course = $input["course"] ?? "";
    $supervisor = $input["supervisor"] ?? "";
    $start_date = $input["start_date"] ?? "";
    $end_date = $input["end_date"] ?? "";
    $bio = $input["bio"] ?? "";


    // Check if profile already exists
    $checkSql = "SELECT id FROM profiles WHERE user_id = ?";

    $checkStmt = $conn->prepare($checkSql);

    if (!$checkStmt) {
        echo json_encode([
            "success" => false,
            "message" => "SQL prepare failed: " . $conn->error
        ]);
        exit;
    }

    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();

    $checkResult = $checkStmt->get_result();

    $checkStmt->close();


    /* =========================
       UPDATE EXISTING PROFILE
    ========================= */

    if ($checkResult->num_rows > 0) {

        $sql = "UPDATE profiles
                SET name = ?,
                    organization = ?,
                    course = ?,
                    supervisor = ?,
                    start_date = NULLIF(?, ''),
                    end_date = NULLIF(?, ''),
                    bio = ?
                WHERE user_id = ?";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            echo json_encode([
                "success" => false,
                "message" => "SQL prepare failed: " . $conn->error
            ]);
            exit;
        }

        $stmt->bind_param(
            "sssssssi",
            $name,
            $organization,
            $course,
            $supervisor,
            $start_date,
            $end_date,
            $bio,
            $user_id
        );

        if ($stmt->execute()) {

            echo json_encode([
                "success" => true,
                "message" => "Profile updated successfully"
            ]);

        } else {

            echo json_encode([
                "success" => false,
                "message" => "Failed to update profile: " . $stmt->error
            ]);
        }

        $stmt->close();
        exit;
    }


    /* =========================
       CREATE NEW PROFILE
    ========================= */

    $sql = "INSERT INTO profiles
            (user_id, name, organization, course, supervisor,
             start_date, end_date, bio)
            VALUES (?, ?, ?, ?, ?, NULLIF(?, ''), NULLIF(?, ''), ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode([
            "success" => false,
            "message" => "SQL prepare failed: " . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param(
        "isssssss",
        $user_id,
        $name,
        $organization,
        $course,
        $supervisor,
        $start_date,
        $end_date,
        $bio
    );

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Profile created successfully"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to create profile: " . $stmt->error
        ]);
    }

    $stmt->close();
    exit;
}


/* =========================
   INVALID REQUEST
========================= */

echo json_encode([
    "success" => false,
    "message" => "Invalid request method"
]);

?>