<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>            
            <?php if(!isset($_SESSION['id'])){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage User
                    </a>            
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="signup.php">Sign-Up</a></li>
                        <li><a class="dropdown-item" href="signin.php">Sign-In</a></li>
                    </ul>            
                </li>
            <?php }else{ ?>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="logout.php" onclick='return confirm("Tem a certeza?")'>Logout</a>
                </li>   
            <?php } ?>
            
        </ul>
        <?php
            if(isset($_SESSION['id']) && $_SESSION['idType'] != 2){
        ?>
        <form class="d-flex" role="search" method='get' action='index.php'>
            <input class="form-control me-2" id='textSearch' name='textSearch' type="search" placeholder="Search" aria-label="Search" required />
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <?php } ?>
        </div>
    </div>
</nav>