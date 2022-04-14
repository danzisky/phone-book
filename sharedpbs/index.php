<?php
session_start();
include '../includes/functions.inc.php';
$response = new Respond();
$ifisset = new IfSet();

echo '<html><div class="w3-container">';
if(isset($_REQUEST['phonebook_id'])) {
    include '../header.php';

    $user_id = $_SESSION['user_id'];
    if(isset($_REQUEST['phonebook_id'])) {
        $phonebook_id = $_REQUEST['phonebook_id'];
    } else {
        $response->sendHeader('account.php', 'error', 'please get a correct link bearing an id');
    }
    //include 'includes/autoloader.inc.php';
    include '../classes/dbh.class.php';
    include '../classes/sharedcontacts.class.php';
    include '../classes/sharedcontactsviews.class.php';
    
    $checkContacks = new SharedContactsViews();
    $contacts = $checkContacks->showContactsPhonebook($phonebook_id);

    echo '<div class="w3-xxlarge w3-panel">Added Contacts</div>';

    if(empty($contacts) || is_null($contacts)) {
        echo '<div class="w3-medium w3-panel w3-center">No contacts added yet</div>';
    }

    foreach ($contacts as $contact) {
        ?>
        <form action="contact.php" method="GET"/>
            <button value="<?php echo $contact['id']; ?>" class="w3-button w3-light-grey w3-left-align">
                <div><h3><?php echo $contact['first_name']." ".$contact['last_name']; ?></h3></div>
                <div><h5><?php echo isset($contact['email']) ? "E-mail: ".$contact['email'] : ""; ?></h5></div>
                <div><h5><?php echo isset($contact['phone']) ? "Mobile Number: ".$contact['phone'] : ""; ?></h5></div>
            </button>
            <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id'] ?>" />
        </form>
        <div>
            
            <form action="" method="POST" class="w3-form"/>
                <button value="<?php echo $contact_id['id']; ?> " class="w3-button w3-green w3-left-align">SAVE</button>
                <input name='phonebook_id' hidden type="hidden" value="<?php echo $contact_id['id']; ?>" />
            </form>
        </div>
        <hr>

        <?php
    }

    ?>
    
    <br/>


    
    <?php
    echo '</div></html>';
}
else {
    $response->sendHeader('index.php', 'error', 'please make sure you have a phonebook id set in the link');
}