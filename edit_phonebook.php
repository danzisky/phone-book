<?php
session_start();
include 'includes/functions.inc.php';
//include 'includes/accountheader.inc.php';
include 'header.php';
$response = new Respond();

echo '<html><div class="w3-padding">';
if(isset($_SESSION['user_id']) && (isset($_REQUEST['phonebook_id']) || isset($_SESSION['phonebook_id']))) {
    if(isset($_REQUEST['phonebook_id'])) {
        $_SESSION['phonebook_id'] = $_REQUEST['phonebook_id'];
        $phonebook_id = $_REQUEST['phonebook_id'];
    } elseif(isset($_SESSION['phonebook_id']) && !isset($_REQUEST['phonebook_id'])) {
        $phonebook_id = $_SESSION['phonebook_id'];
    } else {
        $response->sendHeader('account.php', 'error', 'please select a phonebook');
    }
    $user_id = $_SESSION['user_id'];
    //include 'includes/autoloader.inc.php';
    include 'classes/dbh.class.php';
    include 'classes/phonebooks.class.php';
    include 'classes/phonebooksviews.class.php';
    
    $checkPhonebooks = new PhonebooksViews();
    $phonebook = $checkPhonebooks->showPhonebook($phonebook_id, $user_id);

    echo '<div class="w3-xxlarge w3-panel">Logged in as '.$_SESSION['first_name'].'</div>';
    echo '<div class="w3-xxlarge w3-panel">Edit '.$phonebook[0]['phonebook_name'].'</div>';

    if($phonebook[0]['public'] == 1 || $phonebook[0]['public'] == "1") {
        echo '<div class="w3-medium w3-panel w3-center">This phonebook can be publicly accessed</div>';
    } else {
        echo '<div class="w3-medium w3-panel w3-center">This phonebook is private</div>';
    }

    ?>
    <div class="w3-container w3-responsive w3-row w3-centre w3-margin-bottom">
        <h3>Edit Phone Book</h3>
        <form action="phonebooks/edit_phonebook.php" method="POST">
            <div class="w3-row_ w3-responsive">
                <div class="w3-block w3-col s12 m9 l6">
                    <input name='name' class="w3-input" type="text" value="<?php echo $phonebook[0]['phonebook_name']; ?>" />
                </div>
                <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id'] ?>" />
                <input name='phonebook_id' hidden type="hidden" value="<?php echo $phonebook[0]['id'] ?>" />
                <br/>
                <div class="w3-block w3-col w3-third w3-col s12 m9 l7">
                    <textarea name='description' type="text" value="<?php echo $phonebook[0]['phonebook_description']; ?>" class="w3-input"><?php echo $phonebook[0]['phonebook_description']; ?></textarea>
                </div>
                <br>
                <div class="w3-col"><input class="w3-btn w3-green w3-center w3-margin-top" name="submit" type="submit" value="SAVE CHANGES"/></div>
            </div>
        </form>
    </div>
    <br/>
    
    <?php
    echo '</div></html>';
}
else {
    $response->sendHeader('account.php', 'error', 'please make sure you are logged in and have a phonebook_id');
}