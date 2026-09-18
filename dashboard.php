<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AttachTrack - Dashboard</title>
    <link rel="icon" type="image/png" href="favicon.png">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4eee9;
            color: #3b2520;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 240px;
            height: 100vh;

            background: linear-gradient(
                180deg,
                #3d211b,
                #5a2e25
            );

            color: white;
            padding: 25px 18px;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 40px;
            text-align: center;
        }

        .nav-link {
            display: block;
            padding: 13px 15px;
            margin-bottom: 8px;

            color: #f5e9e4;
            text-decoration: none;

            border-radius: 10px;
            transition: 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255,255,255,0.15);
            transform: translateX(4px);
        }

    
        .main {
            margin-left: 240px;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 30px;
        }

        .header p {
            color: #80655d;
            margin-top: 6px;
        }

        .profile {
            width: 48px;
            height: 48px;

            border-radius: 50%;

            background: #6f3b30;
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 20px;
            font-weight: bold;
        }

        .progress-card {
            background: linear-gradient(
                135deg,
                #6f3b30,
                #3e241e
            );

            color: white;

            padding: 30px;
            border-radius: 20px;

            margin-bottom: 25px;

            box-shadow: 0 10px 30px rgba(60,30,20,0.2);
        }

        .progress-top {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 20px;
        }

        .progress-top h2 {
            font-size: 22px;
        }

        .percentage {
            font-size: 30px;
            font-weight: bold;
        }

        .progress-bar {
            width: 100%;
            height: 12px;

            background: rgba(255,255,255,0.2);

            border-radius: 20px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 0%;

            background: white;

            border-radius: 20px;

            transition: width 0.6s ease;
        }

        .progress-details {
            display: flex;
            justify-content: space-between;

            margin-top: 15px;

            font-size: 14px;
            opacity: 0.9;
        }

        .stats {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 18px;

            margin-bottom: 25px;
        }

        .stat-card {
            background: white;

            padding: 22px;

            border-radius: 16px;

            box-shadow:
                0 5px 20px rgba(70,40,30,0.08);

            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
        }

        .stat-icon {
            font-size: 28px;
            margin-bottom: 12px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;

            color: #5a2e25;
        }

        .stat-label {
            color: #8b7169;
            margin-top: 5px;
        }

        .dashboard-grid {
            display: grid;

            grid-template-columns:
                2fr 1fr;

            gap: 20px;
        }

        .card {
            background: white;

            padding: 25px;

            border-radius: 18px;

            box-shadow:
                0 5px 20px rgba(70,40,30,0.08);
        }

        .card h2 {
            margin-bottom: 18px;
        }

        .task-item {
            display: flex;

            justify-content: space-between;
            align-items: center;

            padding: 14px;

            border-bottom: 1px solid #eee;
        }

        .task-item:last-child {
            border-bottom: none;
        }

        .task-complete {
            text-decoration: line-through;
            color: #9a8881;
        }

        .task-status {
            font-size: 13px;

            padding: 5px 10px;

            border-radius: 20px;

            background: #eee4df;
        }


        .journal-box {
            background: #f8f3f0;

            padding: 18px;

            border-radius: 12px;

            line-height: 1.6;

            color: #604c45;
        }

        .empty {
            color: #9a8881;
            text-align: center;
            padding: 20px;
        }

        .streak {
            text-align: center;
            padding: 15px;
        }

        .streak-number {
            font-size: 45px;
            font-weight: bold;
            color: #6f3b30;
        }

        @media(max-width: 1000px) {

            .stats {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

        }

        @media(max-width: 700px) {

            .sidebar {
                width: 70px;
                padding: 20px 8px;
            }

            .logo {
                font-size: 0;
            }

            .logo::after {
                content: "A";
                font-size: 25px;
            }

            .nav-link {
                text-align: center;
                font-size: 0;
            }

            .nav-link::first-letter {
                font-size: 18px;
            }

            .main {
                margin-left: 70px;
                padding: 20px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .progress-top {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

        }
        img {
    width: 75px;
    height: 45px;
    object-fit: cover;
    vertical-align: middle;
}

    </style>
</head>

<body>

<div class="sidebar">

    <div class="logo">
        AttachTrack
    </div>

    <a href="dashboard.php" class="nav-link active">
        🏠 Dashboard
    </a>

    <a href="tasks.php" class="nav-link">
        ✅ Tasks
    </a>

    <a href="journal.php" class="nav-link">
        📖 Journal
    </a>

    <a href="skills.php" class="nav-link">
        🧠 Skills
    </a>

    <a href="projects.php" class="nav-link">
        💻 Projects
    </a>

    <a href="achievements.php" class="nav-link">
        🏆 Achievements
    </a>

    <a href="profile.php" class="nav-link">
        👤 Profile
    </a>

    <a href="logout.php" class="nav-link">
    🚪 Logout
</a>

</div>
<div class="main">
    <div class="header">

        <div>

        <img src="welcome.jpg"><br><br>
            <h1 id="greeting">
    Welcome back, <?php echo htmlspecialchars($username); ?>! 
</h1>

            <p id="organizationText">
                Keep making progress on your attachment journey.
            </p>

        </div>

        <div class="profile" id="dashboardInitial">
            L
        </div>

    </div>

    <div class="progress-card">

        <div class="progress-top">

            <div>

                <h2 id="weekText">
                    Attachment Progress
                </h2>

                <p id="progressMessage">
                    Keep going! You're doing great.
                </p>

            </div>

            <div class="percentage"
                 id="attachmentPercentage">
                0%
            </div>

        </div>


        <div class="progress-bar">

            <div
                class="progress-fill"
                id="attachmentProgress">
            </div>

        </div>


        <div class="progress-details">

            <span id="startDate">
                Start: —
            </span>

            <span id="daysRemaining">
                — days remaining
            </span>

            <span id="endDate">
                End: —
            </span>

        </div>

    </div>

    <div class="stats">

        <div class="stat-card">

            <div class="stat-icon">
                ✅
            </div>

            <div
                class="stat-number"
                id="totalTasks">
                0
            </div>

            <div class="stat-label">
                Total Tasks
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                🎯
            </div>

            <div
                class="stat-number"
                id="completedTasks">
                0
            </div>

            <div class="stat-label">
                Completed Tasks
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                🧠
            </div>

            <div
                class="stat-number"
                id="totalSkills">
                0
            </div>

            <div class="stat-label">
                Skills
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                💻
            </div>

            <div
                class="stat-number"
                id="totalProjects">
                0
            </div>

            <div class="stat-label">
                Projects
            </div>

        </div>

    </div>

    <div class="stats">

        <div class="stat-card">

            <div class="stat-icon">
                🏆
            </div>

            <div
                class="stat-number"
                id="totalAchievements">
                0
            </div>

            <div class="stat-label">
                Achievements
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                📖
            </div>

            <div
                class="stat-number"
                id="totalJournals">
                0
            </div>

            <div class="stat-label">
                Journal Entries
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                📈
            </div>

            <div
                class="stat-number"
                id="taskPercentage">
                0%
            </div>

            <div class="stat-label">
                Task Completion
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                🔥
            </div>

            <div
                class="stat-number"
                id="streakNumber">
                0
            </div>

            <div class="stat-label">
                Day Streak
            </div>

        </div>

    </div>

    <div class="dashboard-grid">

        <div class="card">

            <h2>
                Today's Tasks
            </h2>

            <div id="todayTasks">

                <div class="empty">
                    No tasks for today.
                </div>

            </div>

        </div>

        <div class="card">

            <h2>
                Latest Journal
            </h2>

            <div id="latestJournal">

                <div class="empty">
                    No journal entries yet.
                </div>

            </div>

        </div>

    </div>

</div>


<script>

document.addEventListener("DOMContentLoaded", function () {

    loadDashboard();

});


/* =========================
   LOAD DASHBOARD FROM API
========================= */

async function loadDashboard() {

    try {

        const response =
            await fetch("api/dashboard.php");

        const result =
            await response.json();


        console.log("Dashboard API:", result);


        if (!result.success) {

            console.error(
                "Dashboard API error:",
                result.message
            );

            return;

        }


        /* =========================
           GET DATA
        ========================= */

        const profile =
            result.profile || {};


        const tasks =
            result.tasks || {};


        const journals =
            result.journals || {};


        const skills =
            result.skills || {};


        const projects =
            result.projects || {};


        const achievements =
            result.achievements || {};


        const attachment =
            result.attachment || {};


        /* =========================
           PROFILE
        ========================= */

        loadProfile(profile);


        /* =========================
           TASKS
        ========================= */

        document.getElementById("totalTasks")
            .textContent =
            tasks.total || 0;


        document.getElementById("completedTasks")
            .textContent =
            tasks.completed || 0;


        document.getElementById("taskPercentage")
            .textContent =
            (tasks.completion_percentage || 0) + "%";


        /* =========================
           SKILLS
        ========================= */

        document.getElementById("totalSkills")
            .textContent =
            skills.total || 0;


        /* =========================
           PROJECTS
        ========================= */

        document.getElementById("totalProjects")
            .textContent =
            projects.total || 0;


        /* =========================
           ACHIEVEMENTS
        ========================= */

        document.getElementById("totalAchievements")
            .textContent =
            achievements.total || 0;


        /* =========================
           JOURNALS
        ========================= */

        document.getElementById("totalJournals")
            .textContent =
            journals.total || 0;


        /* =========================
           TODAY'S TASKS
        ========================= */

        loadTodayTasks(
            tasks.today || []
        );


        /* =========================
           LATEST JOURNAL
        ========================= */

        loadLatestJournal(
            journals.latest
        );


        /* =========================
           JOURNAL STREAK
        ========================= */

        calculateStreak(
            journals.all || []
        );


        /* =========================
           ATTACHMENT PROGRESS
        ========================= */

        loadAttachmentProgress(
            attachment
        );

    }

    catch (error) {

        console.error(
            "Dashboard connection error:",
            error
        );

    }

}


/* =========================
   PROFILE
========================= */

function loadProfile(profile) {

    const fullName =
        profile.name || "there ";


    const firstName =
        fullName.split(" ")[0];


    /* Organization */

    const organizationElement =
        document.getElementById(
            "organizationText"
        );


    if (organizationElement) {

        organizationElement.textContent =
            profile.organization

                ? `You're making progress at ${profile.organization}.`

                : "Keep making progress on your attachment journey.""Tap profile to to enter your details";

    }


    /* Profile initial */

    const initialElement =
        document.getElementById(
            "dashboardInitial"
        );


    if (
        initialElement &&
        profile.name
    ) {

        initialElement.textContent =
            profile.name
                .charAt(0)
                .toUpperCase();

    }


    /* If you have a greeting element */

    const greetingElement =
        document.getElementById(
            "greeting"
        );


    if (greetingElement) {

        greetingElement.textContent =
            `Welcome back, ${firstName}!`;

    }

}


/* =========================
   TODAY'S TASKS
========================= */

function loadTodayTasks(tasks) {

    const container =
        document.getElementById(
            "todayTasks"
        );


    if (!container) {

        return;

    }


    if (tasks.length === 0) {

        container.innerHTML = `

            <div class="empty">

                No tasks for today.

            </div>

        `;

        return;

    }


    container.innerHTML =

        tasks.map(task => {

            const completed =
                Number(task.completed) === 1;


            return `

                <div class="task-item">

                    <span class="${
                        completed
                            ? "task-complete"
                            : ""
                    }">

                        ${escapeHTML(
                            task.title
                        )}

                    </span>


                    <span class="task-status">

                        ${
                            completed
                                ? "Completed"
                                : "Pending"
                        }

                    </span>

                </div>

            `;

        }).join("");

}


/* =========================
   LATEST JOURNAL
========================= */

function loadLatestJournal(journal) {

    const container =
        document.getElementById(
            "latestJournal"
        );


    if (!container) {

        return;

    }


    if (!journal) {

        container.innerHTML = `

            <div class="empty">

                No journal entries yet.

            </div>

        `;

        return;

    }


    const date =
        journal.journal_date ||
        journal.date ||
        journal.created_at ||
        "Recent entry";


    const activities =
        journal.activities || "";


    const learning =
        journal.learning || "";


    const text =
        activities ||
        learning ||
        "Journal entry saved.";


    container.innerHTML = `

        <div class="journal-box">

            <strong>

                ${escapeHTML(
                    formatJournalDate(date)
                )}

            </strong>


            <br><br>


            ${escapeHTML(text)}

        </div>

    `;

}


/* =========================
   ATTACHMENT PROGRESS
========================= */

function loadAttachmentProgress(
    attachment
) {

    const percentage =
        Number(
            attachment.percentage || 0
        );


    const week =
        Number(
            attachment.week || 0
        );


    const daysRemaining =
        Number(
            attachment.days_remaining || 0
        );


    /* Week */

    const weekElement =
        document.getElementById(
            "weekText"
        );


    if (weekElement) {

        if (week > 0) {

            weekElement.textContent =
                `Week ${week} of 12`;

        }
        else {

            weekElement.textContent =
                "Set your attachment dates";

        }

    }


    /* Percentage */

    const percentageElement =
        document.getElementById(
            "attachmentPercentage"
        );


    if (percentageElement) {

        percentageElement.textContent =
            percentage + "%";

    }


    /* Progress bar */

    const progressElement =
        document.getElementById(
            "attachmentProgress"
        );


    if (progressElement) {

        progressElement.style.width =
            percentage + "%";

    }


    /* Days remaining */

    const daysElement =
        document.getElementById(
            "daysRemaining"
        );


    if (daysElement) {

        daysElement.textContent =
            `${daysRemaining} days remaining`;

    }


    /* Start date */

    const startElement =
        document.getElementById(
            "startDate"
        );


    if (
        startElement &&
        attachment.start_date
    ) {

        startElement.textContent =
            `Start: ${formatDate(
                new Date(
                    attachment.start_date
                )
            )}`;

    }


    /* End date */

    const endElement =
        document.getElementById(
            "endDate"
        );


    if (
        endElement &&
        attachment.end_date
    ) {

        endElement.textContent =
            `End: ${formatDate(
                new Date(
                    attachment.end_date
                )
            )}`;

    }


    /* Progress message */

    const messageElement =
        document.getElementById(
            "progressMessage"
        );


    if (!messageElement) {

        return;

    }


    if (percentage === 0) {

        messageElement.textContent =
            "Go to Profile and add your attachment dates.";

    }

    else if (percentage < 25) {

        messageElement.textContent =
            "You're just getting started. Keep going! 🚀";

    }

    else if (percentage < 50) {

        messageElement.textContent =
            "You're building momentum. Keep learning! 💪";

    }

    else if (percentage < 75) {

        messageElement.textContent =
            "You're more than halfway there! 🔥";

    }

    else {

        messageElement.textContent =
            "You're almost there! Finish strong! 🏆";

    }

}


/* =========================
   JOURNAL STREAK
========================= */

function calculateStreak(journals) {

    const streakElement =
        document.getElementById(
            "streakNumber"
        );


    if (!streakElement) {

        return;

    }


    if (journals.length === 0) {

        streakElement.textContent =
            "0";

        return;

    }


    /* Get unique journal dates */

    const dates = [

        ...new Set(

            journals

                .map(journal =>
                    journal.journal_date ||
                    journal.date
                )

                .filter(Boolean)

                .map(date =>
                    date.substring(0, 10)
                )

        )

    ];


    dates.sort().reverse();


    let streak = 0;


    let currentDate =
        new Date();


    currentDate.setHours(
        0,
        0,
        0,
        0
    );


    for (const date of dates) {

        const journalDate =
            new Date(date);


        journalDate.setHours(
            0,
            0,
            0,
            0
        );


        const difference =
            Math.floor(
                (
                    currentDate -
                    journalDate
                ) /
                (
                    1000 *
                    60 *
                    60 *
                    24
                )
            );


        if (difference === 0) {

            streak++;

            currentDate =
                journalDate;

        }

        else if (difference === 1) {

            streak++;

            currentDate =
                journalDate;

        }

        else {

            break;

        }

    }


    streakElement.textContent =
        streak;

}


/* =========================
   DATE FORMAT
========================= */

function formatDate(date) {

    return date.toLocaleDateString(
        "en-GB",
        {
            day: "numeric",
            month: "short",
            year: "numeric"
        }
    );

}


function formatJournalDate(date) {

    const parsed =
        new Date(date);


    if (isNaN(parsed.getTime())) {

        return date;

    }


    return parsed.toLocaleDateString(
        "en-US",
        {
            weekday: "long",
            month: "long",
            day: "numeric",
            year: "numeric"
        }
    );

}


/* =========================
   SECURITY
========================= */

function escapeHTML(text) {

    return String(text)

        .replace(
            /&/g,
            "&amp;"
        )

        .replace(
            /</g,
            "&lt;"
        )

        .replace(
            />/g,
            "&gt;"
        )

        .replace(
            /"/g,
            "&quot;"
        )

        .replace(
            /'/g,
            "&#039;"
        );

}

</script>

</body>
</html>