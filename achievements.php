<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AttachTrack - Achievements</title>
    <link rel="icon" type="image/png" href="favicon.png">

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5eee8;
            color: #3b2420;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 240px;
            height: 100vh;

            background: linear-gradient(
                180deg,
                #4b2520,
                #2f1815
            );

            color: white;
            padding: 25px 15px;
        }

        .logo {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 35px;
        }

        .logo span {
            color: #d8a47f;
        }

        .nav-link {
            display: block;
            text-decoration: none;
            color: #eadbd4;

            padding: 13px 15px;
            margin: 7px 0;

            border-radius: 10px;

            transition: 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(4px);
        }

        .main {
            margin-left: 240px;
            padding: 35px;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 30px;
        }

        .top h1 {
            color: #4b2520;
            margin-bottom: 6px;
        }

        .top p {
            color: #806b63;
        }

        .profile {
            width: 45px;
            height: 45px;

            border-radius: 50%;

            background: #8b4f3f;
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: bold;
        }

        .add-achievement {
            background: white;

            border-radius: 18px;
            padding: 25px;

            box-shadow:
                0 8px 25px rgba(70, 35, 25, 0.08);

            margin-bottom: 30px;
        }

        .add-achievement h2 {
            color: #4b2520;
            margin-bottom: 20px;
        }

        .form-grid {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        textarea,
        select {

            padding: 12px;

            border: 1px solid #dcc9bf;
            border-radius: 9px;

            background: #fffaf7;

            color: #3b2420;

            outline: none;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #8b4f3f;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        .add-btn {
            margin-top: 20px;

            padding: 13px 25px;

            border: none;
            border-radius: 9px;

            background: #6f382f;
            color: white;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        .add-btn:hover {
            background: #4b2520;
            transform: translateY(-2px);
        }

        .summary {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 18px;

            margin-bottom: 30px;
        }

        .summary-card {
            background: white;

            padding: 22px;

            border-radius: 15px;

            box-shadow:
                0 6px 20px rgba(70, 35, 25, 0.07);
        }

        .summary-card h3 {
            font-size: 14px;
            color: #8b6b61;

            margin-bottom: 8px;
        }

        .summary-card p {
            font-size: 28px;

            font-weight: bold;

            color: #4b2520;
        }

        .achievements-section h2 {
            color: #4b2520;
            margin-bottom: 20px;
        }

        .achievements-container {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 20px;
        }


        .achievement-card {

            position: relative;

            background: white;

            padding: 25px;

            border-radius: 18px;

            box-shadow:
                0 8px 25px rgba(70, 35, 25, 0.08);

            transition: 0.3s;
        }

        .achievement-card:hover {

            transform: translateY(-4px);

            box-shadow:
                0 12px 30px rgba(70, 35, 25, 0.12);
        }


        .achievement-icon {

            width: 55px;
            height: 55px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #f1e5df;

            border-radius: 15px;

            font-size: 27px;

            margin-bottom: 15px;
        }


        .achievement-header {

            display: flex;

            justify-content: space-between;

            align-items: flex-start;

            gap: 10px;

            margin-bottom: 10px;
        }

        .achievement-header h3 {

            color: #4b2520;

            font-size: 20px;
        }


        .level {

            padding: 6px 10px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: bold;

            white-space: nowrap;
        }

        .beginner {
            background: #eee3dc;
            color: #70554b;
        }

        .good {
            background: #f1dcc7;
            color: #87552d;
        }

        .great {
            background: #e5e0c8;
            color: #655d2f;
        }

        .excellent {
            background: #dcebdc;
            color: #37643b;
        }


        .achievement-description {

            color: #705b55;

            line-height: 1.6;

            margin-bottom: 15px;
        }


        .achievement-info {

            display: flex;

            flex-wrap: wrap;

            gap: 8px;

            margin-bottom: 15px;
        }

        .badge {

            background: #f7eee9;

            color: #6f382f;

            padding: 6px 9px;

            border-radius: 7px;

            font-size: 12px;
        }


        .achievement-date {

            color: #8b6b61;

            font-size: 13px;

            margin-bottom: 15px;
        }


        .delete-btn {

            border: none;

            background: #f3dddd;

            color: #9a3e3e;

            padding: 9px 14px;

            border-radius: 8px;

            cursor: pointer;
        }

        .delete-btn:hover {
            background: #ebcaca;
        }


        .empty {

            background: white;

            padding: 45px;

            text-align: center;

            border-radius: 15px;

            color: #8b6b61;

            grid-column: 1 / -1;
        }
             .logout a {
            display: block;
            padding: 13px;
            text-align: center;

            background: #51261c;
            color: white;

            text-decoration: none;
            border-radius: 10px;
        }

        .empty h3 {
            margin-bottom: 8px;
            color: #4b2520;
        }

        @media (max-width: 800px) {

            .sidebar {

                position: relative;

                width: 100%;

                height: auto;
            }
         



            .main {

                margin-left: 0;

                padding: 20px;
            }

            .form-grid,
            .achievements-container,
            .summary {

                grid-template-columns: 1fr;
            }

            .form-group.full {

                grid-column: auto;
            }

            .top {

                gap: 15px;
            }
        }

    </style>
</head>


<body>

<div class="sidebar">

    <div class="logo">
        Attach<span>Track</span>
    </div>

    <a href="dashboard.php" class="nav-link">
        🏠 Dashboard
    </a>

    <a href="tasks.php" class="nav-link">
        ✓ Tasks
    </a>

    <a href="journal.php" class="nav-link">
        📖 Journal
    </a>

    <a href="skills.php" class="nav-link">
        💡 Skills
    </a>

    <a href="projects.php" class="nav-link">
        🚀 Projects
    </a>

    <a href="achievements.php" class="nav-link active">
        🏆 Achievements
    </a>

    <a href="profile.php" class="nav-link">
        👤Profile
    </a><br><br>

    <div class="logout">
    <a href="index.php" class="back-home"> ← Back to Home</a></div>
</div>

<div class="main">

    <div class="top">

        <div>

            <h1>My Achievements 🏆</h1>

            <p>
                Celebrate the things you accomplish during your attachment.
            </p>

        </div>

        <div class="profile">
            L
        </div>

    </div>

    <div class="add-achievement">

        <h2>＋ Add Achievement</h2>


        <form id="achievementForm">

            <div class="form-grid">


                <div class="form-group">

                    <label>
                        Achievement Title
                    </label>

                    <input
                        type="text"
                        id="achievementTitle"
                        placeholder="e.g. Built my first PHP system"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Category
                    </label>

                    <select id="achievementCategory">

                        <option value="Technical">
                            Technical
                        </option>

                        <option value="Project">
                            Project
                        </option>

                        <option value="Learning">
                            Learning
                        </option>

                        <option value="Problem Solving">
                            Problem Solving
                        </option>

                        <option value="Teamwork">
                            Teamwork
                        </option>

                        <option value="Other">
                            Other
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Achievement Level
                    </label>

                    <select id="achievementLevel">

                        <option value="Beginner">
                            🌱 Beginner
                        </option>

                        <option value="Good">
                            ⭐ Good
                        </option>

                        <option value="Great">
                            🌟 Great
                        </option>

                        <option value="Excellent">
                            🏆 Excellent
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Date Achieved
                    </label>

                    <input
                        type="date"
                        id="achievementDate"
                        required
                    >

                </div>


                <div class="form-group full">

                    <label>
                        Description
                    </label>

                    <textarea
                        id="achievementDescription"
                        placeholder="Explain what you achieved and why it matters..."
                        required
                    ></textarea>

                </div>

            </div>


            <button
                type="submit"
                class="add-btn"
            >
                Add Achievement
            </button>

        </form>

    </div>

    <div class="summary">

        <div class="summary-card">

            <h3>
                Total Achievements
            </h3>

            <p id="totalAchievements">
                0
            </p>

        </div>


        <div class="summary-card">

            <h3>
                Great & Excellent
            </h3>

            <p id="greatAchievements">
                0
            </p>

        </div>


        <div class="summary-card">

            <h3>
                This Month
            </h3>

            <p id="monthAchievements">
                0
            </p>

        </div>

    </div>

    <div class="achievements-section">

        <h2>
            My Milestones
        </h2>


        <div
            class="achievements-container"
            id="achievementsContainer"
        >

        </div>

    </div>


</div>


<script>

    const form =
        document.getElementById("achievementForm");

    const container =
        document.getElementById("achievementsContainer");



    let achievements = [];


    async function loadAchievements() {

        try {

            const response =
                await fetch("api/achievements.php");


            const result =
                await response.json();


            if (!response.ok) {

                alert(
                    result.message ||
                    "Failed to load achievements."
                );

                return;
            }


            if (result.success) {

                achievements =
                    result.data || [];

                displayAchievements();

            } else {

                alert(
                    result.message ||
                    "Failed to load achievements."
                );

            }

        } catch (error) {

            console.error(
                "Error loading achievements:",
                error
            );

            alert(
                "Could not connect to the achievements API."
            );

        }

    }


    /*
    ============================================================
    ESCAPE HTML
    ============================================================
    */

    function escapeHTML(text) {

        const div =
            document.createElement("div");

        div.textContent =
            text ?? "";

        return div.innerHTML;

    }


    /*
    ============================================================
    GET ICON
    ============================================================
    */

    function getIcon(category) {

        const icons = {

            "Technical": "💻",

            "Project": "🚀",

            "Learning": "📚",

            "Problem Solving": "🧩",

            "Teamwork": "🤝",

            "Other": "🏆"

        };


        return icons[category] || "🏆";

    }


    /*
    ============================================================
    DISPLAY ACHIEVEMENTS
    ============================================================
    */

    function displayAchievements() {

        container.innerHTML = "";


        if (achievements.length === 0) {

            container.innerHTML = `

                <div class="empty">

                    <h3>
                        No achievements yet 🏆
                    </h3>

                    <p>
                        Your first achievement is waiting to be added!
                    </p>

                </div>

            `;

        } else {


            achievements.forEach(
                (achievement) => {


                    /*
                    Determine level CSS class
                    */

                    let levelClass =
                        "beginner";


                    if (
                        achievement.level === "Good"
                    ) {

                        levelClass =
                            "good";

                    }


                    if (
                        achievement.level === "Great"
                    ) {

                        levelClass =
                            "great";

                    }


                    if (
                        achievement.level === "Excellent"
                    ) {

                        levelClass =
                            "excellent";

                    }


                    /*
                    Create achievement card
                    */

                    container.innerHTML += `

                        <div class="achievement-card">


                            <div class="achievement-icon">

                                ${getIcon(
                                    achievement.category
                                )}

                            </div>


                            <div class="achievement-header">

                                <h3>

                                    ${escapeHTML(
                                        achievement.title
                                    )}

                                </h3>


                                <span
                                    class="level ${levelClass}"
                                >

                                    ${escapeHTML(
                                        achievement.level
                                    )}

                                </span>

                            </div>


                            <div class="achievement-info">

                                <span class="badge">

                                    ${escapeHTML(
                                        achievement.category
                                    )}

                                </span>

                            </div>


                            <div class="achievement-date">

                                📅 Achieved:

                                ${escapeHTML(
                                    achievement.achievement_date
                                )}

                            </div>


                            <button
                                class="delete-btn"
                                onclick="deleteAchievement(
                                    ${achievement.id}
                                )"
                            >

                                Delete

                            </button>


                        </div>

                    `;

                }
            );

        }


        updateSummary();

    }


    /*
    ============================================================
    UPDATE SUMMARY
    ============================================================
    */

    function updateSummary() {


        /*
        Total achievements
        */

        document.getElementById(
            "totalAchievements"
        ).textContent =
            achievements.length;


        /*
        Great + Excellent
        */

        const great =
            achievements.filter(
                achievement =>

                    achievement.level === "Great" ||

                    achievement.level === "Excellent"

            ).length;


        document.getElementById(
            "greatAchievements"
        ).textContent =
            great;


        /*
        Achievements this month
        */

        const currentDate =
            new Date();


        const currentMonth =
            currentDate.getMonth();


        const currentYear =
            currentDate.getFullYear();


        const thisMonth =
            achievements.filter(
                achievement => {


                    const date =
                        new Date(
                            achievement.achievement_date
                        );


                    return (

                        date.getMonth() ===
                        currentMonth

                        &&

                        date.getFullYear() ===
                        currentYear

                    );

                }

            ).length;


        document.getElementById(
            "monthAchievements"
        ).textContent =
            thisMonth;

    }


    /*
    ============================================================
    ADD ACHIEVEMENT
    ============================================================
    */

    form.addEventListener(
        "submit",
        async function(event) {


            /*
            Stop the page from refreshing
            */

            event.preventDefault();


            /*
            Get values from form
            */

            const achievement = {

                title:

                    document
                        .getElementById(
                            "achievementTitle"
                        )
                        .value
                        .trim(),


                category:

                    document
                        .getElementById(
                            "achievementCategory"
                        )
                        .value,


                level:

                    document
                        .getElementById(
                            "achievementLevel"
                        )
                        .value,


                achievement_date:

                    document
                        .getElementById(
                            "achievementDate"
                        )
                        .value

            };


            /*
            Basic validation
            */

            if (
                !achievement.title ||
                !achievement.achievement_date
            ) {

                alert(
                    "Please fill in all required fields."
                );

                return;

            }


            try {


                /*
                Send achievement to API
                */

                const response =
    await fetch(
        "api/achievements.php",
        {

            method: "POST",

            headers: {

                "Content-Type":
                    "application/json"

            },

            body:
                JSON.stringify(
                    achievement
                )

        }
    );


                /*
                Get API response
                */

                const result =
                    await response.json();


                /*
                Check response
                */

                if (
                    response.ok &&
                    result.success
                ) {


                    /*
                    Clear form
                    */

                    form.reset();


                    /*
                    Put today's date back
                    */

                    setToday();


                    /*
                    Load the updated
                    achievements from MySQL
                    */

                    await loadAchievements();


                    alert(
                        "Achievement added successfully!"
                    );


                } else {


                    alert(
                        result.message ||
                        "Failed to add achievement."
                    );

                }


            } catch (error) {


                console.error(
                    "Error adding achievement:",
                    error
                );


                alert(
                    "Could not connect to the achievements API."
                );

            }

        }
    );


    /*
    ============================================================
    DELETE ACHIEVEMENT
    ============================================================
    */

    async function deleteAchievement(id) {


        if (
            !confirm(
                "Delete this achievement?"
            )
        ) {

            return;

        }


        try {


            /*
            Send DELETE request

            Example:

            achievements_api.php?id=5
            */

            const response =
                await fetch(
                    `api/achievements.php?id=${id}`,
                    {

                        method: "DELETE"

                    }
                );


            /*
            Get API response
            */

            const result =
                await response.json();


            /*
            Check result
            */

            if (
                response.ok &&
                result.success
            ) {


                /*
                Reload achievements
                from MySQL
                */

                await loadAchievements();


            } else {


                alert(
                    result.message ||
                    "Failed to delete achievement."
                );

            }


        } catch (error) {


            console.error(
                "Error deleting achievement:",
                error
            );


            alert(
                "Could not connect to the achievements API."
            );

        }

    }


    /*
    ============================================================
    SET TODAY'S DATE
    ============================================================
    */

    function setToday() {


        const today =
            new Date();


        const year =
            today.getFullYear();


        const month =
            String(
                today.getMonth() + 1
            ).padStart(
                2,
                "0"
            );


        const day =
            String(
                today.getDate()
            ).padStart(
                2,
                "0"
            );


        document.getElementById(
            "achievementDate"
        ).value =
            `${year}-${month}-${day}`;

    }


    /*
    ============================================================
    START PAGE
    ============================================================
    */

    setToday();

    loadAchievements();


</script>

</body>
</html>