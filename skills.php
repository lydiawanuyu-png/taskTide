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

    <title>AttachTrack | Skills</title>
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
            color: #806c64;

            margin-top: 6px;
        }

        .date {
            background: white;

            padding: 12px 18px;

            border-radius: 10px;

            color: #6b3828;

            font-weight: bold;
        }


        .summary {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 18px;

            margin-bottom: 25px;
        }

        .summary-card {
            background: white;

            padding: 22px;

            border-radius: 15px;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, 0.06);
        }

        .summary-card h3 {
            font-size: 28px;

            margin-bottom: 5px;
        }

        .summary-card p {
            color: #806c64;

            font-size: 14px;
        }


        .add-card {
            background: white;

            padding: 25px;

            border-radius: 15px;

            margin-bottom: 25px;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, 0.06);
        }

        .add-card h2 {
            margin-bottom: 18px;
        }

        .form {
            display: grid;

            grid-template-columns: 2fr 1fr 1fr auto;

            gap: 12px;
        }

        .form input,
        .form select {
            padding: 13px;

            border: 1px solid #ddd0ca;

            border-radius: 9px;

            outline: none;

            font-size: 14px;

            background: white;
        }

        .form input:focus,
        .form select:focus {
            border-color: #6b3828;
        }

        .add-button {
            border: none;

            padding: 13px 22px;

            border-radius: 9px;

            background: #6b3828;

            color: white;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        .add-button:hover {
            background: #32160f;

            transform: translateY(-2px);
        }


        .skills-card {
            background: white;

            padding: 25px;

            border-radius: 15px;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, 0.06);
        }

        .skills-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 20px;
        }

        .skills-header h2 {
            font-size: 20px;
        }

        .skill-count {
            background: #f5eee9;

            color: #6b3828;

            padding: 7px 12px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: bold;
        }


        .skill {
            padding: 20px 5px;

            border-bottom: 1px solid #eee4df;
        }

        .skill:last-child {
            border-bottom: none;
        }

        .skill-top {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 10px;
        }

        .skill-name {
            font-weight: bold;

            font-size: 16px;
        }

        .skill-category {
            color: #907c73;

            font-size: 12px;

            margin-top: 4px;
        }

        .level {
            padding: 6px 10px;

            border-radius: 20px;

            background: #f5eee9;

            color: #6b3828;

            font-size: 12px;

            font-weight: bold;
        }


        .progress-info {
            display: flex;

            justify-content: space-between;

            font-size: 13px;

            margin-bottom: 7px;
        }

        .progress-background {
            width: 100%;

            height: 9px;

            background: #eaded8;

            border-radius: 20px;

            overflow: hidden;
        }

        .progress-bar {
            height: 100%;

            background: #6b3828;

            border-radius: 20px;

            transition: width 0.3s;
        }

        .skill-actions {
            display: flex;

            gap: 8px;

            margin-top: 12px;
        }

        .action-button {
            border: 1px solid #ddd0ca;

            background: white;

            color: #6b3828;

            padding: 7px 11px;

            border-radius: 7px;

            cursor: pointer;

            font-size: 12px;
        }

        .action-button:hover {
            background: #f5eee9;
        }

        .delete-button {
            color: #a35a4a;
        }


        .empty {
            text-align: center;

            padding: 40px;

            color: #907c73;
        }

        .empty-icon {
            font-size: 40px;

            margin-bottom: 10px;
        }


        @media (max-width: 1000px) {

            .summary {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .form {
                grid-template-columns: 1fr 1fr;
            }

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

        }


        @media (max-width: 550px) {

            .summary {
                grid-template-columns: 1fr;
            }

            .form {
                grid-template-columns: 1fr;
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
            <a href="journal.php">
                📓 Journal
            </a>
        </li>

        <li>
            <a href="skills.php" class="active">
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

            <h1>My Skills 🧠</h1>

            <p>
                Track the skills you're developing during your attachment.
            </p>

        </div>


        <div class="date" id="currentDate">
            Today
        </div>

    </div>


    <div class="summary">


        <div class="summary-card">

            <h3 id="totalSkills">
                0
            </h3>

            <p>
                Total Skills
            </p>

        </div>


        <div class="summary-card">

            <h3 id="learningSkills">
                0
            </h3>

            <p>
                Currently Learning
            </p>

        </div>


        <div class="summary-card">

            <h3 id="intermediateSkills">
                0
            </h3>

            <p>
                Intermediate
            </p>

        </div>


        <div class="summary-card">

            <h3 id="averageProgress">
                0%
            </h3>

            <p>
                Average Progress
            </p>

        </div>


    </div>

    <div class="add-card">

        <h2>
            Add a New Skill
        </h2>


        <div class="form">


            <input
                type="text"
                id="skillName"
                placeholder="e.g. PHP"
            >


            <select id="skillCategory">

                <option value="Technical">
                    Technical
                </option>

                <option value="Database">
                    Database
                </option>

                <option value="Web Development">
                    Web Development
                </option>

                <option value="Tools">
                    Tools
                </option>

                <option value="Soft Skill">
                    Soft Skill
                </option>

                <option value="Other">
                    Other
                </option>

            </select>


            <select id="skillLevel">

                <option value="Beginner">
                    Beginner
                </option>

                <option value="Learning">
                    Learning
                </option>

                <option value="Intermediate">
                    Intermediate
                </option>

                <option value="Confident">
                    Confident
                </option>

            </select>


            <button
                class="add-button"
                onclick="addSkill()"
            >
                + Add Skill
            </button>


        </div>

    </div>

    <div class="skills-card">


        <div class="skills-header">

            <h2>
                My Skill Progress
            </h2>

            <span
                class="skill-count"
                id="skillCount"
            >
                0 skills
            </span>

        </div>


        <div id="skillsList">
        </div>


    </div>


</div>



<script>

   let skills = [];

async function loadSkills() {

    try {

        const response = await fetch("api/skills.php");

        const result = await response.json();

        if (!Array.isArray(result)) {

            alert(result.message || "Could not load skills.");

            return;
        }

        skills = result;

        displaySkills();

    } catch (error) {

        console.error("Error loading skills:", error);

        alert("Could not load skills from the database.");
    }
}

    const today = new Date();

    document.getElementById(
        "currentDate"
    ).textContent =
        today.toLocaleDateString(
            "en-US",
            {
                weekday: "short",
                month: "short",
                day: "numeric"
            }
        );


    function getProgress(level) {

        if (level === "Beginner") {
            return 25;
        }

        if (level === "Learning") {
            return 50;
        }

        if (level === "Intermediate") {
            return 75;
        }

        if (level === "Confident") {
            return 100;
        }

        return 0;

    }


    async function addSkill() {

    const name =
        document.getElementById("skillName").value.trim();

    const category =
        document.getElementById("skillCategory").value;

    const level =
        document.getElementById("skillLevel").value;


    if (name === "") {

        alert("Please enter a skill name.");

        return;
    }


    try {

        const response = await fetch("api/skills.php", {

            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({

                name: name,
                category: category,
                level: level

            })

        });


        const result = await response.json();


        if (result.success) {

            document.getElementById("skillName").value = "";

            await loadSkills();

        } else {

            alert(
                result.message ||
                "Failed to add skill."
            );

        }

    } catch (error) {

        console.error(
            "Error adding skill:",
            error
        );

        alert("Could not add skill.");

    }
}



    function displaySkills() {

        const list =
            document.getElementById(
                "skillsList"
            );


        list.innerHTML = "";


        if (skills.length === 0) {

            list.innerHTML = `

                <div class="empty">

                    <div class="empty-icon">
                        🧠
                    </div>

                    <p>
                        No skills added yet.
                    </p>

                    <small>
                        Add the skills you're learning during your attachment.
                    </small>

                </div>

            `;

            updateSummary();

            return;

        }


        skills.forEach(function(skill) {

            const progress =
                getProgress(skill.level);


            const skillDiv =
                document.createElement(
                    "div"
                );


            skillDiv.className = "skill";


            skillDiv.innerHTML = `

                <div class="skill-top">

                    <div>

                        <div class="skill-name">
                            ${escapeHTML(skill.name)}
                        </div>

                        <div class="skill-category">
                            ${escapeHTML(skill.category)}
                        </div>

                    </div>


                    <span class="level">
                        ${skill.level}
                    </span>

                </div>


                <div class="progress-info">

                    <span>
                        Progress
                    </span>

                    <span>
                        ${progress}%
                    </span>

                </div>


                <div class="progress-background">

                    <div
                        class="progress-bar"
                        style="width: ${progress}%"
                    ></div>

                </div>


                <div class="skill-actions">

                    <button
                        class="action-button"
                        onclick="changeLevel(${skill.id})"
                    >
                        Change Level
                    </button>

                    <button
                        class="action-button delete-button"
                        onclick="deleteSkill(${skill.id})"
                    >
                        Delete
                    </button>

                </div>

            `;


            list.appendChild(skillDiv);

        });


        updateSummary();

    }


    async function changeLevel(id) {

    const skill =
        skills.find(
            skill => Number(skill.id) === Number(id)
        );


    if (!skill) {

        return;
    }


    const levels = [
        "Beginner",
        "Learning",
        "Intermediate",
        "Confident"
    ];


    const currentIndex =
        levels.indexOf(skill.level);


    const nextIndex =
        (currentIndex + 1) % levels.length;


    const newLevel =
        levels[nextIndex];


    try {

        const response = await fetch(
            "api/skills.php",
            {

                method: "PUT",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify({

                    id: skill.id,

                    level: newLevel

                })

            }
        );


        const result =
            await response.json();


        if (result.success) {

            await loadSkills();

        } else {

            alert(
                result.message ||
                "Failed to update skill."
            );

        }

    } catch (error) {

        console.error(
            "Error updating skill:",
            error
        );

        alert(
            "Could not update skill."
        );

    }
}


   async function deleteSkill(id) {

    const confirmed =
        confirm("Delete this skill?");


    if (!confirmed) {

        return;
    }


    try {

        const response = await fetch(
            "api/skills.php",
            {

                method: "DELETE",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify({

                    id: id

                })

            }
        );


        const result =
            await response.json();


        if (result.success) {

            await loadSkills();

        } else {

            alert(
                result.message ||
                "Failed to delete skill."
            );

        }

    } catch (error) {

        console.error(
            "Error deleting skill:",
            error
        );

        alert(
            "Could not delete skill."
        );

    }

       }   


    function updateSummary() {

        const total =
            skills.length;


        const learning =
            skills.filter(
                skill =>
                    skill.level === "Learning"
            ).length;


        const intermediate =
            skills.filter(
                skill =>
                    skill.level === "Intermediate"
            ).length;


        let average = 0;


        if (total > 0) {

           const totalProgress =
    skills.reduce(
        function(sum, skill) {

            return sum +
                Number(skill.progress || 0);

        },
        0
    );


            average =
                Math.round(
                    totalProgress / total
                );

        }


        document.getElementById(
            "totalSkills"
        ).textContent = total;


        document.getElementById(
            "learningSkills"
        ).textContent = learning;


        document.getElementById(
            "intermediateSkills"
        ).textContent = intermediate;


        document.getElementById(
            "averageProgress"
        ).textContent =
            average + "%";


        document.getElementById(
            "skillCount"
        ).textContent =
            total +
            (total === 1
                ? " skill"
                : " skills");

    }

    function escapeHTML(text) {

        const div =
            document.createElement(
                "div"
            );

        div.textContent = text;

        return div.innerHTML;

    }


    loadSkills();

</script>


</body>

</html>
