<?php
session_start();
include 'includes/functions.inc.php';
$response = new Respond();
$ifisset = new IfSet();

echo '<html><div class="w3-container">';
if(isset($_SESSION['user_id'])) {
    include 'header.php';

    $user_id = $_SESSION['user_id'];
    if(isset($_REQUEST['contact_id'])) {
        $_SESSION['contact_id'] = $_REQUEST['contact_id'];
        $contact_id = $_REQUEST['contact_id'];
    } elseif(isset($_SESSION['contact_id']) && !isset($_REQUEST['contact_id'])) {
        $contact_id = $_SESSION['contact_id'];
    } else {
        $response->sendHeader('account.php', 'error', 'please select a contact');
    }
    //include 'includes/autoloader.inc.php';
    include 'classes/dbh.class.php';
    include 'classes/contacts.class.php';
    include 'classes/contactsviews.class.php';
    
    $checkContacks = new ContactsViews();
    $contact = $checkContacks->showContact($contact_id, $user_id);

    include 'classes/phonebooks.class.php';
    include 'classes/phonebooksviews.class.php';
    $phonebook_id = $contact[0]['phonebook_id'];
    $checkPhonebooks = new PhonebooksViews();
    $phonebook = $checkPhonebooks->showPhonebook($phonebook_id, $user_id);

    echo '<div class="w3-xxlarge w3-panel">Logged in as '.$_SESSION['first_name'].'</div>';
    echo '<div class="w3-xxlarge w3-panel">'.$phonebook[0]['phonebook_name'].': Edit '.$contact[0]['first_name'].' '.$contact[0]['last_name'].'\'s contact</div>';

    echo '<a href="account.php"><button  class="w3-medium w3-button w3-gray w3-margin-top w3-margin-bottom">BACK TO PHONEBOOKS</button></a>';
    echo '<br>';
    
    if($contact[0]['address2'] == 1 || $contact[0]['address2'] == "1") {
        echo '<div class="w3-medium w3-panel w3-center">This contact can be seen in public phonebook</div>';
    } else {
        echo '<div class="w3-medium w3-panel w3-center">This contact is hidded from others in phonebook</div>';
    }

    ?>
    <div  class="w3-margin-top w3-padding-bottom">
        <h3>Add New Contact</h3>
        <form action="contact/edit_contact.php" method="POST">
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='first_name' type="text" placeholder = "First name" value="<?php echo $contact[0]['first_name']; ?>" />
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='last_name' type="text" placeholder = "Last Name" value="<?php echo $contact[0]['last_name']; ?>" />
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='email' type="email" placeholder = "Email" value="<?php echo $contact[0]['email']; ?>" />
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='phone' type="text" placeholder = "Phone Number" value="<?php echo $contact[0]['phone']; ?>" />
            <textarea class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='address1' type="text" placeholder = "Address 1" value="<?php echo $contact[0]['address1']; ?>" ><?php echo $contact[0]['address1']; ?></textarea>
            <textarea class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='address2' type="text" placeholder = "Address 2" value="<?php echo $contact[0]['address2']; ?>" ><?php echo $contact[0]['address2']; ?></textarea>
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s6 m3 l3" name='city' type="text" placeholder = "City" value="<?php echo $contact[0]['city']; ?>" />
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s6 m3 l3" name='state' type="text" placeholder = "State" value="<?php echo $contact[0]['state']; ?>" />
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s6 m3 l3" name='zipcode' type="text" placeholder = "Zip Code" value="<?php echo $contact[0]['zipcode']; ?>" />
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='country' type="text" placeholder = "Country" value="<?php echo $contact[0]['country']; ?>" />
            <textarea class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='notes' type="text" placeholder = "Notes" value="<?php echo $contact[0]['notes']; ?>"><?php echo $contact[0]['notes']; ?></textarea>
            <input class="w3-input w3-block w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name='Contact Group' type="text" placeholder = "Group" value="<?php echo $contact[0]['contact_group']; ?>" />
            <input class="contact-info" name='user_id' hidden type="hidden" placeholder = "" value="<?php echo $_SESSION['user_id'] ?>" />
            <input class="contact-info" name='contact_id' hidden type="hidden" placeholder = "" value="<?php echo $contact[0]['id']; ?>" />
            <br/>
            <input class="w3-input w3-center w3-margin-right w3-green contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" name="submit" type="submit" placeholder = "" value="Edit Contact"/>
        </form>
    </div>
    <br/>


    
    <?php
    echo '</div></html>';
}
else {
    $response->sendHeader('index.php', 'error', 'please make sure you are logged in');
}