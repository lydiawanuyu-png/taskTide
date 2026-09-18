
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

    <title>AttachTrack | Journal</title>
    <link rel="icon" type="image/png" href="favicon.png">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5eee9;
            color: #32160f;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;

            width: 240px;
            height: 100vh;

            background: #32160f;
            color: white;

            padding: 30px 20px;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            text-align: center;

            margin-bottom: 45px;
        }

        .logo span {
            color: #f2c6a0;
        }

        .menu {
            list-style: none;
        }

        .menu li {
            margin-bottom: 12px;
        }

        .menu a {
            display: block;

            padding: 14px 15px;

            color: #eadbd5;
            text-decoration: none;

            border-radius: 10px;

            transition: 0.3s;
        }

        .menu a:hover,
        .menu a.active {
            background: #6b3828;
            color: white;
        }

        .back-home {
            position: absolute;

            bottom: 30px;
            left: 20px;
            right: 20px;

            padding: 13px;

            text-align: center;

            background: #51261c;

            color: white;

            text-decoration: none;

            border-radius: 10px;
        }

        .main {
            margin-left: 240px;
            padding: 35px;
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
            margin-top: 6px;
            color: #806c64;
        }

        .date {
            background: white;

            padding: 12px 18px;

            border-radius: 10px;

            font-weight: bold;

            color: #6b3828;
        }

        .journal-card {
            background: white;

            padding: 30px;

            border-radius: 18px;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, 0.06);

            margin-bottom: 25px;
        }

        .journal-card h2 {
            margin-bottom: 8px;
        }

        .journal-description {
            color: #806c64;

            font-size: 14px;

            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;

            font-weight: bold;

            margin-bottom: 9px;
        }

        .form-group small {
            display: block;

            color: #907c73;

            margin-bottom: 8px;
        }

        textarea {
            width: 100%;

            min-height: 120px;

            padding: 14px;

            border: 1px solid #ddd0ca;

            border-radius: 10px;

            outline: none;

            resize: vertical;

            font-size: 15px;

            line-height: 1.6;
        }

        textarea:focus {
            border-color: #6b3828;

            box-shadow:
                0 0 0 3px rgba(107, 56, 40, 0.08);
        }
        
        .form-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 20px;
        }

        .buttons {
            display: flex;

            justify-content: flex-end;

            gap: 12px;

            margin-top: 10px;
        }

        .save-button {
            border: none;

            background: #6b3828;

            color: white;

            padding: 14px 28px;

            border-radius: 9px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        .save-button:hover {
            background: #32160f;

            transform: translateY(-2px);
        }

        .clear-button {
            border: 1px solid #d8c8c1;

            background: white;

            color: #6b3828;

            padding: 14px 22px;

            border-radius: 9px;

            font-weight: bold;

            cursor: pointer;
        }


        .entries-card {
            background: white;

            padding: 25px;

            border-radius: 18px;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, 0.06);
        }

        .entries-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 20px;
        }

        .entries-header h2 {
            font-size: 20px;
        }

        .entry-count {
            background: #f5eee9;

            color: #6b3828;

            padding: 7px 12px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: bold;
        }

        .entry {
            border: 1px solid #eee3de;

            border-radius: 12px;

            padding: 20px;

            margin-bottom: 15px;
        }

        .entry:last-child {
            margin-bottom: 0;
        }

        .entry-top {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 15px;
        }

        .entry-date {
            font-weight: bold;

            color: #6b3828;
        }

        .delete-entry {
            border: none;

            background: none;

            color: #a35a4a;

            cursor: pointer;

            font-size: 17px;
        }

        .entry-section {
            margin-bottom: 14px;
        }

        .entry-section:last-child {
            margin-bottom: 0;
        }

        .entry-section strong {
            display: block;

            margin-bottom: 5px;

            font-size: 14px;
        }

        .entry-section p {
            color: #5e4a43;

            font-size: 14px;

            line-height: 1.6;

            white-space: pre-wrap;
        }


        .empty {
            text-align: center;

            padding: 35px;

            color: #907c73;
        }

        .empty-icon {
            font-size: 40px;

            margin-bottom: 10px;
        }

        .message {
            display: none;

            padding: 12px 15px;

            background: #efe8e4;

            color: #6b3828;

            border-radius: 9px;

            margin-bottom: 20px;

            font-size: 14px;
        }


        @media (max-width: 800px) {

            .sidebar {
                position: relative;

                width: 100%;

                height: auto;

                padding: 20px;
            }

            .logo {
                margin-bottom: 20px;
            }

            .menu {
                display: flex;

                overflow-x: auto;

                gap: 8px;
            }

            .menu li {
                margin-bottom: 0;
            }

            .menu a {
                white-space: nowrap;
            }

            .back-home {
                display: none;
            }

            .main {
                margin-left: 0;

                padding: 20px;
            }

            .header {
                flex-direction: column;

                align-items: flex-start;

                gap: 15px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .buttons {
                flex-direction: column;
            }

            .save-button,
            .clear-button {
                width: 100%;
            }

        }

    </style>

</head>


<body>

<div class="sidebar">

    <div class="logo">
        Attach<span>Track</span>
    </div>


    <ul class="menu">

        <li>
            <a href="dashboard.php">
                🏠 Dashboard
            </a>
        </li>

        <li>
            <a href="tasks.php">
                ✓ My Tasks
            </a>
        </li>

        <li>
            <a href="journal.php" class="active">
                📓 Journal
            </a>
        </li>

        <li>
            <a href="skills.php">
                🧠 Skills
            </a>
        </li>

        <li>
            <a href="projects.php">
                💻 Projects
            </a>
        </li>

        <li>
            <a href="achievements.php">
                🏆 Achievements
            </a>
        </li>
        
        <li>
            <a href="profile.php">
                👤Profile
            </a>
        </li>

    </ul>


    <a href="index.php" class="back-home">
        ← Back to Home
    </a>

</div>

<div class="main">


    <div class="header">

        <div>

            <h1>Daily Journal 📓</h1>

            <p>
                Record your attachment experience, one day at a time.
            </p>

        </div>


        <div class="date" id="currentDate">
            Today
        </div>

    </div>

    <div class="journal-card">

        <h2>How was your day?</h2>

        <p class="journal-description">

            Take a few minutes to record what you did,
            what you learned, and what you want to improve.

        </p>


        <div
            class="message"
            id="message"
        ></div>


        <div class="form-group">

            <label>
                📋 What did you work on today?
            </label>

            <small>
                Describe the tasks, assignments or activities you worked on.
            </small>

            <textarea
                id="activities"
                placeholder="Today I worked on..."
            ></textarea>

        </div>

        <div class="form-group">

            <label>
                🧠 What did you learn today?
            </label>

            <small>
                Write down new skills, concepts or knowledge you gained.
            </small>

            <textarea
                id="learning"
                placeholder="Today I learned..."
            ></textarea>

        </div>

        <div class="form-grid">


            <div class="form-group">

                <label>
                    🐛 Challenges
                </label>

                <small>
                    What was difficult?
                </small>

                <textarea
                    id="challenges"
                    placeholder="I struggled with..."
                ></textarea>

            </div>



            <div class="form-group">

                <label>
                    💡 How did I solve it?
                </label>

                <small>
                    How did you overcome the challenge?
                </small>

                <textarea
                    id="solutions"
                    placeholder="I solved it by..."
                ></textarea>

            </div>

        </div>

        <div class="form-group">

            <label>
                🏆 Something I'm proud of
            </label>

            <small>
                It doesn't have to be something big.
            </small>

            <textarea
                id="achievement"
                placeholder="Today I'm proud that..."
            ></textarea>

        </div>

        <div class="form-group">

            <label>
                🎯 What do I want to do tomorrow?
            </label>

            <small>
                Set an intention for your next attachment day.
            </small>

            <textarea
                id="tomorrow"
                placeholder="Tomorrow I want to..."
            ></textarea>

        </div>

        <div class="buttons">

            <button
                class="clear-button"
                onclick="clearForm()"
            >
                Clear
            </button>

            <button
                class="save-button"
                onclick="saveJournal()"
            >
                💾 Save Today's Journal
            </button>

        </div>

    </div>

    <div class="entries-card">

        <div class="entries-header">

            <h2>
                My Journal Entries
            </h2>

            <span
                class="entry-count"
                id="entryCount"
            >
                0 entries
            </span>

        </div>


        <div id="entriesList">

    
        </div>

    </div>

</div>



<script>

    

async function loadJournals() {

    try {

        const response = await fetch("api/journal.php");

        const result = await response.json();

        console.log("Journal API:", result);

        if (!result.success) {

            showMessage(
                result.message || "Could not load journals."
            );

            return;
        }

        journals = result.data || [];

        displayJournals();

    } catch (error) {

        console.error("Error loading journals:", error);

        showMessage(
            "Could not load journal entries from the database."
        );
    }
}
    const today = new Date();

    const dateString =
        today.toLocaleDateString(
            "en-US",
            {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric"
            }
        );


    document.getElementById(
        "currentDate"
    ).textContent = dateString;

    async function saveJournal() {

    const activities = document.getElementById("activities").value.trim();
    const learning = document.getElementById("learning").value.trim();
    const challenges = document.getElementById("challenges").value.trim();
    const solutions = document.getElementById("solutions").value.trim();
    const achievement = document.getElementById("achievement").value.trim();
    const tomorrow = document.getElementById("tomorrow").value.trim();

    if (activities === "" && learning === "") {
        showMessage(
            "Please write something about your activities or learning today."
        );
        return;
    }

    try {

        const response = await fetch("api/journal.php", {
            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({
                journal_date: new Date().toISOString().split("T")[0],
                activities: activities,
                learning: learning,
                challenges: challenges,
                solutions: solutions,
                achievement: achievement,
                tomorrow: tomorrow
            })
        });

        const result = await response.json();

        if (result.success) {

            clearForm();

            await loadJournals();

            showMessage(result.message);

        } else {

            showMessage(
                result.message || "Failed to save journal."
            );
        }

    } catch (error) {

        console.error("Error saving journal:", error);

        showMessage("Could not save journal.");
    }
}


    function displayJournals() {

        const entriesList =
            document.getElementById(
                "entriesList"
            );


        entriesList.innerHTML = "";


        document.getElementById(
            "entryCount"
        ).textContent =
            journals.length +
            (journals.length === 1
                ? " entry"
                : " entries");


        if (journals.length === 0) {

            entriesList.innerHTML = `

                <div class="empty">

                    <div class="empty-icon">
                        📓
                    </div>

                    <p>
                        No journal entries yet.
                    </p>

                    <small>
                        Your attachment story starts today.
                    </small>

                </div>

            `;

            return;

        }


        journals.forEach(function(journal) {

            const entry =
                document.createElement("div");

            entry.className = "entry";


            entry.innerHTML = `

                <div class="entry-top">

                    <div class="entry-date">
                        ${journal.date}
                    </div>

                    <button
                        class="delete-entry"
                        onclick="deleteJournal(${journal.id})"
                    >
                        🗑
                    </button>

                </div>


                ${
                    journal.activities
                    ? `
                        <div class="entry-section">

                            <strong>
                                📋 What I worked on
                            </strong>

                            <p>
                                ${escapeHTML(
                                    journal.activities
                                )}
                            </p>

                        </div>
                    `
                    : ""
                }


                ${
                    journal.learning
                    ? `
                        <div class="entry-section">

                            <strong>
                                🧠 What I learned
                            </strong>

                            <p>
                                ${escapeHTML(
                                    journal.learning
                                )}
                            </p>

                        </div>
                    `
                    : ""
                }


                ${
                    journal.challenges
                    ? `
                        <div class="entry-section">

                            <strong>
                                🐛 Challenges
                            </strong>

                            <p>
                                ${escapeHTML(
                                    journal.challenges
                                )}
                            </p>

                        </div>
                    `
                    : ""
                }


                ${
                    journal.solutions
                    ? `
                        <div class="entry-section">

                            <strong>
                                💡 How I solved it
                            </strong>

                            <p>
                                ${escapeHTML(
                                    journal.solutions
                                )}
                            </p>

                        </div>
                    `
                    : ""
                }


                ${
                    journal.achievement
                    ? `
                        <div class="entry-section">

                            <strong>
                                🏆 Something I'm proud of
                            </strong>

                            <p>
                                ${escapeHTML(
                                    journal.achievement
                                )}
                            </p>

                        </div>
                    `
                    : ""
                }


                ${
                    journal.tomorrow
                    ? `
                        <div class="entry-section">

                            <strong>
                                🎯 Tomorrow
                            </strong>

                            <p>
                                ${escapeHTML(
                                    journal.tomorrow
                                )}
                            </p>

                        </div>
                    `
                    : ""
                }

            `;


            entriesList.appendChild(entry);

        });

    }


async function deleteJournal(id) {

    const confirmed = confirm("Delete this journal entry?");

    if (!confirmed) {
        return;
    }

    try {

        const response = await fetch("api/journal.php", {
            method: "DELETE",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({
                id: id
            })
        });

        const result = await response.json();

        if (result.success) {

            await loadJournals();

            showMessage(result.message);

        } else {

            showMessage(
                result.message || "Failed to delete journal."
            );
        }

    } catch (error) {

        console.error("Error deleting journal:", error);

        showMessage("Could not delete journal.");
    }
}
        function clearForm() {

        document.getElementById(
            "activities"
        ).value = "";


        document.getElementById(
            "learning"
        ).value = "";


        document.getElementById(
            "challenges"
        ).value = "";


        document.getElementById(
            "solutions"
        ).value = "";


        document.getElementById(
            "achievement"
        ).value = "";


        document.getElementById(
            "tomorrow"
        ).value = "";

    }

    function showMessage(text) {

        const message =
            document.getElementById(
                "message"
            );


        message.textContent = text;

        message.style.display = "block";


        setTimeout(function() {

            message.style.display = "none";

        }, 3000);

    }


    function escapeHTML(text) {

        const div =
            document.createElement("div");

        div.textContent = text;

        return div.innerHTML;

    }


    loadJournals();

</script>


</body>

</html>

