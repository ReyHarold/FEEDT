<?php
// Authentication is handled by the rebuilt app (/app). Forward any legacy
// requests to its sign-in flow.
header('Location: app/index.php');
exit();
