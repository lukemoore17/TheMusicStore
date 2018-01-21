
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="./index.php">The Music Store</a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li id="navShop" class="nav-item">
                <a class="nav-link" href="./shop.php">Shop <span class="sr-only">(current)</span></a>
            </li>
            <li id="navContact" class="nav-item">
                <a class="nav-link" href="./contact.php">Contact Us</a>
            </li>
        </ul>
        <!-- Login button trigger modal -->
        <!--<a class="btn" href="#" data-toggle="modal" data-target="#LoginModal">Log In</a>-->
        <?php
            if ($logged_in === true) 
            {
        ?>
            <a class="btn" href="./account.php">My Account</a>
            <a class="btn" href="./code/logout.php">Log Out</a>
        <?php 
            } // End IF
            else
            {
        ?>
            <a class="btn" href="./login.php">Log In</a>
        <?php
            } // End ELSE
        ?>
        <a class="btn btn-outline-primary" href="./cart.php">View Cart <span class="fa fa-shopping-cart" aria-hidden="true"></span></a>
    </div>
</nav>
