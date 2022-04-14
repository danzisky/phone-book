<?php
session_start();
include 'includes/functions.inc.php';
$response = new Respond();

echo '<html>';
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    //include 'includes/autoloader.inc.php';
    include 'classes/dbh.class.php';
    include 'classes/phonebooks.class.php';
    include 'classes/phonebooksviews.class.php';
    
    $checkPhonebooks = new PhonebooksViews();
    $phonebooks = $checkPhonebooks->showPhonebooks($user_id);

    foreach ($phonebooks as $phonebook) {
        ?>

        <div><h3><?php echo $phonebook['phonebook_name']; ?></h3></div>
        <div><h5><?php echo $phonebook['phonebook_description']; ?></h5></div>
        <hr>

        <?php
    }

    ?>
    <h1>Create a new Phone Book</h1>
    <form action="phonebooks/create_phonebook.php" method="POST">
        <input name='name' type="text" placeholder="Phonebook Name" />
        <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id'] ?>" />
        <input name='description' type="text" placeholder="note" />
        <input name="submit" type="submit" value="CREATE NEW PHONEBOOK"/>
    </form>
    <br/>
    
    <?php
}
else {
    $response->sendHeader('index.php', 'error', 'please make sure you are loggen in');
}