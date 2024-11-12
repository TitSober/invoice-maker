<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Invoice Creator</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL . "create"?>">Create</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL . "anon"?>">Create manually</a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL . "create-company"?>" class="nav-link">Create company</a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL . "create-footer"?>" class="nav-link">Create footer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL . "logout"?>">Logout</a>
               </li>
               <li class="nav-item">
               <a id="audio" class="nav-link" id="play"><?=$_SESSION["username"]?><audio id="yippieAudio" src="<?=ASSETS_URL."yippie.mp3"?>"></audio></a>
               </li>
            </ul>
        </div>
    </nav>