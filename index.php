<?php
echo '<html>';
if(isset($_SESSION['id'])) {

    function fetch_contacts() {
        continue;
    }

} else {
    ?>
    <form action="account/login.php" method="POST">
        <input name='username' type="text" placeholder="username" />
        <input name='email' type="email" placeholder="email" />
        <input name='first_name' type="text" placeholder="first_name" />
        <input name='last_name' type="text" placeholder="last_name" />
        <input type="submit" value="CREATE NEW USER"/>
    </form>  
    
    <?php
}
    
echo '</html>';