<?php
// Header Component
?>
<div class="header">
    <div class="header-left">
        <h2><?php echo isset($pageTitle) ? $pageTitle : 'Dashboard'; ?></h2>
    </div>
    <div class="header-right">
        <div class="user-info">
            <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <small><?php echo htmlspecialchars($_SESSION['user_role']); ?></small>
        </div>
        <div class="user-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
    </div>
</div>
