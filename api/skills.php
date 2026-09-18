<?php

session_start();

require_once "../config/database.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {

    echo json_encode([
        "success" => false,
        "message" => "You must be logged in."
    ]);

    exit;
}

$user_id = $_SESSION["user_id"];

$method = $_SERVER["REQUEST_METHOD"];


/* =========================
   GET SKILLS
========================= */

if ($method === "GET") {

    $stmt = $conn->prepare(
        "SELECT
            id,
            name,
            category,
            level,
            progress,
            created_at
         FROM skills
         WHERE user_id = ?
         ORDER BY id DESC"
    );

    if (!$stmt) {

        echo json_encode([
            "success" => false,
            "message" => "SQL prepare failed.",
            "error" => $conn->error
        ]);

        exit;
    }

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    $result = $stmt->get_result();

    $skills = [];

    while ($row = $result->fetch_assoc()) {

        $skills[] = [
            "id" => $row["id"],
            "name" => $row["name"],
            "category" => $row["category"],
            "level" => $row["level"],
            "progress" => $row["progress"],
            "created_at" => $row["created_at"]
        ];

    }

    echo json_encode($skills);

    exit;
}


/* =========================
   ADD SKILL
========================= */

if ($method === "POST") {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    $name = trim($data["name"] ?? "");

    $category = trim(
        $data["category"] ?? ""
    );

    $level = trim(
        $data["level"] ?? ""
    );


    if (empty($name)) {

        echo json_encode([
            "success" => false,
            "message" => "Please enter a skill name."
        ]);

        exit;
    }


    /* Calculate progress from level */

    if ($level === "Beginner") {
        $progress = 25;
    } elseif ($level === "Learning") {
        $progress = 50;
    } elseif ($level === "Intermediate") {
        $progress = 75;
    } elseif ($level === "Confident") {
        $progress = 100;
    } else {
        $progress = 0;
    }


    $stmt = $conn->prepare(
        "INSERT INTO skills
        (
            user_id,
            name,
            category,
            level,
            progress
        )
        VALUES (?, ?, ?, ?, ?)"
    );


    if (!$stmt) {

        echo json_encode([
            "success" => false,
            "message" => "SQL prepare failed.",
            "error" => $conn->error
        ]);

        exit;
    }


    $stmt->bind_param(
        "isssi",
        $user_id,
        $name,
        $category,
        $level,
        $progress
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Skill added successfully.",
            "id" => $stmt->insert_id
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to add skill.",
            "error" => $stmt->error
        ]);

    }

    exit;
}


/* =========================
   UPDATE SKILL LEVEL
========================= */

if ($method === "PUT") {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    $id = intval(
        $data["id"] ?? 0
    );

    $level = trim(
        $data["level"] ?? ""
    );


    if ($id <= 0 || empty($level)) {

        echo json_encode([
            "success" => false,
            "message" => "Invalid skill information."
        ]);

        exit;
    }


    /* Calculate new progress */

    if ($level === "Beginner") {
        $progress = 25;
    } elseif ($level === "Learning") {
        $progress = 50;
    } elseif ($level === "Intermediate") {
        $progress = 75;
    } elseif ($level === "Confident") {
        $progress = 100;
    } else {
        $progress = 0;
    }


    $stmt = $conn->prepare(
        "UPDATE skills
         SET level = ?, progress = ?
         WHERE id = ?
         AND user_id = ?"
    );


    if (!$stmt) {

        echo json_encode([
            "success" => false,
            "message" => "SQL prepare failed.",
            "error" => $conn->error
        ]);

        exit;
    }


    $stmt->bind_param(
        "siii",
        $level,
        $progress,
        $id,
        $user_id
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Skill level updated successfully."
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to update skill.",
            "error" => $stmt->error
        ]);

    }

    exit;
}


/* =========================
   DELETE SKILL
========================= */

if ($method === "DELETE") {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    $id = intval(
        $data["id"] ?? 0
    );


    if ($id <= 0) {

        echo json_encode([
            "success" => false,
            "message" => "Invalid skill ID."
        ]);

        exit;
    }


    $stmt = $conn->prepare(
        "DELETE FROM skills
         WHERE id = ?
         AND user_id = ?"
    );


    if (!$stmt) {

        echo json_encode([
            "success" => false,
            "message" => "SQL prepare failed.",
            "error" => $conn->error
        ]);

        exit;
    }


    $stmt->bind_param(
        "ii",
        $id,
        $user_id
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Skill deleted successfully."
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to delete skill.",
            "error" => $stmt->error
        ]);

    }

    exit;
}


/* =========================
   UNSUPPORTED METHOD
========================= */

echo json_encode([
    "success" => false,
    "message" => "Unsupported request method."
]);

?>