<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Background</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: #f4f7f6; /* fallback color */
            font-family: 'Nunito', sans-serif;
        }

        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            object-fit: cover;
        }

        .content {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
            padding-top: 20%;
        }
    </style>
</head>
<body>
    <video autoplay muted loop class="video-bg">
        <source src="https://raw.githubusercontent.com/ritaruthc/WasteWise/main/public/images/login/p.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="content">
        <h1>Welcome</h1>
        <p>Your content goes here</p>
    </div>
</body>
</html>
