<?php
session_start();
include 'includes/functions.inc.php';
include 'header.php';



$response = new Respond();
$ifisset = new IfSet();
echo '<html><div class="w3-container">';
echo "<h2>Welcome to Test PhoneBook</h2>";
if(isset($_SESSION['user_id'])) {
    return header('Location: account.php?status=success&message=now logged in');
    exit();
} else {
    ?>
    <h3>Login to your Account</h3>
    <div class=" w3-row w3-center">
        <div class="w3-center w3-row">
            <form class="w3-form  w3-col s12 m9 l7" action="account/login.php" method="POST">
                <input class="w3-input w3-block w3-margin-bottom w3-margin w3-left"  name='username' type="text" placeholder="username" />
                <input class="w3-input w3-block w3-margin-bottom w3-margin w3-left"  name='email' type="email" placeholder="email" />
                <input class="w3-input w3-block w3-margin-bottom w3-margin w3-left w3-green w3-button" name="submit" type="submit" value="SIGN IN TO ACCOUNT"/>
            </form>
        </div>
    </div>  
    <br/>
    <h3>Make New User</h3>
    <div class=" w3-row w3-center">
        <div class="w3-center w3-row">
            <form class="w3-form  w3-col s12 m9 l7" action="account/signup.php" method="POST">
                <input class="w3-input w3-block w3-margin-bottom w3-margin w3-left"  name='first_name' type="text" placeholder="first_name" />
                <input class="w3-input w3-block w3-margin-bottom w3-margin w3-left"  name='last_name' type="text" placeholder="last_name" />
                <input class="w3-input w3-block w3-margin-bottom w3-margin w3-left"  name='username' type="text" placeholder="username" />
                <input class="w3-input w3-block w3-margin-bottom w3-margin w3-left"  name='email' type="email" placeholder="email" />
                <input class="w3-input w3-block w3-margin-bottom w3-margin w3-left w3-green w3-button" name="submit" type="submit" value="CREATE NEW USER"/>
            </form>
        </div>
    </div>  
    
    <?php
}
    
echo '</html></div>';