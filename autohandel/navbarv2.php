<!-- main navbar-->
<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="user.php">
        <img src="gso.png" width="130" height="50"></img>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="user.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="stats.php">Statistics</a>
            </li>
            <li class="nav-item dropdown" id="stop_ev">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    Settings
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="Mitarbeiter.php">Mitarbeiter</a>
                    <a class="dropdown-item" href="Fahrzeuge.php">Fahrzeuge</a>
                    
                    <a class="dropdown-item" href="Kunden.php">Kunden</a>
                    
                </div>
            </li>

        </ul>
        <ul class="navbar-nav">
            <li class="nav-item" id="logout">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>