 <!-- ==================== WIDGETS CONTAINER ==================== -->
<div class="container-fluid">

    <!-- ==================== CALENDAR ROW ==================== -->
    <div class="row-fluid">

        <!-- ==================== CALENDAR CONTAINER ==================== -->
        <div class="span9">
            <!-- ==================== CALENDAR HEADLINE ==================== -->
            <div class="containerHeadline">
                <i class="icon-calendar"></i><h2>Calendar</h2>
                <div class="controlButton pull-right"><i class="icon-remove removeElement"></i></div>
                <div class="controlButton pull-right"><i class="icon-caret-down minimizeElement"></i></div>
            </div>
            <!-- ==================== END OF CALENDAR HEADLINE ==================== -->

            <!-- ==================== CALENDAR FLOATING BOX ==================== -->
            <div class="floatingBox">
                <div class="container-fluid">
                    <div id='calendar'></div>
                </div>
            </div>
            <!-- ==================== END OF CALENDAR FLOATING BOX ==================== -->
        </div>
        <!-- ==================== END OF CALENDAR CONTAINER ==================== -->

         <!-- ==================== EVENTS CONTAINER ==================== -->
        <div class="span3">
            <!-- ==================== EVENTS HEADLINE ==================== -->
            <div class="containerHeadline">
                <i class="icon-share"></i><h2>Draggable Events</h2>
                <div class="controlButton pull-right"><i class="icon-remove removeElement"></i></div>
                <div class="controlButton pull-right"><i class="icon-caret-down minimizeElement"></i></div>
            </div>
            <!-- ==================== END OF EVENTS HEADLINE ==================== -->

            <!-- ==================== EVENTS FLOATING BOX ==================== -->
            <div class="floatingBox">
                <div class="container-fluid">
                    <form id="newEventForm" class="contentForm">
                        <input type="text" class="span12" id="newEventName" placeholder="New event name...">
                        <button id="addNewEvent" class="btn btn-success" type="submit"><i class="icon-plus-sign"></i> Add Event</button>
                    </form>
                    <div id='external-events' class="external-events">
                        <div class='external-event'>
                            <input id="event1" class="css-checkbox" type="checkbox"/>
                            <label for="event1" class="css-label">My Event 1 </label>
                        </div>
                        <div class='external-event'>
                            <input id="event2" class="css-checkbox" type="checkbox"/>
                            <label for="event2" class="css-label">My Event 2 </label>
                        </div>
                        <div class='external-event'>
                            <input id="event3" class="css-checkbox" type="checkbox"/>
                            <label for="event3" class="css-label">My Event 3 </label>
                        </div>
                        <div class='external-event'>
                            <input id="event4" class="css-checkbox" type="checkbox"/>
                            <label for="event4" class="css-label">My Event 4 </label>
                        </div>
                        <div class='external-event'>
                            <input id="event5" class="css-checkbox" type="checkbox"/>
                            <label for="event5" class="css-label">My Event 5 </label>
                        </div>
                        <p>
                            <input id="drop-remove" class="css-checkbox" type="checkbox"/>
                            <label for="drop-remove" class="css-label">remove after drop </label>
                        </p>
                    </div>
                    <div>
                        <a id="deleteEvent" class="btn btn-danger disabled"><i class="icon-remove-sign"></i> Remove checked event(s)</a>
                    </div>
                </div>
            </div>
            <!-- ==================== END OF EVENTS FLOATING BOX ==================== -->
        </div>
        <!-- ==================== END OF EVENTS CONTAINER ==================== -->

    </div>
    <!-- ==================== END OF CALENDAR ROW ==================== -->

</div>
<!-- ==================== END OF WIDGETS CONTAINER ==================== -->