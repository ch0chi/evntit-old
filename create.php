<?php
require_once 'core/init.php';
include('header.php');

?>
<div class="container eventPanelWrapper">
    <div class="row eventPanelRow">
        <a href="addEvent" class="eventLink">
            <div class="col-sm-4 test">
                <img src="images/addEvent.png" class="center-inline-block">
                <h1>Add event</h1>
            </div>
        </a>
        <a href="viewEvents" class="eventLink">
            <div class="col-sm-4 test">
                <img src="images/viewEvent.png" class="center-inline-block">
                <h1>View Events</h1>
            </div>
        </a>
        <a href="#" class="eventLink">
            <div class="col-sm-4 test">
                <img src="images/exportEvent.png" class="center-inline-block">
                <h1>Download Event</h1>
            </div>
        </a>
    </div>
</div>

<?php
include('footer.php');
?>
