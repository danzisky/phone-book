<?php
echo '<html>';
if(isset($_SESSION['id'])) {

    ?>
    <h1>Create a new Phone Book</h1>
    <form action="phonebooks/create_phonebook.php" method="POST">
        <input name='name' type="text" placeholder="username" />
        <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id'] ?>" />
        <input name='description' type="email" placeholder="email" />
        <input name="submit" type="submit" value="CREATE NEW PHONEBOOK"/>
    </form>
    <br/>
    
    <?php
}
else {
    $response->sendHeader('../index.php', 'error', 'please make sure you are loggen in');
}