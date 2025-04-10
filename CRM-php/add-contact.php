<?php
session_start();
include 'includes/config.php';
include 'includes/functions.php';
include 'includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contact = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'company' => $_POST['company'],
        'position' => $_POST['position'],
        'type' => $_POST['type'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'zip' => $_POST['zip'],
        'country' => $_POST['country'],
        'notes' => $_POST['notes']
    ];
    
    if (addContact($contact)) {
        // Log activity
        logActivity($_SESSION['user_id'], 'Added new contact: ' . $contact['first_name'] . ' ' . $contact['last_name']);
        
        // Redirect to contacts page
        header("Location: contacts.php?msg=added");
        exit();
    } else {
        $error = "Failed to add contact";
    }
}
?>

<div class="main-content">
    <div class="container">
        <div class="page-header">
            <h1>Add New Contact</h1>
            <div class="page-actions">
                <a href="contacts.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back to Contacts</a>
            </div>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <form method="post" action="add-contact.php">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name">First Name *</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Last Name *</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="company">Company</label>
                            <input type="text" class="form-control" id="company" name="company">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="position">Position</label>
                            <input type="text" class="form-control" id="position" name="position">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="type">Contact Type *</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="lead">Lead</option>
                            <option value="prospect">Prospect</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" name="state">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="zip">ZIP</label>
                            <input type="text" class="form-control" id="zip" name="zip">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save Contact</button>
                        <a href="contacts.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
