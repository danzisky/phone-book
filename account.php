<?php
session_start();
include 'includes/functions.inc.php';
//include 'includes/accountheader.inc.php';
include 'header.php';
$response = new Respond();

echo '<html><div class="w3-padding">';
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    //include 'includes/autoloader.inc.php';
    include 'classes/dbh.class.php';
    include 'classes/phonebooks.class.php';
    include 'classes/phonebooksviews.class.php';
    
    $checkPhonebooks = new PhonebooksViews();
    $phonebooks = $checkPhonebooks->showPhonebooks($user_id);

    echo '<div class="w3-xxlarge w3-panel">Welcome '.$_SESSION['first_name'].'</div>';
    echo '<div class="w3-xxlarge w3-panel">Created Phonebooks</div>';

    if(empty($phonebooks) || is_null($phonebooks)) {
        echo '<div class="w3-medium w3-panel w3-center">No Phone Book created yet</div>';
    }

    foreach ($phonebooks as $phonebook) {
        ?>
        <form action="phonebook.php" method="GET" class="w3-form"/>
            <button value="<?php echo $phonebook['id']; ?> " class="w3-button w3-light-grey w3-left-align">
                <div><h3><?php echo $phonebook['phonebook_name']; ?></h3></div>
                <div><h5><?php echo $phonebook['phonebook_description']; ?></h5></div>
            </button>
            <input name='phonebook_id' hidden type="hidden" value="<?php echo $phonebook['id']; ?>" />
            <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id']; ?>" />
        </form>
        <div>
            <form action="edit_phonebook.php" method="POST" class="w3-form"/>
                <button name="submit" type="submit" value="<?php echo $phonebook['id']; ?> " class="w3-button w3-grey w3-left-align">EDIT</button>
                <input name='phonebook_id' hidden type="hidden" value="<?php echo $phonebook['id']; ?>" />
                <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id']; ?>" />
            </form>
            <form action="phonebooks/share_phonebook.php" method="POST" class="w3-form"/>
                <button value="<?php echo $phonebook['id']; ?> " class="w3-button w3-green w3-left-align">SHARE</button>
                <input name='phonebook_id' hidden type="hidden" value="<?php echo $phonebook['id']; ?>" />
                <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id']; ?>" />
            </form>
            <form action="phonebooks/delete_phonebook.php" method="POST" class="w3-form"/>
                <button name="delete" type="submit" value="<?php echo $phonebook['id']; ?> " class="w3-button w3-red w3-left-align">
                    DELETE
                </button>
                <input name='phonebook_id' hidden type="hidden" value="<?php echo $phonebook['id']; ?>" />
                <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id']; ?>" />
            </form>
        </div>
        <hr>

        <?php
    }

    ?>
    <div class="w3-container w3-responsive w3-row w3-centre w3-margin-bottom">
        <h3>Create a new Phone Book</h3>
        <form action="phonebooks/create_phonebook.php" method="POST">
            <div class="w3-row_ w3-responsive">
                <div class="w3-block w3-col s12 m9 l6">
                    <input name='name' class="w3-input" type="text" placeholder="Phonebook Name" />
                </div>
                <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id'] ?>" />
                <br/>
                <div class="w3-block w3-col w3-third w3-col s12 m9 l7">
                    <textarea name='description' type="text" placeholder="note" class="w3-input"></textarea>
                </div>
                <br>
                <div class="w3-col"><input class="w3-btn w3-green w3-center w3-margin-top" name="submit" type="submit" value="CREATE NEW PHONEBOOK"/></div>
            </div>
        </form>
    </div>
    <br/>
    
    <?php
    echo '</div></html>';
}
else {
    $response->sendHeader('index.php', 'error', 'please make sure you are loggen in');
}