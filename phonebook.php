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
    
    $checkContacks = new ContactsViews();
    $contacts = $checkPhonebooks->showPhonebooks($user_id);

    foreach ($contacts as $contact) {
        ?>
        <form action="phonebook.php" method="GET"/>
            <button value="<?php echo $contact['id']; ?>">
                <div><h3><?php echo $contact['first_name']; ?></h3></div>
                <div><h5><?php echo $contact['email']; ?></h5></div>
            </button>
            <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id'] ?>" />
        </form>
        <hr>

        <?php
    }

    ?>
    <h1>Create a new Phone Book</h1>
    <form action="contact/create_contact.php" method="POST">
        <input name='first_name' type="text" placeholder="First Name" />
        <input name='last_name' type="text" placeholder="Last Name" />
        <input name='email' type="email" placeholder="email" />
        <input name='phone' type="text" placeholder="Mobile Number" />
        <textarea name='address1' type="text" placeholder="Adress 1" ></textarea>
        <textarea name='address2' type="text" placeholder="Adress 2" ></textarea>
        <input name='state' type="text" placeholder="State" />
        <input name='city' type="text" placeholder="City" />
        <input name='phone' type="text" placeholder="Mobile Number" />
        <input name='zipcode' type="text" placeholder="Zip Code" />
        <input name='country' type="text" value="Romania" />
        <textarea name='notes' type="text" placeholder="Mobile Number"></textarea>
        <input name='contact_group' type="text" placeholder="contact_group" />
        <input name='user_id' hidden type="hidden" value="<?php echo $_SESSION['user_id'] ?>" />
        <input name="submit" type="submit" value="CREATE NEW PHONEBOOK"/>
    </form>
    <br/>
    
    <?php
}
else {
    $response->sendHeader('index.php', 'error', 'please make sure you are loggen in');
}