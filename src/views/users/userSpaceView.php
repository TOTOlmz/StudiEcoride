
<div class="center-container">

<?php 

include ROOT_PATH . 'src/Views/checks.php';


include ROOT_PATH . 'src/Views/users/components/userSpaceProfile.php';
include ROOT_PATH . 'src/Views/users/components/userSpaceCarpools.php';
include ROOT_PATH . 'src/Views/users/components/userSpaceCars.php';

if (isset($reviewForm) && $reviewForm) {
    include ROOT_PATH . 'src/Views/users/components/leaveReview.php';
}
if (isset($reportForm) && $reportForm) {
    include ROOT_PATH . 'src/Views/users/components/leaveReport.php';
}

?>

</div>

