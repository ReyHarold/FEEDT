<?php
// The application now lives in /app (the rebuilt FeedTrack).
// Send everyone to the rebuilt app's sign-in page.
header('Location: app/index.php');
exit();
