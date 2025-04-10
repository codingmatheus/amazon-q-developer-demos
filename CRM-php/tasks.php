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

// Handle task actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if ($action == 'complete' && isset($_GET['id'])) {
        completeTask($_GET['id']);
        header("Location: tasks.php?msg=completed");
        exit();
    } elseif ($action == 'delete' && isset($_GET['id'])) {
        deleteTask($_GET['id']);
        header("Location: tasks.php?msg=deleted");
        exit();
    }
}

// Get tasks list
$tasks = getTasks();
?>

<div class="main-content">
    <div class="container">
        <div class="page-header">
            <h1>Tasks</h1>
            <div class="page-actions">
                <a href="add-task.php" class="btn btn-primary"><i class="fa fa-plus"></i> Add Task</a>
            </div>
        </div>
        
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
            <div class="alert alert-success">Task added successfully!</div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
            <div class="alert alert-success">Task updated successfully!</div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success">Task deleted successfully!</div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'completed'): ?>
            <div class="alert alert-success">Task marked as completed!</div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#pending" data-toggle="tab">Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#completed" data-toggle="tab">Completed</a>
                    </li>
                </ul>
            </div>
            
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="pending">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Related To</th>
                                    <th>Due Date</th>
                                    <th>Priority</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $pendingTasks = array_filter($tasks, function($task) {
                                    return $task['status'] == 'pending';
                                });
                                
                                if (count($pendingTasks) > 0): 
                                ?>
                                    <?php foreach ($pendingTasks as $task): ?>
                                        <tr>
                                            <td><?php echo $task['title']; ?></td>
                                            <td>
                                                <?php if ($task['related_type'] == 'contact'): ?>
                                                    <a href="view-contact.php?id=<?php echo $task['related_id']; ?>">
                                                        <?php echo getContactName($task['related_id']); ?>
                                                    </a>
                                                <?php elseif ($task['related_type'] == 'deal'): ?>
                                                    <a href="view-deal.php?id=<?php echo $task['related_id']; ?>">
                                                        <?php echo getDealTitle($task['related_id']); ?>
                                                    </a>
                                                <?php else: ?>
                                                    N/A
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $dueDate = new DateTime($task['due_date']);
                                                $today = new DateTime();
                                                $interval = $today->diff($dueDate);
                                                
                                                if ($dueDate < $today) {
                                                    echo '<span class="text-danger">' . $task['due_date'] . ' (Overdue)</span>';
                                                } elseif ($interval->days == 0) {
                                                    echo '<span class="text-warning">' . $task['due_date'] . ' (Today)</span>';
                                                } else {
                                                    echo $task['due_date'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($task['priority'] == 'high'): ?>
                                                    <span class="badge badge-danger">High</span>
                                                <?php elseif ($task['priority'] == 'medium'): ?>
                                                    <span class="badge badge-warning">Medium</span>
                                                <?php else: ?>
                                                    <span class="badge badge-info">Low</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="actions">
                                                <a href="tasks.php?action=complete&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-success" title="Mark as Complete"><i class="fa fa-check"></i></a>
                                                <a href="edit-task.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                                <a href="tasks.php?action=delete&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this task?');"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No pending tasks found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="tab-pane" id="completed">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Related To</th>
                                    <th>Completed Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $completedTasks = array_filter($tasks, function($task) {
                                    return $task['status'] == 'completed';
                                });
                                
                                if (count($completedTasks) > 0): 
                                ?>
                                    <?php foreach ($completedTasks as $task): ?>
                                        <tr>
                                            <td><?php echo $task['title']; ?></td>
                                            <td>
                                                <?php if ($task['related_type'] == 'contact'): ?>
                                                    <a href="view-contact.php?id=<?php echo $task['related_id']; ?>">
                                                        <?php echo getContactName($task['related_id']); ?>
                                                    </a>
                                                <?php elseif ($task['related_type'] == 'deal'): ?>
                                                    <a href="view-deal.php?id=<?php echo $task['related_id']; ?>">
                                                        <?php echo getDealTitle($task['related_id']); ?>
                                                    </a>
                                                <?php else: ?>
                                                    N/A
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $task['completed_date']; ?></td>
                                            <td class="actions">
                                                <a href="tasks.php?action=delete&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this task?');"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No completed tasks found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
