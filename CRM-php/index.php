<?php
session_start();
include 'includes/config.php';
include 'includes/functions.php';
include 'includes/header.php';

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Dashboard content
?>

<div class="main-content">
    <div class="container">
        <div class="dashboard-widgets">
            <div class="widget">
                <h3>Contacts</h3>
                <div class="widget-content">
                    <p class="stat"><?php echo countContacts(); ?></p>
                    <p>Total Contacts</p>
                </div>
                <a href="contacts.php" class="widget-link">Manage Contacts</a>
            </div>
            
            <div class="widget">
                <h3>Deals</h3>
                <div class="widget-content">
                    <p class="stat"><?php echo countDeals(); ?></p>
                    <p>Active Deals</p>
                </div>
                <a href="deals.php" class="widget-link">Manage Deals</a>
            </div>
            
            <div class="widget">
                <h3>Tasks</h3>
                <div class="widget-content">
                    <p class="stat"><?php echo countTasks(); ?></p>
                    <p>Pending Tasks</p>
                </div>
                <a href="tasks.php" class="widget-link">Manage Tasks</a>
            </div>
        </div>
        
        <div class="recent-activity">
            <h2>Recent Activity</h2>
            <div class="activity-list">
                <?php displayRecentActivity(5); ?>
            </div>
        </div>
        
        <div class="upcoming-tasks">
            <h2>Upcoming Tasks</h2>
            <div class="task-list">
                <?php displayUpcomingTasks(5); ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
