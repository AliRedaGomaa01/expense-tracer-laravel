<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Expense Tracker Web & Mobile App</title>
  <style>
    body {
      background: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
      background-size: cover;
      min-width: 100vw;
      max-width: 100vw;
      min-height: 100vh;
      margin: 0;
      font-family: 'Arial', sans-serif;
      position: relative;
      z-index: 00;
      display: flex;
      justify-items: center;
      align-items: center;
    }

    /* Overlay to improve readability */
    .overlay {
      position: absolute;
      z-index: 10;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background: rgba(0, 0, 0, 0.3);
    }

    .wrapper {
      min-width: 200px;
      max-width: 700px;
      padding: 1rem;
      margin: 0 auto;
      position: relative;
      z-index: 20;
    }

    .container {
      position: relative;
      z-index: 20;
      max-width: 100%;
      margin: 0 auto;
      padding: 2rem;
      color: #fff;
      background: rgba(0, 0, 0, 0.8);
      border-radius: 1rem;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 20px
    }

    h1 {
      font-size: 2rem;
      margin-bottom: 20px;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
    }

    p {
      font-size: 1.2rem;
      text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.7);
    }

    ol {
      width: 100%;
      text-align: justify;
      line-height: 2rem;
      padding: 1rem;
      margin:0
    }

    a {
      color: #ffcc00;
      text-decoration: none;
      font-weight: bold;
      text-wrap: balance
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="overlay"></div>
  <div class="wrapper">
    <div class="container">
      <h2>
        This is a ( Laravel - React - Flutter ) project for an expense tracker web & mobile application.
      </h2>
      <ol>
        <li>
          <p>
            To test the RESTful backend app
          </p>
          <ul>
            <li>
              you can find a Postman collection for API endpoints attached with the
              project repo on GitHub.
            </li>
            <li>You can find the project's GitHub repo using the next link: <a
                href="https://github.com/AliRedaGomaa01/expense-tracer-laravel"
                target="_blank">laravel repo on github </a>
            </li>
            <li>
              The name of collection file is <strong>"laravel-expense-tracker.postman _collection.json"</strong> 
            </li>
          </ul>
        </li>
        <hr>
        <li>
          <p>
            To test the frontend react web app please visit this link: 
          </p>
          <ul>
            <li>
              <a href="https://react-expense-tracker.aly-h.com">react website</a>
            </li>
          </ul>
        </li>
        <hr>
        <li>
          <p>
            To see the flutter mobile app please follow the next step : 
          </p>
          <ul>
            <li>Download the zipped app.apk from this link on google drive : <a
                href="https://drive.google.com/drive/u/0/folders/1G4_Sbm-tqvm6C6BfWWsZQBZOz5MtUpBf">
                APK on Google Drive
              </a>
            </li>
            <li> Extract the zipped file on your mobile</li>
            <li> Install the app using the app.apk file </li>
          </ul>
          </p>
        </li>
      </ol>
    </div>
  </div>
</body>

</html>