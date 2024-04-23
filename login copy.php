<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Login - Checklist 118</title>
    <link rel="stylesheet" href="resources\css\materialize.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.js"></script>

    <!-- EXTRA CSS-->
    <link rel="stylesheet" href="resources\css\generic.css">
    <link rel="stylesheet" href="resources\css\login.css">
</head>

<body>

    <div class="form-signin">
        <div class="col s12">
            <div class="row">
            <img src="assets/images/gso.png" class="width-30p" style="transform: translate(0px,-100px)">
            </div>
            <br>
            <br>
            <div class="row" style="
    margin-top: -24vh;">
                <div class=" input-field col s12">
                    <i class="icon-input gray prefix fas fa-user"></i>
                    <input id="username-text" type="text">
                    <label for="username-text">Username</label>
                </div>
                <div class="input-field col s12">
                    <i class="icon-input gray prefix fas fa-unlock-alt"></i>
                    <input id="password-text" type="password">
                    <label for="password-text">Password</label>
                </div>
            </div>

            <button class="btn waves-effect waves-light btn-outline-gray white border-radius" type="button"
                id="login-button">
                Bestätigen
            </button>
            <br>
        </div>

        <br>
        <!--
    <p>
        <a href="forgot-password.php">Password dimenticata?</a>
        <br>
        <a href="forgot-username.php">Nome Utente dimenticato?</a>
    </p>
    -->
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="resources\js\materialize.js"></script>

    <!-- FONTAWESOME -->
    <script src="https://kit.fontawesome.com/54191279d6.js" crossorigin="anonymous"></script>

    <!-- SWEETALERT 2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

    <!-- EXTRA JS-->
    <script src="resources\js\generic.js"></script>
    <script src="resources\js\login.js"></script>
</body>

</html>