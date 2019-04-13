<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Raleway%3A400%2C500%2C600%2C700%2C300%2C100%2C800%2C900%7COpen+Sans%3A400%2C300%2C300italic%2C400italic%2C600%2C600italic%2C700%2C700italic&amp;subset=latin%2Clatin-ext&amp;ver=1.3.6"
        type="text/css" media="all">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="../style/loginPage.css">
    <title>Rejestracja</title>
    <script type="text/javascript" src="../scripts/RegistrationValidation.js"></script>
</head>
    <div class="form-register">
        <h1 class="title">Zarejestruj się</h1>
        <form id="register-form">
          <div class="form-group">
              <label for="email">Email:</label>
              <input id="email" type="email" class="form-control" id="email" required>
          </div>
          <div class="form-group">
              <label for="name">Imię:</label>
              <input type="text" class="form-control" id="name" required>
          </div>
          <div class="form-group">
              <label for="surname">Nazwisko:</label>
              <input type="surname" class="form-control" id="surname" required>
          </div>
          <div class="form-group">
              <label for="pwd">Hasło:</label>
              <input type="password" class="form-control" id="pwd" required>
          </div>
          <div class="form-group">
              <label for="cpwd">Potwierdź hasło:</label>
              <input type="password" class="form-control" id="cpwd" required>
          </div>
          <button type="submit" class="btn btn-outline-danger pinkbtn">Zarejestruj</button>
        </form>
    </div>
<body>
</body>
</html>