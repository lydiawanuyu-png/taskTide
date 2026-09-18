<?php

session_start();

require_once "../config/database.php";

header("Content-Type: application/json");

/*
|--------------------------------------------------------------------------
| Check if user is logged in
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    echo json_encode([
        "success" => false,
        "message" => "User not logged in."
    ]);

    exit;
}

$user_id = $_SESSION["user_id"];

$method = $_SERVER["REQUEST_METHOD"];


/*
|--------------------------------------------------------------------------
| GET - Get only this user's tasks
|--------------------------------------------------------------------------
*/

if ($method === "GET") {

    $stmt = $conn->prepare(
        "SELECT * FROM tasks
         WHERE user_id = ?
         ORDER BY task_date ASC, id DESC"
    );

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    $result = $stmt->get_result();

    $tasks = [];

    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    echo json_encode($tasks);

    exit;
}


/*
|--------------------------------------------------------------------------
| POST - Add a new task
|--------------------------------------------------------------------------
*/

if ($method === "POST") {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    $title = $data["title"] ?? "";
    $task_date = $data["task_date"] ?? "";

    if (empty($title) || empty($task_date)) {

        echo json_encode([
            "success" => false,
            "message" => "Task title and date are required."
        ]);

        exit;
    }


    $stmt = $conn->prepare(
        "INSERT INTO tasks (user_id, title, task_date)
         VALUES (?, ?, ?)"
    );

    $stmt->bind_param(
        "iss",
        $user_id,
        $title,
        $task_date
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Task added successfully.",
            "id" => $stmt->insert_id
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to add task."
        ]);
    }

    exit;
}


/*
|--------------------------------------------------------------------------
| PUT - Complete / uncomplete only this user's task
|--------------------------------------------------------------------------
*/

if ($method === "PUT") {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    $id = $data["id"] ?? 0;
    $completed = $data["completed"] ?? false;


    $stmt = $conn->prepare(
        "UPDATE tasks
         SET completed = ?
         WHERE id = ?
         AND user_id = ?"
    );

    $stmt->bind_param(
        "iii",
        $completed,
        $id,
        $user_id
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Task updated successfully."
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to update task."
        ]);
    }

    exit;
}


/*
|--------------------------------------------------------------------------
| DELETE - Delete only this user's task
|--------------------------------------------------------------------------
*/

if ($method === "DELETE") {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    $id = $data["id"] ?? 0;


    $stmt = $conn->prepare(
        "DELETE FROM tasks
         WHERE id = ?
         AND user_id = ?"
    );

    $stmt->bind_param(
        "ii",
        $id,
        $user_id
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Task deleted successfully."
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to delete task."
        ]);
    }

    exit;
}


/*
|--------------------------------------------------------------------------
| Unsupported request
|--------------------------------------------------------------------------
*/

echo json_encode([
    "success" => false,
    "message" => "Unsupported request method."
]);

?>