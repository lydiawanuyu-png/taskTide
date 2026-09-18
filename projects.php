<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AttachTrack - Projects</title>
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
            background: linear-gradient(180deg, #4b2520, #2f1815);
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

        .add-project {
            background: white;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(70, 35, 25, 0.08);
            margin-bottom: 30px;
        }

        .add-project h2 {
            margin-bottom: 20px;
            color: #4b2520;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
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
            margin-bottom: 7px;
            font-weight: bold;
            font-size: 14px;
        }

        input,
        textarea,
        select {
            border: 1px solid #dcc9bf;
            border-radius: 9px;
            padding: 12px;
            outline: none;
            background: #fffaf7;
            color: #3b2420;
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
            border: none;
            background: #6f382f;
            color: white;
            padding: 13px 25px;
            border-radius: 9px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .add-btn:hover {
            background: #4b2520;
            transform: translateY(-2px);
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: white;
            padding: 22px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(70, 35, 25, 0.07);
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

        /* PROJECTS */
        .projects-section h2 {
            margin-bottom: 20px;
            color: #4b2520;
        }

        .projects-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .project-card {
            background: white;
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 8px 25px rgba(70, 35, 25, 0.08);
            transition: 0.3s;
        }

        .project-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(70, 35, 25, 0.12);
        }

        .project-header {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .project-header h3 {
            color: #4b2520;
            font-size: 20px;
        }

        .status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
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

        .planning {
            background: #eee3dc;
            color: #70554b;
        }

        .progress {
            background: #f1dcc7;
            color: #87552d;
        }

        .completed {
            background: #dcebdc;
            color: #37643b;
        }

        .description {
            color: #705b55;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .technologies {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-bottom: 15px;
        }

        .tech {
            background: #f1e5df;
            color: #6f382f;
            padding: 6px 9px;
            border-radius: 7px;
            font-size: 12px;
        }

        .contribution {
            background: #faf5f2;
            padding: 12px;
            border-radius: 9px;
            margin-bottom: 15px;
            font-size: 14px;
            color: #5d4741;
        }

        .github {
            display: inline-block;
            color: #6f382f;
            font-weight: bold;
            text-decoration: none;
            margin-bottom: 15px;
        }

        .github:hover {
            text-decoration: underline;
        }

        .project-actions {
            display: flex;
            gap: 10px;
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
            padding: 40px;
            text-align: center;
            border-radius: 15px;
            color: #8b6b61;
            grid-column: 1 / -1;
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
            .projects-container,
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

    <a href="dashboard.php" class="nav-link">🏠 Dashboard</a>
    <a href="tasks.php" class="nav-link">✓ Tasks</a>
    <a href="journal.php" class="nav-link">📖 Journal</a>
    <a href="skills.php" class="nav-link">💡 Skills</a>
    <a href="projects.php" class="nav-link active">🚀 Projects</a>
    <a href="profile.php"class="nav-link">🏆Achievements</a>
    <a href="profile.php"class="nav-link">👤Profile</a> <br><br><br>
    
    <div class="logout"> <a href="index.php"> ← Back to Home</a></div>
        

</div>

<div class="main">

    <div class="top">
        <div>
            <h1>My Projects</h1>
            <p>Track the projects you work on during your attachment.</p>
        </div>

        <div class="profile">L</div>
    </div>

    <div class="add-project">

        <h2>＋ Add New Project</h2>

        <form id="projectForm">

            <div class="form-grid">

                <div class="form-group">
                    <label>Project Name</label>
                    <input
                        type="text"
                        id="projectName"
                        placeholder="e.g. Hostel Management System"
                        required
                    >
                </div>


                <div class="form-group">
                    <label>Status</label>

                    <select id="projectStatus">
                        <option value="Planning">Planning</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>


                <div class="form-group full">

                    <label>Description</label>

                    <textarea
                        id="projectDescription"
                        placeholder="What is this project about?"
                        required
                    ></textarea>

                </div>


                <div class="form-group">

                    <label>Technologies Used</label>

                    <input
                        type="text"
                        id="projectTech"
                        placeholder="PHP, MySQL, HTML, CSS"
                    >

                </div>


                <div class="form-group">

                    <label>GitHub Link</label>

                    <input
                        type="url"
                        id="githubLink"
                        placeholder="https://github.com/username/project"
                    >

                </div>


                <div class="form-group full">

                    <label>My Contribution</label>

                    <textarea
                        id="projectContribution"
                        placeholder="What did you personally do in this project?"
                    ></textarea>

                </div>

            </div>

            <button class="add-btn" type="submit">
                Add Project
            </button>

        </form>

    </div>

    <div class="summary">

        <div class="summary-card">
            <h3>Total Projects</h3>
            <p id="totalProjects">0</p>
        </div>

        <div class="summary-card">
            <h3>In Progress</h3>
            <p id="progressProjects">0</p>
        </div>

        <div class="summary-card">
            <h3>Completed</h3>
            <p id="completedProjects">0</p>
        </div>

    </div>

    <div class="projects-section">

        <h2>My Project Portfolio</h2>

        <div class="projects-container" id="projectsContainer">

        </div>

    </div>

</div>


<script>

    const form =
        document.getElementById("projectForm");

    const projectsContainer =
        document.getElementById("projectsContainer");


    /*
    ============================================================
    PROJECTS ARRAY
    ============================================================
    */

    let projects = [];


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
    LOAD PROJECTS FROM API
    ============================================================
    */

    async function loadProjects() {

        try {

            const response =
                await fetch("api/projects.php");


            const result =
                await response.json();


            console.log("GET response:", result);


            if (!response.ok) {

                alert(
                    result.message ||
                    "Failed to load projects."
                );

                return;
            }


            if (result.success) {

                projects =
                    result.data || [];

                displayProjects();

            } else {

                alert(
                    result.message ||
                    "Failed to load projects."
                );

            }


        } catch (error) {

            console.error(
                "Error loading projects:",
                error
            );


            alert(
                "Could not connect to the projects API."
            );

        }

    }


    /*
    ============================================================
    DISPLAY PROJECTS
    ============================================================
    */

    function displayProjects() {

        projectsContainer.innerHTML = "";


        /*
        No projects
        */

        if (projects.length === 0) {

            projectsContainer.innerHTML = `

                <div class="empty">

                    <h3>
                        No projects yet 🚀
                    </h3>

                    <p>
                        Add your first attachment project above.
                    </p>

                </div>

            `;

        }


        /*
        Display projects
        */

        else {

            projects.forEach(
                (project) => {


                    /*
                    STATUS CLASS
                    */

                    let statusClass =
                        "planning";


                    if (
                        project.status === "In Progress"
                    ) {

                        statusClass =
                            "progress";

                    }


                    if (
                        project.status === "Completed"
                    ) {

                        statusClass =
                            "completed";

                    }


                    /*
                    TECHNOLOGIES
                    */

                    let technologies =
                        project.technologies || "";


                    let technologyHTML =
                        technologies
                            .split(",")
                            .filter(
                                tech =>
                                    tech.trim() !== ""
                            )
                            .map(
                                tech => `

                                    <span class="tech">

                                        ${escapeHTML(
                                            tech.trim()
                                        )}

                                    </span>

                                `
                            )
                            .join("");


                    /*
                    PROJECT CARD
                    */

                    projectsContainer.innerHTML += `

                        <div class="project-card">


                            <div class="project-header">

                                <h3>

                                    ${escapeHTML(
                                        project.name
                                    )}

                                </h3>


                                <span
                                    class="status ${statusClass}"
                                >

                                    ${escapeHTML(
                                        project.status
                                    )}

                                </span>

                            </div>


                            <p class="description">

                                ${escapeHTML(
                                    project.description
                                )}

                            </p>


                            <div class="technologies">

                                ${technologyHTML}

                            </div>


                            ${
                                project.contribution
                                ?
                                `

                                <div class="contribution">

                                    <strong>
                                        My Contribution:
                                    </strong>

                                    <br>

                                    ${escapeHTML(
                                        project.contribution
                                    )}

                                </div>

                                `
                                :
                                ""
                            }


                            ${
                                project.github
                                ?
                                `

                                <a
                                    class="github"
                                    href="${escapeHTML(
                                        project.github
                                    )}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >

                                    View on GitHub →

                                </a>

                                `
                                :
                                ""
                            }


                            <div class="project-actions">

                                <button
                                    class="delete-btn"
                                    onclick="deleteProject(
                                        ${project.id}
                                    )"
                                >

                                    Delete

                                </button>

                            </div>


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
        TOTAL PROJECTS
        */

        document.getElementById(
            "totalProjects"
        ).textContent =
            projects.length;


        /*
        IN PROGRESS
        */

        document.getElementById(
            "progressProjects"
        ).textContent =

            projects.filter(
                project =>
                    project.status === "In Progress"
            ).length;


        /*
        COMPLETED
        */

        document.getElementById(
            "completedProjects"
        ).textContent =

            projects.filter(
                project =>
                    project.status === "Completed"
            ).length;

    }


    /*
    ============================================================
    ADD PROJECT
    ============================================================
    */

    form.addEventListener(
        "submit",
        async function(event) {


            /*
            Stop page refresh
            */

            event.preventDefault();


            /*
            Get form values
            */

            const project = {

                name:
                    document
                        .getElementById(
                            "projectName"
                        )
                        .value
                        .trim(),


                description:
                    document
                        .getElementById(
                            "projectDescription"
                        )
                        .value
                        .trim(),


                technologies:
                    document
                        .getElementById(
                            "projectTech"
                        )
                        .value
                        .trim(),


                status:
                    document
                        .getElementById(
                            "projectStatus"
                        )
                        .value,


                github:
                    document
                        .getElementById(
                            "githubLink"
                        )
                        .value
                        .trim(),


                contribution:
                    document
                        .getElementById(
                            "projectContribution"
                        )
                        .value
                        .trim()

            };


            /*
            Basic validation
            */

            if (
                !project.name ||
                !project.description
            ) {

                alert(
                    "Project name and description are required."
                );

                return;

            }


            try {


                /*
                Send project to API
                */

                const response =
                    await fetch(
                        "api/projects.php",
                        {

                            method: "POST",

                            headers: {

                                "Content-Type":
                                    "application/json"

                            },

                            body:
                                JSON.stringify(
                                    project
                                )

                        }
                    );


                /*
                Get API response
                */

                const result =
                    await response.json();


                console.log(
                    "POST response:",
                    result
                );


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
                    Reload projects
                    from MySQL
                    */

                    await loadProjects();


                    alert(
                        "Project added successfully!"
                    );


                } else {

                    alert(
                        result.message ||
                        "Failed to add project."
                    );

                }


            } catch (error) {


                console.error(
                    "Error adding project:",
                    error
                );


                alert(
                    "Could not connect to the projects API."
                );

            }

        }
    );


    /*
    ============================================================
    DELETE PROJECT
    ============================================================
    */

    async function deleteProject(id) {


        /*
        Ask for confirmation
        */

        if (
            !confirm(
                "Delete this project?"
            )
        ) {

            return;

        }


        try {


            /*
            Send DELETE request
            */

            const response =
                await fetch(
                    "api/projects.php",
                    {

                        method: "DELETE",

                        headers: {

                            "Content-Type":
                                "application/json"

                        },

                        body:
                            JSON.stringify({

                                id: id

                            })

                    }
                );


            /*
            Get API response
            */

            const result =
                await response.json();


            console.log(
                "DELETE response:",
                result
            );


            /*
            Check response
            */

            if (
                response.ok &&
                result.success
            ) {


                /*
                Reload projects
                */

                await loadProjects();


            } else {

                alert(
                    result.message ||
                    "Failed to delete project."
                );

            }


        } catch (error) {


            console.error(
                "Error deleting project:",
                error
            );


            alert(
                "Could not connect to the projects API."
            );

        }

    }


    /*
    ============================================================
    START PAGE
    ============================================================
    */

    loadProjects();

</script>



</body>
</html>