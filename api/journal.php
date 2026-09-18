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
| GET - Get only this user's journals
|--------------------------------------------------------------------------
*/

if ($method === "GET") {

    $stmt = $conn->prepare(
        "SELECT 
            id,
            journal_date,
            activities,
            learning,
            challenges,
            solutions,
            achievement,
            tomorrow,
            created_at
         FROM journals
         WHERE user_id = ?
         ORDER BY journal_date DESC, id DESC"
    );

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    $result = $stmt->get_result();

    $journals = [];

    while ($row = $result->fetch_assoc()) {

        $journals[] = [
            "id" => $row["id"],
            "date" => $row["journal_date"],
            "activities" => $row["activities"],
            "learning" => $row["learning"],
            "challenges" => $row["challenges"],
            "solutions" => $row["solutions"],
            "achievement" => $row["achievement"],
            "tomorrow" => $row["tomorrow"],
            "created_at" => $row["created_at"]
        ];
    }

    echo json_encode([
        "success" => true,
        "data" => $journals
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| POST - Add journal for logged-in user
|--------------------------------------------------------------------------
*/

if ($method === "POST") {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    $journal_date = $data["journal_date"] ?? date("Y-m-d");

    $activities = $data["activities"] ?? "";
    $learning = $data["learning"] ?? "";
    $challenges = $data["challenges"] ?? "";
    $solutions = $data["solutions"] ?? "";
    $achievement = $data["achievement"] ?? "";
    $tomorrow = $data["tomorrow"] ?? "";


    if (empty($activities) && empty($learning)) {

        echo json_encode([
            "success" => false,
            "message" => "Please enter your activities or learning."
        ]);

        exit;
    }


    $stmt = $conn->prepare(
        "INSERT INTO journals
        (
            user_id,
            journal_date,
            activities,
            learning,
            challenges,
            solutions,
            achievement,
            tomorrow
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );


    $stmt->bind_param(
        "isssssss",
        $user_id,
        $journal_date,
        $activities,
        $learning,
        $challenges,
        $solutions,
        $achievement,
        $tomorrow
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Journal saved successfully.",
            "id" => $stmt->insert_id
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to save journal."
        ]);
    }

    exit;
}


/*
|--------------------------------------------------------------------------
| DELETE - Delete only this user's journal
|--------------------------------------------------------------------------
*/

if ($method === "DELETE") {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    $id = $data["id"] ?? 0;


    $stmt = $conn->prepare(
        "DELETE FROM journals
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
            "message" => "Journal deleted successfully."
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to delete journal."
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