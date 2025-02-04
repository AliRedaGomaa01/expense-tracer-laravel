<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker API</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        body {
            /* Nature & Trees Background Image from Unsplash */
            background: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }
        /* Overlay to improve readability */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            color: #fff;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 20px;
            text-align: center;
            padding: 3rem;
            max-width: 700px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
        }
        p {
            font-size: 1.2rem;
            text-shadow: 1px 1px 6px rgba(0,0,0,0.7);
        }
        a {
            color: #ffcc00;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div class="container">
            <h1>This is a RESTful API Laravel project for an expense tracker web & mobile application.</h1>
            <p>To test this app, you can find a Postman collection for API endpoints attached with the project repo on GitHub.</p>
            <p>You can find the project's GitHub repo using the next link: <a href="https://github.com/AliRedaGomaa01/expense-tracer-laravel" target="_blank">https://github.com/AliRedaGomaa01/expense-tracer-laravel</a></p>
            <p>The name of collection file is <strong>"laravel-expense-tracker.postman_collection.json"</strong>  </p>
        </div>
    </div>
</body>
</html>