<?php
include "../templates/Base.php";
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <!--    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">-->
    <!--        <span class="navbar-toggler-icon"></span>-->
    <!--    </button>-->
    <div class="collapse navbar-collapse  justify-content-center" id="navbarNavAltMarkup">
        <div class="navbar-nav ">
            <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="#">Features</a>
            <a class="nav-item nav-link" href="#">Pricing</a>

        </div>

    </div>
    <li class="nav justify-content-end">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">  <?php echo $query['f_name'] ?>   </a>
    </li>
</nav>


<?php

include "../templates/Footer.php";
?>