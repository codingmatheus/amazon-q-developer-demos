<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><?php echo APP_NAME; ?></h3>
            </div>
            
            <div class="user-info">
                <?php if (isset($_SESSION['name'])): ?>
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="user-details">
                        <p class="user-name"><?php echo $_SESSION['name']; ?></p>
                        <p class="user-role"><?php echo ucfirst($_SESSION['role']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <ul class="list-unstyled components">
                <li <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'class="active"' : ''; ?>>
                    <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li <?php echo (basename($_SERVER['PHP_SELF']) == 'contacts.php' || basename($_SERVER['PHP_SELF']) == 'add-contact.php' || basename($_SERVER['PHP_SELF']) == 'edit-contact.php' || basename($_SERVER['PHP_SELF']) == 'view-contact.php') ? 'class="active"' : ''; ?>>
                    <a href="contacts.php"><i class="fas fa-address-book"></i> Contacts</a>
                </li>
                <li <?php echo (basename($_SERVER['PHP_SELF']) == 'deals.php' || basename($_SERVER['PHP_SELF']) == 'add-deal.php' || basename($_SERVER['PHP_SELF']) == 'edit-deal.php' || basename($_SERVER['PHP_SELF']) == 'view-deal.php') ? 'class="active"' : ''; ?>>
                    <a href="deals.php"><i class="fas fa-handshake"></i> Deals</a>
                </li>
                <li <?php echo (basename($_SERVER['PHP_SELF']) == 'tasks.php' || basename($_SERVER['PHP_SELF']) == 'add-task.php' || basename($_SERVER['PHP_SELF']) == 'edit-task.php') ? 'class="active"' : ''; ?>>
                    <a href="tasks.php"><i class="fas fa-tasks"></i> Tasks</a>
                </li>
                <li <?php echo (basename($_SERVER['PHP_SELF']) == 'reports.php') ? 'class="active"' : ''; ?>>
                    <a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a>
                </li>
                <li <?php echo (basename($_SERVER['PHP_SELF']) == 'settings.php') ? 'class="active"' : ''; ?>>
                    <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                </li>
            </ul>
            
            <div class="sidebar-footer">
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </nav>
        
        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="navbar-actions">
                        <div class="search-box">
                            <input type="text" placeholder="Search...">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </div>
                        
                        <div class="notification-dropdown">
                            <button class="notification-btn">
                                <i class="fas fa-bell"></i>
                                <span class="badge">3</span>
                            </button>
                            <div class="dropdown-content">
                                <div class="dropdown-header">
                                    <h6>Notifications</h6>
                                    <a href="#">Mark all as read</a>
                                </div>
                                <div class="notification-item unread">
                                    <div class="notification-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p>New contact added: Jane Doe</p>
                                        <span class="time">2 hours ago</span>
                                    </div>
                                </div>
                                <div class="notification-item unread">
                                    <div class="notification-icon">
                                        <i class="fas fa-handshake"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p>Deal status updated: Enterprise Software License</p>
                                        <span class="time">5 hours ago</span>
                                    </div>
                                </div>
                                <div class="notification-item">
                                    <div class="notification-icon">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p>Task due tomorrow: Follow up on proposal</p>
                                        <span class="time">1 day ago</span>
                                    </div>
                                </div>
                                <div class="dropdown-footer">
                                    <a href="#">View all notifications</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="user-dropdown">
                            <button class="user-btn">
                                <i class="fas fa-user-circle"></i>
                            </button>
                            <div class="dropdown-content">
                                <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
                                <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
