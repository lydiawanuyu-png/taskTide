<?php

session_start();

header("Content-Type: application/json");

// Make sure user is logged in
if (!isset($_SESSION["user_id"])) {

    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "You must be logged in."
    ]);

    exit;
}

$user_id = $_SESSION["user_id"];

// Database connection
require_once "../config/database.php";


// Get request method
$method = $_SERVER["REQUEST_METHOD"];


/*
|--------------------------------------------------------------------------
| GET - GET USER ACHIEVEMENTS
|--------------------------------------------------------------------------
*/

if ($method === "GET") {

    $sql = "SELECT 
                id,
                user_id,
                title,
                category,
                level,
                achievement_date,
                created_at
            FROM achievements
            WHERE user_id = ?
            ORDER BY achievement_date DESC, id DESC";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    $result = $stmt->get_result();

    $achievements = [];

    while ($row = $result->fetch_assoc()) {

        $achievements[] = $row;

    }

    echo json_encode([
        "success" => true,
        "data" => $achievements
    ]);

    $stmt->close();

    exit;
}


/*
|--------------------------------------------------------------------------
| POST - ADD ACHIEVEMENT
|--------------------------------------------------------------------------
*/

if ($method === "POST") {

    // Get JSON sent by JavaScript
    $data = json_decode(
        file_get_contents("php://input"),
        true
    );


    // Check required fields
    if (
        empty($data["title"]) ||
        empty($data["category"]) ||
        empty($data["level"]) ||
        empty($data["achievement_date"])
    ) {

        http_response_code(400);

        echo json_encode([
            "success" => false,
            "message" => "Please fill in all required fields."
        ]);

        exit;
    }


    $title = trim($data["title"]);
    $category = trim($data["category"]);
    $level = trim($data["level"]);
    $achievement_date = trim($data["achievement_date"]);


    $sql = "INSERT INTO achievements
            (
                user_id,
                title,
                category,
                level,
                achievement_date
            )
            VALUES (?, ?, ?, ?, ?)";


    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "issss",
        $user_id,
        $title,
        $category,
        $level,
        $achievement_date
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Achievement added successfully.",
            "id" => $stmt->insert_id
        ]);

    } else {

        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "Failed to add achievement."
        ]);

    }


    $stmt->close();

    exit;
}


/*
|--------------------------------------------------------------------------
| DELETE - DELETE ACHIEVEMENT
|--------------------------------------------------------------------------
*/

if ($method === "DELETE") {

    // Get ID from URL
    if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {

        http_response_code(400);

        echo json_encode([
            "success" => false,
            "message" => "Achievement ID is required."
        ]);

        exit;
    }


    $achievement_id = intval($_GET["id"]);


    /*
    IMPORTANT:
    We check BOTH id and user_id.

    This prevents User A from deleting
    User B's achievement.
    */

    $sql = "DELETE FROM achievements
            WHERE id = ?
            AND user_id = ?";


    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ii",
        $achievement_id,
        $user_id
    );


    if ($stmt->execute()) {

        if ($stmt->affected_rows > 0) {

            echo json_encode([
                "success" => true,
                "message" => "Achievement deleted successfully."
            ]);

        } else {

            http_response_code(404);

            echo json_encode([
                "success" => false,
                "message" => "Achievement not found."
            ]);

        }

    } else {

        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "Failed to delete achievement."
        ]);

    }


    $stmt->close();

    exit;
}


/*
|--------------------------------------------------------------------------
| INVALID REQUEST METHOD
|--------------------------------------------------------------------------
*/

http_response_code(405);

echo json_encode([
    "success" => false,
    "message" => "Method not allowed."
]);

?>
