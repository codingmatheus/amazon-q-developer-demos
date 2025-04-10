<?php
/**
 * BlueCRM Configuration File
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'bluecrm');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application configuration
define('APP_NAME', 'BlueCRM');
define('APP_URL', 'http://localhost/bluecrm');
define('APP_VERSION', '1.0.0');

// Time zone setting
date_default_timezone_set('UTC');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

// Database connection
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // For demo purposes, we'll create a mock database connection
    // In a real application, you would handle this error appropriately
    $db = null;
}

// For demo purposes, we'll create some sample data
// In a real application, this would be stored in a database
$GLOBALS['demo_contacts'] = [
    [
        'id' => 1,
        'first_name' => 'John',
        'last_name' => 'Smith',
        'email' => 'john.smith@example.com',
        'phone' => '(555) 123-4567',
        'company' => 'Acme Inc.',
        'position' => 'CEO',
        'type' => 'customer',
        'address' => '123 Main St',
        'city' => 'New York',
        'state' => 'NY',
        'zip' => '10001',
        'country' => 'USA',
        'notes' => 'Key decision maker'
    ],
    [
        'id' => 2,
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'email' => 'jane.doe@example.com',
        'phone' => '(555) 987-6543',
        'company' => 'XYZ Corp',
        'position' => 'CTO',
        'type' => 'lead',
        'address' => '456 Oak Ave',
        'city' => 'San Francisco',
        'state' => 'CA',
        'zip' => '94107',
        'country' => 'USA',
        'notes' => 'Interested in our enterprise solution'
    ],
    [
        'id' => 3,
        'first_name' => 'Robert',
        'last_name' => 'Johnson',
        'email' => 'robert.johnson@example.com',
        'phone' => '(555) 555-5555',
        'company' => 'Global Tech',
        'position' => 'Procurement Manager',
        'type' => 'prospect',
        'address' => '789 Pine Blvd',
        'city' => 'Chicago',
        'state' => 'IL',
        'zip' => '60601',
        'country' => 'USA',
        'notes' => 'Follow up in Q3'
    ]
];

$GLOBALS['demo_deals'] = [
    [
        'id' => 1,
        'title' => 'Enterprise Software License',
        'contact_id' => 1,
        'value' => 75000,
        'stage' => 'proposal',
        'probability' => 60,
        'expected_close_date' => '2025-06-30',
        'description' => 'Annual enterprise license for 500 users'
    ],
    [
        'id' => 2,
        'title' => 'Consulting Services',
        'contact_id' => 2,
        'value' => 25000,
        'stage' => 'qualified',
        'probability' => 40,
        'expected_close_date' => '2025-05-15',
        'description' => 'Implementation and training services'
    ],
    [
        'id' => 3,
        'title' => 'Hardware Upgrade',
        'contact_id' => 3,
        'value' => 120000,
        'stage' => 'lead',
        'probability' => 20,
        'expected_close_date' => '2025-08-01',
        'description' => 'Server infrastructure upgrade'
    ],
    [
        'id' => 4,
        'title' => 'Support Contract Renewal',
        'contact_id' => 1,
        'value' => 45000,
        'stage' => 'closed_won',
        'probability' => 100,
        'expected_close_date' => '2025-04-01',
        'description' => 'Annual support contract renewal'
    ]
];

$GLOBALS['demo_tasks'] = [
    [
        'id' => 1,
        'title' => 'Follow up on proposal',
        'description' => 'Call John to discuss the proposal details',
        'related_type' => 'contact',
        'related_id' => 1,
        'due_date' => '2025-04-05',
        'priority' => 'high',
        'status' => 'pending',
        'completed_date' => null
    ],
    [
        'id' => 2,
        'title' => 'Send product information',
        'description' => 'Email Jane the product specifications',
        'related_type' => 'contact',
        'related_id' => 2,
        'due_date' => '2025-04-03',
        'priority' => 'medium',
        'status' => 'pending',
        'completed_date' => null
    ],
    [
        'id' => 3,
        'title' => 'Prepare contract',
        'description' => 'Draft the contract for the enterprise license deal',
        'related_type' => 'deal',
        'related_id' => 1,
        'due_date' => '2025-04-10',
        'priority' => 'high',
        'status' => 'pending',
        'completed_date' => null
    ],
    [
        'id' => 4,
        'title' => 'Schedule demo',
        'description' => 'Set up a product demonstration for Global Tech',
        'related_type' => 'contact',
        'related_id' => 3,
        'due_date' => '2025-03-25',
        'priority' => 'low',
        'status' => 'completed',
        'completed_date' => '2025-03-24'
    ]
];

$GLOBALS['demo_activities'] = [
    [
        'id' => 1,
        'user_id' => 1,
        'description' => 'Added new contact: John Smith',
        'timestamp' => '2025-04-01 09:30:00'
    ],
    [
        'id' => 2,
        'user_id' => 1,
        'description' => 'Created new deal: Enterprise Software License',
        'timestamp' => '2025-04-01 10:15:00'
    ],
    [
        'id' => 3,
        'user_id' => 1,
        'description' => 'Completed task: Schedule demo',
        'timestamp' => '2025-03-24 14:45:00'
    ],
    [
        'id' => 4,
        'user_id' => 1,
        'description' => 'Added new contact: Jane Doe',
        'timestamp' => '2025-03-30 11:20:00'
    ],
    [
        'id' => 5,
        'user_id' => 1,
        'description' => 'Updated deal: Support Contract Renewal - Marked as won',
        'timestamp' => '2025-04-01 16:30:00'
    ]
];

// Demo user for login
$GLOBALS['demo_users'] = [
    [
        'id' => 1,
        'username' => 'admin',
        'password' => password_hash('password', PASSWORD_DEFAULT),
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'role' => 'admin'
    ]
];
