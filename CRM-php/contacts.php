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

// Handle contact actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if ($action == 'delete' && isset($_GET['id'])) {
        deleteContact($_GET['id']);
        header("Location: contacts.php?msg=deleted");
        exit();
    }
}

// Get contacts list
$contacts = getContacts();
?>

<div class="main-content">
    <div class="container">
        <div class="page-header">
            <h1>Contacts</h1>
            <div class="page-actions">
                <a href="add-contact.php" class="btn btn-primary"><i class="fa fa-plus"></i> Add Contact</a>
            </div>
        </div>
        
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
            <div class="alert alert-success">Contact added successfully!</div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
            <div class="alert alert-success">Contact updated successfully!</div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success">Contact deleted successfully!</div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <div class="search-box">
                    <input type="text" id="contactSearch" placeholder="Search contacts...">
                </div>
                <div class="filter-box">
                    <select id="contactFilter">
                        <option value="">All Contacts</option>
                        <option value="customer">Customers</option>
                        <option value="lead">Leads</option>
                        <option value="prospect">Prospects</option>
                    </select>
                </div>
            </div>
            
            <div class="card-body">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($contacts) > 0): ?>
                            <?php foreach ($contacts as $contact): ?>
                                <tr>
                                    <td><?php echo $contact['first_name'] . ' ' . $contact['last_name']; ?></td>
                                    <td><?php echo $contact['company']; ?></td>
                                    <td><?php echo $contact['email']; ?></td>
                                    <td><?php echo $contact['phone']; ?></td>
                                    <td><span class="badge badge-<?php echo $contact['type']; ?>"><?php echo ucfirst($contact['type']); ?></span></td>
                                    <td class="actions">
                                        <a href="view-contact.php?id=<?php echo $contact['id']; ?>" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye"></i></a>
                                        <a href="edit-contact.php?id=<?php echo $contact['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a href="contacts.php?action=delete&id=<?php echo $contact['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this contact?');"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No contacts found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
