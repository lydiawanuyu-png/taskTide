<?php

session_start();

header("Content-Type: application/json");

require_once "../config/database.php";


/*
|--------------------------------------------------------------------------
| CHECK LOGIN
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "You must be logged in."
    ]);

    exit;
}


$user_id = $_SESSION["user_id"];

$method = $_SERVER["REQUEST_METHOD"];


/*
|--------------------------------------------------------------------------
| GET PROJECTS
|--------------------------------------------------------------------------
*/

if ($method === "GET") {

    $sql = "SELECT
                id,
                user_id,
                name,
                description,
                technologies,
                status,
                github,
                contribution,
                created_at
            FROM projects
            WHERE user_id = ?
            ORDER BY id DESC";


    $stmt = $conn->prepare($sql);


    if (!$stmt) {

        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "SQL prepare failed.",
            "error" => $conn->error
        ]);

        exit;
    }


    $stmt->bind_param(
        "i",
        $user_id
    );


    if (!$stmt->execute()) {

        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "Failed to load projects.",
            "error" => $stmt->error
        ]);

        exit;
    }


    $result = $stmt->get_result();

    $projects = [];


    while ($row = $result->fetch_assoc()) {

        $projects[] = $row;

    }


    echo json_encode([
        "success" => true,
        "data" => $projects
    ]);


    $stmt->close();

    exit;
}


/*
|--------------------------------------------------------------------------
| POST - ADD PROJECT
|--------------------------------------------------------------------------
*/

if ($method === "POST") {


    $data = json_decode(
        file_get_contents("php://input"),
        true
    );


    if (!$data) {

        http_response_code(400);

        echo json_encode([
            "success" => false,
            "message" => "Invalid JSON data."
        ]);

        exit;
    }


    $name = trim(
        $data["name"] ?? ""
    );


    $description = trim(
        $data["description"] ?? ""
    );


    $technologies = trim(
        $data["technologies"] ?? ""
    );


    $status = trim(
        $data["status"] ?? ""
    );


    $github = trim(
        $data["github"] ?? ""
    );


    $contribution = trim(
        $data["contribution"] ?? ""
    );


    if (
        empty($name) ||
        empty($description)
    ) {

        http_response_code(400);

        echo json_encode([
            "success" => false,
            "message" =>
                "Project name and description are required."
        ]);

        exit;
    }


    $sql = "INSERT INTO projects
            (
                user_id,
                name,
                description,
                technologies,
                status,
                github,
                contribution
            )
            VALUES (?, ?, ?, ?, ?, ?, ?)";


    $stmt = $conn->prepare($sql);


    if (!$stmt) {

        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "SQL prepare failed.",
            "error" => $conn->error
        ]);

        exit;
    }


    $stmt->bind_param(
        "issssss",
        $user_id,
        $name,
        $description,
        $technologies,
        $status,
        $github,
        $contribution
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" =>
                "Project added successfully.",
            "id" => $stmt->insert_id
        ]);

    } else {

        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" =>
                "Failed to add project.",
            "error" => $stmt->error
        ]);

    }


    $stmt->close();

    exit;
}


/*
|--------------------------------------------------------------------------
| DELETE PROJECT
|--------------------------------------------------------------------------
*/

if ($method === "DELETE") {


    $data = json_decode(
        file_get_contents("php://input"),
        true
    );


    $id = intval(
        $data["id"] ?? 0
    );


    if ($id <= 0) {

        http_response_code(400);

        echo json_encode([
            "success" => false,
            "message" => "Invalid project ID."
        ]);

        exit;
    }


    $sql = "DELETE FROM projects
            WHERE id = ?
            AND user_id = ?";


    $stmt = $conn->prepare($sql);


    if (!$stmt) {

        http_response_code(500);

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
            "message" =>
                "Project deleted successfully."
        ]);

    } else {

        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" =>
                "Failed to delete project.",
            "error" => $stmt->error
        ]);

    }


    $stmt->close();

    exit;
}


/*
|--------------------------------------------------------------------------
| INVALID METHOD
|--------------------------------------------------------------------------
*/

http_response_code(405);

echo json_encode([
    "success" => false,
    "message" => "Unsupported request method."
]);

?>