<?php
// log_helper.php
include("config.php"); // Assuming config.php sets up a $pdo variable for PDO

function log_admin_action($user_id, $username, $action, $module = null, $item_id = null, $old_value = null, $new_value = null, $status = 'Success') {
    global $pdo; // This makes the $pdo variable available inside the function

    // Make sure $pdo is actually an object and not null or false before using it
    if (!($pdo instanceof PDO)) {
        error_log("Database connection error in log_admin_action: PDO object is not valid.");
        return false;
    }

    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'N/A';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'N/A';

    try {
        $stmt = $pdo->prepare("INSERT INTO admin_log (user_id, username, action, module, item_id, old_value, new_value, ip_address, user_agent, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters for PDO - no separate bind_param method like mysqli
        // PDO uses positional or named placeholders. Using positional here.
        $stmt->execute([
            $user_id,
            $username,
            $action,
            $module,
            $item_id,
            $old_value,
            $new_value,
            $ip_address,
            $user_agent,
            $status
        ]);

        return true; // If execute succeeded, return true

    } catch (PDOException $e) {
        // Handle error: execute failed
        error_log("Failed to execute log statement (PDO): " . $e->getMessage());
        return false;
    }
    // PDO doesn't typically require $stmt->close();
}
?>