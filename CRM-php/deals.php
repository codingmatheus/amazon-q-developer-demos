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

// Handle deal actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if ($action == 'delete' && isset($_GET['id'])) {
        deleteDeal($_GET['id']);
        header("Location: deals.php?msg=deleted");
        exit();
    }
}

// Get deals list
$deals = getDeals();
?>

<div class="main-content">
    <div class="container">
        <div class="page-header">
            <h1>Deals</h1>
            <div class="page-actions">
                <a href="add-deal.php" class="btn btn-primary"><i class="fa fa-plus"></i> Add Deal</a>
            </div>
        </div>
        
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
            <div class="alert alert-success">Deal added successfully!</div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
            <div class="alert alert-success">Deal updated successfully!</div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success">Deal deleted successfully!</div>
        <?php endif; ?>
        
        <div class="deal-pipeline">
            <div class="pipeline-stage">
                <h3>Lead</h3>
                <div class="deal-cards">
                    <?php foreach ($deals as $deal): ?>
                        <?php if ($deal['stage'] == 'lead'): ?>
                            <div class="deal-card">
                                <div class="deal-header">
                                    <h4><?php echo $deal['title']; ?></h4>
                                    <span class="deal-value">$<?php echo number_format($deal['value']); ?></span>
                                </div>
                                <div class="deal-body">
                                    <p><strong>Company:</strong> <?php echo getContactCompany($deal['contact_id']); ?></p>
                                    <p><strong>Contact:</strong> <?php echo getContactName($deal['contact_id']); ?></p>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 20%;">20%</div>
                                    </div>
                                </div>
                                <div class="deal-footer">
                                    <a href="view-deal.php?id=<?php echo $deal['id']; ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="edit-deal.php?id=<?php echo $deal['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="pipeline-stage">
                <h3>Qualified</h3>
                <div class="deal-cards">
                    <?php foreach ($deals as $deal): ?>
                        <?php if ($deal['stage'] == 'qualified'): ?>
                            <div class="deal-card">
                                <div class="deal-header">
                                    <h4><?php echo $deal['title']; ?></h4>
                                    <span class="deal-value">$<?php echo number_format($deal['value']); ?></span>
                                </div>
                                <div class="deal-body">
                                    <p><strong>Company:</strong> <?php echo getContactCompany($deal['contact_id']); ?></p>
                                    <p><strong>Contact:</strong> <?php echo getContactName($deal['contact_id']); ?></p>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 40%;">40%</div>
                                    </div>
                                </div>
                                <div class="deal-footer">
                                    <a href="view-deal.php?id=<?php echo $deal['id']; ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="edit-deal.php?id=<?php echo $deal['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="pipeline-stage">
                <h3>Proposal</h3>
                <div class="deal-cards">
                    <?php foreach ($deals as $deal): ?>
                        <?php if ($deal['stage'] == 'proposal'): ?>
                            <div class="deal-card">
                                <div class="deal-header">
                                    <h4><?php echo $deal['title']; ?></h4>
                                    <span class="deal-value">$<?php echo number_format($deal['value']); ?></span>
                                </div>
                                <div class="deal-body">
                                    <p><strong>Company:</strong> <?php echo getContactCompany($deal['contact_id']); ?></p>
                                    <p><strong>Contact:</strong> <?php echo getContactName($deal['contact_id']); ?></p>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 60%;">60%</div>
                                    </div>
                                </div>
                                <div class="deal-footer">
                                    <a href="view-deal.php?id=<?php echo $deal['id']; ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="edit-deal.php?id=<?php echo $deal['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="pipeline-stage">
                <h3>Negotiation</h3>
                <div class="deal-cards">
                    <?php foreach ($deals as $deal): ?>
                        <?php if ($deal['stage'] == 'negotiation'): ?>
                            <div class="deal-card">
                                <div class="deal-header">
                                    <h4><?php echo $deal['title']; ?></h4>
                                    <span class="deal-value">$<?php echo number_format($deal['value']); ?></span>
                                </div>
                                <div class="deal-body">
                                    <p><strong>Company:</strong> <?php echo getContactCompany($deal['contact_id']); ?></p>
                                    <p><strong>Contact:</strong> <?php echo getContactName($deal['contact_id']); ?></p>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 80%;">80%</div>
                                    </div>
                                </div>
                                <div class="deal-footer">
                                    <a href="view-deal.php?id=<?php echo $deal['id']; ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="edit-deal.php?id=<?php echo $deal['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="pipeline-stage">
                <h3>Closed Won</h3>
                <div class="deal-cards">
                    <?php foreach ($deals as $deal): ?>
                        <?php if ($deal['stage'] == 'closed_won'): ?>
                            <div class="deal-card deal-won">
                                <div class="deal-header">
                                    <h4><?php echo $deal['title']; ?></h4>
                                    <span class="deal-value">$<?php echo number_format($deal['value']); ?></span>
                                </div>
                                <div class="deal-body">
                                    <p><strong>Company:</strong> <?php echo getContactCompany($deal['contact_id']); ?></p>
                                    <p><strong>Contact:</strong> <?php echo getContactName($deal['contact_id']); ?></p>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 100%;">100%</div>
                                    </div>
                                </div>
                                <div class="deal-footer">
                                    <a href="view-deal.php?id=<?php echo $deal['id']; ?>" class="btn btn-sm btn-info">View</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
