<?php

include '../../../database/db_connect.php';
$notifModalResult = $conn->query("SELECT id, message, timestamp FROM notifications ORDER BY id DESC LIMIT 20");
?>

<div id="notificationModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:2000;">
    <div style="background:white; width:400px; margin:50px auto; padding:20px; border-radius:8px; position:relative;">
        <h3>All Notifications</h3>
        <ul id="modalNotificationList" style="list-style: none; padding: 0; max-height: 300px; overflow-y: auto;">
            <?php if ($notifModalResult && $notifModalResult->num_rows > 0): ?>
                <?php while($notif = $notifModalResult->fetch_assoc()): ?>
                    <li class="notif-item"
                        data-id="<?= $notif['id'] ?>"
                        data-message="<?= htmlspecialchars($notif['message'], ENT_QUOTES) ?>"
                        data-timestamp="<?= htmlspecialchars($notif['timestamp'], ENT_QUOTES) ?>"
                        style="padding:8px 12px; border-bottom:1px solid #eee; cursor:pointer;">
                        <?= htmlspecialchars($notif['message']) ?><br>
                        <small style="color:#888;"><?= date('M d, Y H:i', strtotime($notif['timestamp'])) ?></small>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li style="padding:8px 12px;">No notifications</li>
            <?php endif; ?>
        </ul>
        <button id="closeNotifModalBtn" style="margin-top: 10px;">Close</button>
    </div>
</div>

<!-- Notification Detail Modal -->
<div id="notifDetailModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:2100;">
    <div style="background:white; width:350px; margin:80px auto; padding:20px; border-radius:8px; position:relative;">
        <h3>Notification Details</h3>
        <div id="notifDetailContent"></div>
        <button id="closeNotifDetailBtn" style="margin-top: 10px;">Close</button>
    </div>
</div>