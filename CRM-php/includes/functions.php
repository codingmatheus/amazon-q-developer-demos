<?php
/**
 * BlueCRM Functions File
 */

/**
 * Validate user login
 */
function validateLogin($username, $password) {
    global $db;
    
    // For demo purposes, we'll use the demo user data
    foreach ($GLOBALS['demo_users'] as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            return true;
        }
    }
    
    return false;
}

/**
 * Log user activity
 */
function logActivity($user_id, $description) {
    global $db;
    
    // For demo purposes, we'll add to the demo activities array
    $new_activity = [
        'id' => count($GLOBALS['demo_activities']) + 1,
        'user_id' => $user_id,
        'description' => $description,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    array_unshift($GLOBALS['demo_activities'], $new_activity);
    
    return true;
}

/**
 * Get recent activities
 */
function getRecentActivities($limit = 10) {
    global $db;
    
    // For demo purposes, we'll use the demo activities data
    return array_slice($GLOBALS['demo_activities'], 0, $limit);
}

/**
 * Display recent activity
 */
function displayRecentActivity($limit = 5) {
    $activities = getRecentActivities($limit);
    
    if (count($activities) > 0) {
        foreach ($activities as $activity) {
            echo '<div class="activity-item">';
            echo '<div class="activity-time">' . date('M d, H:i', strtotime($activity['timestamp'])) . '</div>';
            echo '<div class="activity-description">' . $activity['description'] . '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No recent activity</p>';
    }
}

/**
 * Get contacts
 */
function getContacts() {
    global $db;
    
    // For demo purposes, we'll use the demo contacts data
    return $GLOBALS['demo_contacts'];
}

/**
 * Get contact by ID
 */
function getContact($id) {
    global $db;
    
    // For demo purposes, we'll use the demo contacts data
    foreach ($GLOBALS['demo_contacts'] as $contact) {
        if ($contact['id'] == $id) {
            return $contact;
        }
    }
    
    return null;
}

/**
 * Get contact name
 */
function getContactName($id) {
    $contact = getContact($id);
    
    if ($contact) {
        return $contact['first_name'] . ' ' . $contact['last_name'];
    }
    
    return 'Unknown Contact';
}

/**
 * Get contact company
 */
function getContactCompany($id) {
    $contact = getContact($id);
    
    if ($contact) {
        return $contact['company'];
    }
    
    return 'Unknown Company';
}

/**
 * Add contact
 */
function addContact($contact_data) {
    global $db;
    
    // For demo purposes, we'll add to the demo contacts array
    $new_id = count($GLOBALS['demo_contacts']) + 1;
    $contact_data['id'] = $new_id;
    
    $GLOBALS['demo_contacts'][] = $contact_data;
    
    return true;
}

/**
 * Update contact
 */
function updateContact($id, $contact_data) {
    global $db;
    
    // For demo purposes, we'll update the demo contacts array
    foreach ($GLOBALS['demo_contacts'] as $key => $contact) {
        if ($contact['id'] == $id) {
            $contact_data['id'] = $id;
            $GLOBALS['demo_contacts'][$key] = $contact_data;
            return true;
        }
    }
    
    return false;
}

/**
 * Delete contact
 */
function deleteContact($id) {
    global $db;
    
    // For demo purposes, we'll remove from the demo contacts array
    foreach ($GLOBALS['demo_contacts'] as $key => $contact) {
        if ($contact['id'] == $id) {
            unset($GLOBALS['demo_contacts'][$key]);
            return true;
        }
    }
    
    return false;
}

/**
 * Count contacts
 */
function countContacts() {
    global $db;
    
    // For demo purposes, we'll count the demo contacts array
    return count($GLOBALS['demo_contacts']);
}

/**
 * Get deals
 */
function getDeals() {
    global $db;
    
    // For demo purposes, we'll use the demo deals data
    return $GLOBALS['demo_deals'];
}

/**
 * Get deal by ID
 */
function getDeal($id) {
    global $db;
    
    // For demo purposes, we'll use the demo deals data
    foreach ($GLOBALS['demo_deals'] as $deal) {
        if ($deal['id'] == $id) {
            return $deal;
        }
    }
    
    return null;
}

/**
 * Get deal title
 */
function getDealTitle($id) {
    $deal = getDeal($id);
    
    if ($deal) {
        return $deal['title'];
    }
    
    return 'Unknown Deal';
}

/**
 * Add deal
 */
function addDeal($deal_data) {
    global $db;
    
    // For demo purposes, we'll add to the demo deals array
    $new_id = count($GLOBALS['demo_deals']) + 1;
    $deal_data['id'] = $new_id;
    
    $GLOBALS['demo_deals'][] = $deal_data;
    
    return true;
}

/**
 * Update deal
 */
function updateDeal($id, $deal_data) {
    global $db;
    
    // For demo purposes, we'll update the demo deals array
    foreach ($GLOBALS['demo_deals'] as $key => $deal) {
        if ($deal['id'] == $id) {
            $deal_data['id'] = $id;
            $GLOBALS['demo_deals'][$key] = $deal_data;
            return true;
        }
    }
    
    return false;
}

/**
 * Delete deal
 */
function deleteDeal($id) {
    global $db;
    
    // For demo purposes, we'll remove from the demo deals array
    foreach ($GLOBALS['demo_deals'] as $key => $deal) {
        if ($deal['id'] == $id) {
            unset($GLOBALS['demo_deals'][$key]);
            return true;
        }
    }
    
    return false;
}

/**
 * Count deals
 */
function countDeals() {
    global $db;
    
    // For demo purposes, we'll count the demo deals array
    return count($GLOBALS['demo_deals']);
}

/**
 * Get tasks
 */
function getTasks() {
    global $db;
    
    // For demo purposes, we'll use the demo tasks data
    return $GLOBALS['demo_tasks'];
}

/**
 * Get task by ID
 */
function getTask($id) {
    global $db;
    
    // For demo purposes, we'll use the demo tasks data
    foreach ($GLOBALS['demo_tasks'] as $task) {
        if ($task['id'] == $id) {
            return $task;
        }
    }
    
    return null;
}

/**
 * Add task
 */
function addTask($task_data) {
    global $db;
    
    // For demo purposes, we'll add to the demo tasks array
    $new_id = count($GLOBALS['demo_tasks']) + 1;
    $task_data['id'] = $new_id;
    $task_data['status'] = 'pending';
    $task_data['completed_date'] = null;
    
    $GLOBALS['demo_tasks'][] = $task_data;
    
    return true;
}

/**
 * Update task
 */
function updateTask($id, $task_data) {
    global $db;
    
    // For demo purposes, we'll update the demo tasks array
    foreach ($GLOBALS['demo_tasks'] as $key => $task) {
        if ($task['id'] == $id) {
            $task_data['id'] = $id;
            $GLOBALS['demo_tasks'][$key] = $task_data;
            return true;
        }
    }
    
    return false;
}

/**
 * Complete task
 */
function completeTask($id) {
    global $db;
    
    // For demo purposes, we'll update the demo tasks array
    foreach ($GLOBALS['demo_tasks'] as $key => $task) {
        if ($task['id'] == $id) {
            $GLOBALS['demo_tasks'][$key]['status'] = 'completed';
            $GLOBALS['demo_tasks'][$key]['completed_date'] = date('Y-m-d');
            return true;
        }
    }
    
    return false;
}

/**
 * Delete task
 */
function deleteTask($id) {
    global $db;
    
    // For demo purposes, we'll remove from the demo tasks array
    foreach ($GLOBALS['demo_tasks'] as $key => $task) {
        if ($task['id'] == $id) {
            unset($GLOBALS['demo_tasks'][$key]);
            return true;
        }
    }
    
    return false;
}

/**
 * Count tasks
 */
function countTasks() {
    global $db;
    
    // For demo purposes, we'll count the pending tasks
    $count = 0;
    foreach ($GLOBALS['demo_tasks'] as $task) {
        if ($task['status'] == 'pending') {
            $count++;
        }
    }
    
    return $count;
}

/**
 * Display upcoming tasks
 */
function displayUpcomingTasks($limit = 5) {
    $tasks = getTasks();
    
    // Filter pending tasks and sort by due date
    $pending_tasks = [];
    foreach ($tasks as $task) {
        if ($task['status'] == 'pending') {
            $pending_tasks[] = $task;
        }
    }
    
    usort($pending_tasks, function($a, $b) {
        return strtotime($a['due_date']) - strtotime($b['due_date']);
    });
    
    $upcoming_tasks = array_slice($pending_tasks, 0, $limit);
    
    if (count($upcoming_tasks) > 0) {
        foreach ($upcoming_tasks as $task) {
            echo '<div class="task-item">';
            echo '<div class="task-title">' . $task['title'] . '</div>';
            echo '<div class="task-meta">';
            echo '<span class="task-date">Due: ' . date('M d', strtotime($task['due_date'])) . '</span>';
            
            if ($task['priority'] == 'high') {
                echo '<span class="task-priority high">High Priority</span>';
            } elseif ($task['priority'] == 'medium') {
                echo '<span class="task-priority medium">Medium Priority</span>';
            }
            
            echo '</div>';
            echo '<div class="task-actions">';
            echo '<a href="edit-task.php?id=' . $task['id'] . '" class="btn btn-sm btn-primary">Edit</a>';
            echo '<a href="tasks.php?action=complete&id=' . $task['id'] . '" class="btn btn-sm btn-success">Complete</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No upcoming tasks</p>';
    }
}
