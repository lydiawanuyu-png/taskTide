<?php

session_start();

require_once "../config/database.php";

header("Content-Type: application/json");


/* =========================
   CHECK LOGIN
========================= */

if (!isset($_SESSION["user_id"])) {

    echo json_encode([
        "success" => false,
        "message" => "You must be logged in."
    ]);

    exit;
}


$user_id = $_SESSION["user_id"];


/* =========================
   PROFILE
========================= */

$stmt = $conn->prepare(
    "SELECT
        id,
        name,
        organization,
        course,
        supervisor,
        start_date,
        end_date,
        bio
     FROM profiles
     WHERE user_id = ?
     LIMIT 1"
);


if (!$stmt) {

    echo json_encode([
        "success" => false,
        "message" => "Profile SQL prepare failed.",
        "error" => $conn->error
    ]);

    exit;
}


$stmt->bind_param("i", $user_id);

$stmt->execute();

$profileResult = $stmt->get_result();

$profile = $profileResult->fetch_assoc();

$stmt->close();


/* =========================
   TASKS
========================= */

$stmt = $conn->prepare(
    "SELECT
        id,
        title,
        task_date,
        completed
     FROM tasks
     WHERE user_id = ?
     ORDER BY task_date ASC, id DESC"
);


if (!$stmt) {

    echo json_encode([
        "success" => false,
        "message" => "Tasks SQL prepare failed.",
        "error" => $conn->error
    ]);

    exit;
}


$stmt->bind_param("i", $user_id);

$stmt->execute();

$taskResult = $stmt->get_result();

$tasks = [];


while ($row = $taskResult->fetch_assoc()) {

    $tasks[] = $row;

}


$stmt->close();


/* =========================
   JOURNALS
========================= */

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


if (!$stmt) {

    echo json_encode([
        "success" => false,
        "message" => "Journal SQL prepare failed.",
        "error" => $conn->error
    ]);

    exit;
}


$stmt->bind_param("i", $user_id);

$stmt->execute();

$journalResult = $stmt->get_result();

$journals = [];


while ($row = $journalResult->fetch_assoc()) {

    $journals[] = $row;

}


$stmt->close();


/* =========================
   SKILLS
========================= */

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
        "message" => "Skills SQL prepare failed.",
        "error" => $conn->error
    ]);

    exit;
}


$stmt->bind_param("i", $user_id);

$stmt->execute();

$skillResult = $stmt->get_result();

$skills = [];


while ($row = $skillResult->fetch_assoc()) {

    $skills[] = $row;

}


$stmt->close();


/* =========================
   PROJECTS
========================= */

$stmt = $conn->prepare(
    "SELECT *
     FROM projects
     WHERE user_id = ?
     ORDER BY id DESC"
);


if (!$stmt) {

    echo json_encode([
        "success" => false,
        "message" => "Projects SQL prepare failed.",
        "error" => $conn->error
    ]);

    exit;
}


$stmt->bind_param("i", $user_id);

$stmt->execute();

$projectResult = $stmt->get_result();

$projects = [];


while ($row = $projectResult->fetch_assoc()) {

    $projects[] = $row;

}


$stmt->close();


/* =========================
   ACHIEVEMENTS
========================= */

$stmt = $conn->prepare(
    "SELECT
        id,
        title,
        category,
        level,
        achievement_date,
        created_at
     FROM achievements
     WHERE user_id = ?
     ORDER BY achievement_date DESC, id DESC"
);


if (!$stmt) {

    echo json_encode([
        "success" => false,
        "message" => "Achievements SQL prepare failed.",
        "error" => $conn->error
    ]);

    exit;
}


$stmt->bind_param("i", $user_id);

$stmt->execute();

$achievementResult = $stmt->get_result();

$achievements = [];


while ($row = $achievementResult->fetch_assoc()) {

    $achievements[] = $row;

}


$stmt->close();


/* =========================
   TASK STATISTICS
========================= */

$totalTasks = count($tasks);

$completedTasks = 0;


foreach ($tasks as $task) {

    if ((int)$task["completed"] === 1) {

        $completedTasks++;

    }

}


$taskCompletion = 0;


if ($totalTasks > 0) {

    $taskCompletion =
        round(
            ($completedTasks / $totalTasks) * 100
        );

}


/* =========================
   TODAY'S TASKS
========================= */

$today = date("Y-m-d");

$todayTasks = [];


foreach ($tasks as $task) {

    if ($task["task_date"] === $today) {

        $todayTasks[] = $task;

    }

}


/* =========================
   ATTACHMENT PROGRESS
========================= */

$attachmentPercentage = 0;

$daysRemaining = 0;

$week = 0;


if (
    $profile &&
    !empty($profile["start_date"]) &&
    !empty($profile["end_date"])
) {

    $start = new DateTime(
        $profile["start_date"]
    );

    $end = new DateTime(
        $profile["end_date"]
    );

    $current = new DateTime();


    $totalDays =
        $start->diff($end)->days;


    $daysElapsed = 0;


    if ($current >= $start) {

        $daysElapsed =
            $start->diff($current)->days;

    }


    if ($current > $end) {

        $daysElapsed = $totalDays;

    }


    if ($totalDays > 0) {

        $attachmentPercentage =
            round(
                ($daysElapsed / $totalDays) * 100
            );

    }


    $attachmentPercentage =
        max(
            0,
            min(
                100,
                $attachmentPercentage
            )
        );


    $daysRemaining =
        max(
            0,
            $totalDays - $daysElapsed
        );


    $week =
        min(
            12,
            max(
                1,
                ceil(
                    ($daysElapsed / $totalDays) * 12
                )
            )
        );

}


/* =========================
   LATEST JOURNAL
========================= */

$latestJournal = null;


if (count($journals) > 0) {

    $latestJournal = $journals[0];

}


/* =========================
   RESPONSE
========================= */

echo json_encode([

    "success" => true,

    "profile" => $profile,

    "tasks" => [

        "total" => $totalTasks,

        "completed" => $completedTasks,

        "completion_percentage" =>
            $taskCompletion,

        "today" => $todayTasks,

        "all" => $tasks

    ],

    "journals" => [

        "total" => count($journals),

        "latest" => $latestJournal,

        "all" => $journals

    ],

    "skills" => [

        "total" => count($skills),

        "all" => $skills

    ],

    "projects" => [

        "total" => count($projects),

        "all" => $projects

    ],

    "achievements" => [

        "total" => count($achievements),

        "all" => $achievements

    ],

    "attachment" => [

        "percentage" =>
            $attachmentPercentage,

        "week" => $week,

        "days_remaining" =>
            $daysRemaining,

        "start_date" =>
            $profiles["start_date"] ?? null,

        "end_date" =>
            $profiles["end_date"] ?? null

    ]

]);

?>