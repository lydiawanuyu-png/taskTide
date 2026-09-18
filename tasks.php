
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

    <title>AttachTrack | My Tasks</title>
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
            padding: 10px 15px;

            background: white;

            border-radius: 10px;

            color: #6b3828;

            font-weight: bold;
        }

        .add-task {
            background: white;

            padding: 25px;

            border-radius: 15px;

            margin-bottom: 25px;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, 0.06);
        }

        .add-task h2 {
            font-size: 20px;

            margin-bottom: 18px;
        }

        .form {
            display: flex;

            gap: 12px;
        }

        .form input {
            flex: 1;

            padding: 14px;

            border: 1px solid #ddd0ca;

            border-radius: 9px;

            outline: none;

            font-size: 15px;
        }

        .form input:focus {
            border-color: #6b3828;
        }

        .add-button {
            padding: 14px 25px;

            border: none;

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

        .stats {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 18px;

            margin-bottom: 25px;
        }

        .stat {
            background: white;

            padding: 20px;

            border-radius: 15px;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, 0.06);
        }

        .stat h3 {
            font-size: 28px;

            margin-bottom: 5px;
        }

        .stat p {
            color: #806c64;

            font-size: 14px;
        }

        .tasks-container {
            background: white;

            padding: 25px;

            border-radius: 15px;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, 0.06);
        }

        .tasks-header {
            display: flex;

            justify-content: space-between;
            align-items: center;

            margin-bottom: 20px;
        }

        .tasks-header h2 {
            font-size: 20px;
        }

        .clear-button {
            border: none;

            background: none;

            color: #9b4b3a;

            cursor: pointer;

            font-weight: bold;
        }


        .task {
            display: flex;

            align-items: center;

            gap: 15px;

            padding: 16px 5px;

            border-bottom: 1px solid #eee4df;
        }

        .task:last-child {
            border-bottom: none;
        }

        .task-checkbox {
            width: 19px;
            height: 19px;

            cursor: pointer;
        }

        .task-text {
            flex: 1;

            font-size: 15px;
        }

        .task.completed .task-text {
            text-decoration: line-through;

            color: #a4948e;
        }

        .delete-button {
            border: none;

            background: transparent;

            color: #a35a4a;

            cursor: pointer;

            font-size: 18px;
        }

        .empty {
            text-align: center;

            padding: 40px 10px;

            color: #907c73;
        }

        .empty-icon {
            font-size: 40px;

            margin-bottom: 10px;
        }

        .progress-section {
            margin-top: 25px;
        }

        .progress-top {
            display: flex;

            justify-content: space-between;

            margin-bottom: 8px;

            font-size: 14px;
        }

        .progress-background {
            width: 100%;

            height: 10px;

            background: #eaded8;

            border-radius: 20px;

            overflow: hidden;
        }

        .progress-bar {
            width: 0%;

            height: 100%;

            background: #6b3828;

            border-radius: 20px;

            transition: width 0.3s;
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

            .form {
                flex-direction: column;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;

                align-items: flex-start;

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


    <ul class="menu">

        <li>
            <a href="dashboard.php">
                🏠 Dashboard
            </a>
        </li>

        <li>
            <a href="tasks.php" class="active">
                ✓ My Tasks
            </a>
        </li>

        <li>
            <a href="journal.php">
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


    <a href="index.html" class="back-home">
        ← Back to Home
    </a>

</div>


<div class="main">


    <div class="header">

        <div>

            <h1>My Tasks ✓</h1>

            <p>
                Keep track of everything you want to accomplish today.
            </p>

        </div>


        <div class="date" id="todayDate">
            Today
        </div>

    </div>


    <div class="add-task">

        <h2>Add a New Task</h2>

        <div class="form">

            <input
                type="text"
                id="taskInput"
                placeholder="e.g. Complete today's PHP assignment"
            >

            <button
                class="add-button"
                onclick="addTask()"
            >
                + Add Task
            </button>

        </div>

    </div>


    <div class="stats">

        <div class="stat">

            <h3 id="totalTasks">
                0
            </h3>

            <p>
                Total Tasks
            </p>

        </div>


        <div class="stat">

            <h3 id="completedTasks">
                0
            </h3>

            <p>
                Completed
            </p>

        </div>


        <div class="stat">

            <h3 id="remainingTasks">
                0
            </h3>

            <p>
                Remaining
            </p>

        </div>

    </div>


    <div class="tasks-container">

        <div class="tasks-header">

            <h2>
                Today's Tasks
            </h2>

            <button
                class="clear-button"
                onclick="clearCompleted()"
            >
                Clear Completed
            </button>

        </div>


        <div id="taskList">

        
        </div>

        <div class="progress-section">

            <div class="progress-top">

                <span>
                    Today's Progress
                </span>

                <span id="progressText">
                    0%
                </span>

            </div>


            <div class="progress-background">

                <div
                    class="progress-bar"
                    id="progressBar"
                ></div>

            </div>

        </div>

    </div>

</div>



<script>


    let tasks = [];
    async function loadTasks() {

    try {

        const response = await fetch("api/tasks.php");

        tasks = await response.json();

        // Convert MySQL column names to the names
        // your current page already understands
        tasks = tasks.map(task => ({
            id: task.id,
            text: task.title,
            completed: Boolean(Number(task.completed)),
            date: task.task_date
        }));

        displayTasks();

    } catch (error) {

        console.error("Error loading tasks:", error);

        alert("Could not load tasks from the database.");

    }

}


    const today = new Date();

    document.getElementById("todayDate").textContent =
        today.toLocaleDateString(
            "en-US",
            {
                weekday: "short",
                month: "short",
                day: "numeric"
            }
        );


    function displayTasks() {

        const taskList =
            document.getElementById("taskList");

        taskList.innerHTML = "";


        if (tasks.length === 0) {

            taskList.innerHTML = `

                <div class="empty">

                    <div class="empty-icon">
                        📝
                    </div>

                    <p>
                        No tasks yet.
                    </p>

                    <small>
                        Add something you want to accomplish today.
                    </small>

                </div>

            `;

        }


        tasks.forEach(function(task, index) {

            const taskDiv =
                document.createElement("div");

            taskDiv.className =
                "task" +
                (task.completed ? " completed" : "");


            taskDiv.innerHTML = `

                <input
                    type="checkbox"
                    class="task-checkbox"
                    ${task.completed ? "checked" : ""}
                    onchange="toggleTask(${index})"
                >

                <span class="task-text">
                    ${task.text}
                </span>

                <button
                    class="delete-button"
                    onclick="deleteTask(${index})"
                >
                    🗑
                </button>

            `;


            taskList.appendChild(taskDiv);

        });


        updateStatistics();

    }


    async function addTask() {

    const input = document.getElementById("taskInput");

    const text = input.value.trim();

    if (text === "") {

        alert("Please enter a task.");

        return;

    }

    try {

        const response = await fetch("api/tasks.php", {

            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({

                title: text,

                task_date: new Date()
                    .toISOString()
                    .split("T")[0]

            })

        });

        const result = await response.json();

        if (result.success) {

            input.value = "";

            await loadTasks();

        } else {

            alert(result.message);

        }

    } catch (error) {

        console.error("Error adding task:", error);

        alert("Could not add task.");

    }

}

  async function toggleTask(index) {

    const task = tasks[index];

    const newStatus = !task.completed;

    try {

        const response = await fetch("api/tasks.php", {

            method: "PUT",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({

                id: task.id,

                completed: newStatus

            })

        });

        const result = await response.json();

        if (result.success) {

            await loadTasks();

        } else {

            alert(result.message);

        }

    } catch (error) {

        console.error("Error updating task:", error);

        alert("Could not update task.");

    }

}

    async function deleteTask(index) {

    const task = tasks[index];

    try {

        const response = await fetch("api/tasks.php", {

            method: "DELETE",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({
                id: task.id
            })

        });

        const result = await response.json();

        if (result.success) {

            await loadTasks();

        } else {

            alert(result.message);

        }

    } catch (error) {

        console.error("Error deleting task:", error);

        alert("Could not delete task.");

    }

}

    function clearCompleted() {

        tasks =
            tasks.filter(
                task => !task.completed
            );

        saveTasks();

    }

    function updateStatistics() {

        const total =
            tasks.length;

        const completed =
            tasks.filter(
                task => task.completed
            ).length;


        const remaining =
            total - completed;


        let progress = 0;


        if (total > 0) {

            progress =
                Math.round(
                    (completed / total) * 100
                );

        }


        document.getElementById(
            "totalTasks"
        ).textContent = total;


        document.getElementById(
            "completedTasks"
        ).textContent = completed;


        document.getElementById(
            "remainingTasks"
        ).textContent = remaining;


        document.getElementById(
            "progressText"
        ).textContent = progress + "%";


        document.getElementById(
            "progressBar"
        ).style.width = progress + "%";

    }

    document
        .getElementById("taskInput")
        .addEventListener(
            "keypress",
            function(event) {

                if (event.key === "Enter") {

                    addTask();

                }

            }
        );

    loadTasks();

</script>


</body>

</html>

