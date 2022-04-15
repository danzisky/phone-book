<?php
session_start();
include 'includes/functions.inc.php';
$response = new Respond();
$ifisset = new IfSet();

echo '<html><div class="w3-container">';
if(!isset($_SESSION['user_id']) && isset($_REQUEST['user_id'])) {
    $user_id = $_REQUEST['user_id'];
} else if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if(isset($user_id)) {
    include 'header.php';

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

    if (isset($_SESSION['user_id'])) {
        echo '<div class="w3-xxlarge w3-panel">Logged in as '.$_SESSION['first_name'].'</div>';
    } else {
        echo '<div class="w3-xxlarge w3-panel">Viewing '.$_SESSION['first_name'].'\'s Phonebook</div>';
    }
    echo '<div class="w3-xxlarge w3-panel">'.$phonebook[0]['phonebook_name'].'</div>';

    echo '<div class="w3-xxlarge w3-panel">Contact Details for '.$contact[0]['first_name'].' '.$contact[0]['last_name'].'</div>';

    if (isset($_SESSION['user_id'])) {
       echo '<a href="phonebook.php"><button  class="w3-medium w3-button w3-gray w3-margin-top w3-margin-bottom">BACK TO PHONEBOOK</button></a>';
    }    
    echo '<br>';
    
    if($contact[0]['visible'] == 1 || $contact[0]['visible'] == "1") {
        echo '<div class="w3-medium w3-panel w3-text-yellow">This contact can be seen in public phonebook</div>';
    } else {
        echo '<div class="w3-medium w3-panel w3-text-green">This contact is hidded from others in phonebook</div>';
    }

    ?>
    <div  class="w3-margin-top w3-padding-bottom">
        <h3>Contact Details</h3>
        <div class="w3-container">
            <div class="w3-div w3-panel w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3">First name : <?php echo $contact[0]['first_name']; ?></div>
            <div class="w3-div w3-panel w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3">Last Name : <?php echo $contact[0]['last_name']; ?></div>
            <div class="w3-div w3-panel w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m">Email : <?php echo $contact[0]['email']; ?></div>
            <div class="w3-div w3-panel w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m" >Phone Number : <?php echo $contact[0]['phone']; ?></div>
            <div class="w3-div w3-panel w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" >Address 1: <?php echo $contact[0]['address1']; ?></div>
            <div class="w3-div w3-panel w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" >Address 2: <?php echo $contact[0]['address2']; ?></div>
            <div class="w3-div w3-panel w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s6 m4 l3" >City : <?php echo $contact[0]['city']; ?></div>
            <div class="w3-div w3-panel w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s6 m4 l3" >State : <?php echo $contact[0]['state']; ?></div>
            <div class="w3-div w3-panel w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s6 m3 l3" >Zip Code : <?php echo $contact[0]['zipcode']; ?></div>
            <div class="w3-div w3-panel w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" >Country : <?php echo $contact[0]['country']; ?></div>
            <div class="w3-div w3-panel w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3">Notes: <?php echo $contact[0]['notes']; ?></div>
            <div class="w3-div w3-panel w3-margin-right contact-info w3-col_ w3-twothird w3-responsive s12 m4 l3" >Group : <?php echo $contact[0]['contact_group']; ?></div>
        </div>
    </div>
    <br/>


    
    <?php
    echo '</div></html>';
}
else {
    $response->sendHeader('index.php', 'error', 'please make sure you are logged in');
}