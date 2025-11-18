
<div class="center-container">

<?php 

include __DIR__ . '/../checks.php';


include __DIR__ . '/components/userSpaceProfile.php';
include __DIR__ . '/components/userSpaceCarpools.php';
include __DIR__ . '/components/userSpaceCars.php';

if (isset($reviewForm) && $reviewForm) {
    include __DIR__ . '/components/leaveReview.php';
}
if (isset($reportForm) && $reportForm) {
    include __DIR__ . '/components/leaveReport.php';
}

?>

</div>

