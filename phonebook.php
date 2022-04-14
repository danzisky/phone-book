<?php
session_start();
include 'includes/functions.inc.php';
$response = new Respond();
$ifisset = new IfSet();

echo '<html><div class="w3-container">';
if(isset($_SESSION['user_id'])) {
    include 'header.php';

    $user_id = $_SESSION['user_id'];
    if(isset($_REQUEST['phonebook_id'])) {
        $_SESSION['phonebook_id'] = $_REQUEST['phonebook_id'];
        $phonebook_id = $_REQUEST['phonebook_id'];
    } elseif(isset($_SESSION['phonebook_id']) && !isset($_REQUEST['phonebook_id'])) {
        $phonebook_id = $_SESSION['phonebook_id'];
    } else {
        $response->sendHeader('account.php', 'error', 'please select a phonebook');
    }
    //include 'includes/autoloader.inc.php';
    include 'classes/dbh.class.php';
    include 'classes/contacts.class.php';
    include 'classes/contactsviews.class.php';
    
    $checkContacks = new ContactsViews();
    $contacts = $checkContacks->showContactsPhonebook($user_id, $phonebook_id);

    include 'classes/phonebooks.class.php';
    include 'classes/phonebooksviews.class.php';
    
    $checkPhonebooks = new PhonebooksViews();
    $phonebook = $checkPhonebooks->showPhonebook($phonebook_id, $user_id);

    echo '<div class="w3-xxlarge w3-panel">Logged in as '.$_SESSION['first_name'].'</div>';
    echo '<div class="w3-xxlarge w3-panel">'.$phonebook[0]['phonebook_name'].': Added Contacts</div>';

    echo '<a href="account.php"><button  class="w3-medium w3-button w3-gray w3-margin-top w3-margin-bottom">BACK TO PHONEBOOKS</button></a>';
    echo '<br>';
    
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
            <form action="edit_contact.php" method="POST" class="w3-form"/>
                <button value="<?php echo $contact['id']; ?> " class="w3-button w3-grey w3-left-align">EDIT</button>
                <input name='contact_id' hidden type="hidden" value="<?php echo $contact['id']; ?>" />
                <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id']; ?>" />
            </form>
            <form action="contact/hide_contact.php" method="POST" class="w3-form"/>
                <button value="<?php echo $contact['id']; ?> " class="w3-button w3-green w3-left-align">HIDE</button>
                <input name='phonebook_id' hidden type="hidden" value="<?php echo $contact['id']; ?>" />
                <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id']; ?>" />
            </form>
            <form action="contact/delete_contact.php" method="POST" class="w3-form"/>
                <button name="delete" type="submit" value="<?php echo $contact['id']; ?>" class="w3-button w3-red w3-left-align">
                    DELETE
                </button>
                <input name='contact_id' hidden type="hidden" value="<?php echo $contact['id']; ?>" />
                <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id']; ?>" />
            </form>
        </div>
        <hr>

        <?php
    }

    ?>
    <div  class="w3-margin-top w3-padding-bottom">
        <h3>Add New Contact</h3>
        <form action="contact/create_contact.php" method="POST">
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='first_name' type="text" placeholder="First Name" />
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='last_name' type="text" placeholder="Last Name" />
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='email' type="email" placeholder="email" />
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='phone' type="text" placeholder="Mobile Number" />
            <textarea class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='address1' type="text" placeholder="Adress 1" ></textarea>
            <textarea class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='address2' type="text" placeholder="Adress 2" ></textarea>
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s6 m3 l3" name='city' type="text" placeholder="City" />
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s6 m3 l3" name='state' type="text" placeholder="State" />
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s6 m3 l3" name='zipcode' type="text" placeholder="Zip Code" />
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='country' type="text" value="Romania" />
            <textarea class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='notes' type="text" placeholder="Notes"></textarea>
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='Contact Group' type="text" placeholder="contact_group" />
            <input class="contact-info" name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id'] ?>" />
            <input class="contact-info" name='phonebook_id' hidden type="hidden" value="<?php echo $phonebook_id; ?>" />
            <br/>
            <input class="w3-input w3-center w3-margin-right w3-green contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name="submit" type="submit" value="Create Contact"/>
        </form>
    </div>
    <br/>


    
    <?php
    echo '</div></html>';
}
else {
    $response->sendHeader('index.php', 'error', 'please make sure you are logged in');
}