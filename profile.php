<?php
// profile.php
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AttachTrack - Profiles</title>

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

            padding: 25px 15px;

            color: white;
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

          .logout {
            position: absolute;
            bottom: 30px;
            left: 20px;
            right: 20px;
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

        .profile-circle {

            width: 45px;
            height: 45px;

            border-radius: 50%;

            background: #8b4f3f;

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-weight: bold;

            font-size: 18px;
        }

        .profile-card {

            max-width: 850px;

            background: white;

            border-radius: 20px;

            padding: 30px;

            box-shadow:
                0 8px 25px rgba(70, 35, 25, 0.08);

            margin: auto;
        }


        .profile-header {

            display: flex;

            align-items: center;

            gap: 20px;

            margin-bottom: 30px;

            padding-bottom: 20px;

            border-bottom: 1px solid #eadbd4;
        }


        .big-profile {

            width: 80px;
            height: 80px;

            border-radius: 50%;

            background: #6f382f;

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 30px;

            font-weight: bold;
        }


        .profile-header h2 {

            color: #4b2520;

            margin-bottom: 5px;
        }


        .profile-header p {

            color: #8b6b61;
        }

        .form-grid {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 18px;
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
        textarea {

            width: 100%;

            padding: 13px;

            border: 1px solid #dcc9bf;

            border-radius: 10px;

            background: #fffaf7;

            color: #3b2420;

            outline: none;
        }


        input:focus,
        textarea:focus {

            border-color: #8b4f3f;

            box-shadow:
                0 0 0 3px rgba(139,79,63,0.08);
        }


        textarea {

            min-height: 110px;

            resize: vertical;
        }

        .save-btn {

            margin-top: 25px;

            padding: 14px 28px;

            border: none;

            border-radius: 10px;

            background: #6f382f;

            color: white;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }


        .save-btn:hover {

            background: #4b2520;

            transform: translateY(-2px);
        }


        .message {

            display: none;

            margin-top: 20px;

            padding: 12px;

            border-radius: 9px;

            background: #dcebdc;

            color: #37643b;

            font-weight: bold;
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


            .form-grid {

                grid-template-columns: 1fr;
            }


            .form-group.full {

                grid-column: auto;
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


    <a href="achievements.php" class="nav-link">
        🏆 Achievements
    </a>


    <a href="profile.php" class="nav-link active">
        👤 Profile
    </a>

     <div class="logout">
    <a href="index.php" class="back-home"> ← Back to Home</a></div>

    <a href="logout.php" class="nav-link">
    🚪 Logout
</a>

</div>

<div class="main">

    <div class="top">

        <div>

            <h1>
                My Profile
            </h1>

            <p>
                Keep your attachment information up to date.
            </p>

        </div>


        <div class="profile-circle" id="topInitial">
            L
        </div>

    </div>

    <div class="profile-card">


        <div class="profile-header">

            <div
                class="big-profile"
                id="bigInitial"
            >
                L
            </div>


            <div>

                <h2 id="profilePreview">
                    Your Name
                </h2>

                <p>
                    Attachment Student
                </p>

            </div>

        </div>

        <form id="profileForm">


            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="fullName"
                        placeholder="Enter your name"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>
                        Attachment Organization
                    </label>

                    <input
                        type="text"
                        id="organization"
                        placeholder="e.g. ABC Technologies"
                    >

                </div>

                <div class="form-group">

                    <label>
                        Course
                    </label>

                    <input
                        type="text"
                        id="course"
                        placeholder="e.g. Diploma in Software Development"
                    >

                </div>

                <div class="form-group">

                    <label>
                        Supervisor
                    </label>

                    <input
                        type="text"
                        id="supervisor"
                        placeholder="Supervisor's name"
                    >

                </div>

                <div class="form-group">

                    <label>
                        Attachment Start Date
                    </label>

                    <input
                        type="date"
                        id="startDate"
                    >

                </div>

                <div class="form-group">

                    <label>
                        Attachment End Date
                    </label>

                    <input
                        type="date"
                        id="endDate"
                    >

                </div>


                <div class="form-group full">

                    <label>
                        About Me
                    </label>

                    <textarea
                        id="bio"
                        placeholder="Write a short description about yourself and what you hope to learn during your attachment..."
                    ></textarea>

                </div>


            </div>


            <button
                type="submit"
                class="save-btn"
            >
                💾 Save Profile
            </button>


            <div
                class="message"
                id="message"
            >
                Profile saved successfully! ✓
            </div>


        </form>

    </div>

</div>


```html
<script>

    const form =
        document.getElementById("profileForm");


    const message =
        document.getElementById("message");


    /*
    ============================================================
    UPDATE PROFILE PREVIEW
    ============================================================
    */

    function updatePreview(name) {

        if (!name) {

            name = "Your Name";

        }


        document.getElementById(
            "profilePreview"
        ).textContent = name;


        const initial =
            name.charAt(0).toUpperCase();


        document.getElementById(
            "topInitial"
        ).textContent = initial;


        document.getElementById(
            "bigInitial"
        ).textContent = initial;

    }


    /*
    ============================================================
    LOAD PROFILE FROM API
    ============================================================
    */

    async function loadProfile() {

        try {

            const response =
                await fetch(
                    "api/profile.php"
                );


            const result =
                await response.json();


            console.log(
                "GET profile response:",
                result
            );


            if (!response.ok) {

                alert(
                    result.message ||
                    "Failed to load profile."
                );

                return;
            }


            /*
            If profile exists
            */

            if (
                result.success &&
                result.data
            ) {

                const profile =
                    result.data;


                document.getElementById(
                    "fullName"
                ).value =
                    profile.name || "";


                document.getElementById(
                    "organization"
                ).value =
                    profile.organization || "";


                document.getElementById(
                    "course"
                ).value =
                    profile.course || "";


                document.getElementById(
                    "supervisor"
                ).value =
                    profile.supervisor || "";


                document.getElementById(
                    "startDate"
                ).value =
                    profile.start_date || "";


                document.getElementById(
                    "endDate"
                ).value =
                    profile.end_date || "";


                document.getElementById(
                    "bio"
                ).value =
                    profile.bio || "";


                updatePreview(
                    profile.name
                );

            }


        } catch (error) {

            console.error(
                "Error loading profile:",
                error
            );


            alert(
                "Could not connect to the profile API."
            );

        }

    }


    /*
    ============================================================
    LIVE NAME PREVIEW
    ============================================================
    */

    document
        .getElementById("fullName")
        .addEventListener(
            "input",
            function() {

                updatePreview(
                    this.value.trim()
                );

            }
        );


    /*
    ============================================================
    SAVE PROFILE
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
            Get values
            */

            const profile = {

                name:
                    document
                        .getElementById(
                            "fullName"
                        )
                        .value
                        .trim(),


                organization:
                    document
                        .getElementById(
                            "organization"
                        )
                        .value
                        .trim(),


                course:
                    document
                        .getElementById(
                            "course"
                        )
                        .value
                        .trim(),


                supervisor:
                    document
                        .getElementById(
                            "supervisor"
                        )
                        .value
                        .trim(),


                start_date:
                    document
                        .getElementById(
                            "startDate"
                        )
                        .value,


                end_date:
                    document
                        .getElementById(
                            "endDate"
                        )
                        .value,


                bio:
                    document
                        .getElementById(
                            "bio"
                        )
                        .value
                        .trim()

            };


            /*
            Check name
            */

            if (!profile.name) {

                alert(
                    "Please enter your full name."
                );

                return;

            }


            try {


                /*
                Send profile to API
                */

                const response =
                    await fetch(
                        "api/profile.php",
                        {

                            method: "POST",

                            headers: {

                                "Content-Type":
                                    "application/json"

                            },

                            body:
                                JSON.stringify(
                                    profile
                                )

                        }
                    );


                /*
                Get API response
                */

                const result =
                    await response.json();


                console.log(
                    "POST profile response:",
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
                    Update preview
                    */

                    updatePreview(
                        profile.name
                    );


                    /*
                    Show success message
                    */

                    message.textContent =
                        "Profile saved successfully! ✓";


                    message.style.display =
                        "block";


                    setTimeout(
                        function() {

                            message.style.display =
                                "none";

                        },
                        3000
                    );


                } else {

                    alert(
                        result.message ||
                        "Failed to save profile."
                    );

                }


            } catch (error) {


                console.error(
                    "Error saving profile:",
                    error
                );


                alert(
                    "Could not connect to the profile API."
                );

            }

        }
    );


    /*
    ============================================================
    START PAGE
    ============================================================
    */

    loadProfile();

</script>


</body>

</html>
