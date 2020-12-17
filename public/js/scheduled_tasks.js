var scheduleSrc = '';
var actRowID = 0;
var actColID = 0;

var actTaskID = 0;

var taskType = -1;
var taskTypeName = '';
var taskColor = '';

var taskDuration = 0;
var taskBody = '';

var start = '07:00';
var end = '07:00';

var actPipeline;
var actPipelineName = '';

var actTeam = -1;
var actTeamName = '';

var actVehicle = -1;
var actVehicleName = '';

var taskName = '';

var actUsername = '';
var actInstallType = 0;
var actUID = 0;
var actPhone = '';
var actRow = 0;
var actLat = 0;
var actLon = 0;
var actAddress = '';

var tasksTable;
var installsTable;
var surveysTable;
var maintenanceTable;
var csTable;

var pLoader;

var threadRows = [];

var assignedStaff = Array();
var assignedVehicles = Array();

var stack_center = {"dir1": "down", "dir2": "right", "firstpos1": 250, "firstpos2": ($(window).width() / 2) - (Number(PNotify.prototype.options.width.replace(/\D/g, '')) / 2)};

PNotify.prototype.options.buttons.closer = true;
PNotify.prototype.options.buttons.sticker = false;

$(document).ready(function() {

    $('#edit_assigned_vehicles').change(function() {

        var selectID = $('#edit_assigned_vehicles').val();

        if (selectID == '-') {
            return false;
        }

        var vehicleID = 0;
        var vehicleName = '';

        // Selected an individual
        $.each(vehicles, function (i, s) {

            if (s['ID'] == selectID) {

                vehicleID = s['ID'];
                vehicleName = s['NAME'];
                return false;

            }

        });

        if (isAssigned(vehicleID, 'vehicle')) {
            popupNotify('Error!', 'Vehicle ' + vehicleName + ' already assigned to this task!', 6000, 'error', 'exclamation-triangle', true, true);
            $('#edit_assigned_vehicles').val('-');
            return;

        }
        else {

            var sid = new Array();

            sid['ID'] = vehicleID;
            sid['NAME'] = vehicleName;

            assignedVehicles.push(sid);

        }

        // Reload the table
        var vehicleRows = [];
        var assignedString = '';

        // Get JSON contents and draw the map
        $.each(assignedVehicles, function(i, ti) {

            assignedString += ti['ID'] + ',';

            vehicleRows.push({
                id: ti['ID'],
                name: ti['NAME'],
                actions: '<a href="javascript:remove_assigned_vehicle(' + ti['ID'] + ',\'edit_assigned_vehicles_table\');"><i class="fa fa-trash"></i></a>'
            });

        });

        assignedString = assignedString.substring(0, assignedString.length - 1);

        $('#EDIT_VEHICLES').val(assignedString);

        $('#edit_assigned_vehicles_table').bootstrapTable('showLoading');
        $('#edit_assigned_vehicles_table').bootstrapTable('load', vehicleRows);
        $('#edit_assigned_vehicles_table').bootstrapTable('hideLoading');

        $('#edit_assigned_vehicles').val('-');


    });

    $('#edit_assigned_staff').change(function() {

        if ($('#edit_assigned_staff').val() == '-') {
            return false;
        }

        var selectValue = $('#edit_assigned_staff').val().split('_');
        var selectType = selectValue[0];
        var selectID = selectValue[1];

        if (selectType == 't') {

            // Selected a team
            $.each(teamMembers, function (t, m) {

                if (m['TEAM_ID'] == selectID) {

                    var staffID = m['MEMBER_ID'];
                    var staffName = m['NAME'];

                    if (isAssigned(staffID, 'staff')) {

                    }
                    else {

                        var sid = new Array();

                        sid['ID'] = staffID;
                        sid['NAME'] = staffName;

                        assignedStaff.push(sid);

                    }
                }

            });

        }

        if (selectType == 'p') {

            var staffID = 0;
            var staffName = '';

            // Selected an individual
            $.each(people, function (i, s) {

                if (s['ID'] == selectID) {

                    staffID = s['ID'];
                    staffName = s['NAME'];
                    return false;

                }

            });

            if (isAssigned(staffID, 'staff')) {
                popupNotify('Error!', 'Staff member ' + staffName + ' already assigned to this task!', 6000, 'error', 'exclamation-triangle', true, true);
                $('#edit_assigned_staff').val('-');
                return;

            }
            else {

                var sid = new Array();

                sid['ID'] = staffID;
                sid['NAME'] = staffName;

                assignedStaff.push(sid);
            }

        }

        // Reload the table
        var staffRows = [];
        var assignedString = '';

        // Get JSON contents and draw the map
        $.each(assignedStaff, function(i, ti) {

            assignedString += ti['ID'] + ',';

            staffRows.push({
                id: ti['ID'],
                name: ti['NAME'],
                actions: '<a href="javascript:remove_assigned_staff(' + ti['ID'] + ',\'edit_assigned_staff_table\');"><i class="fa fa-trash"></i></a>'
            });

        });

        assignedString = assignedString.substring(0, assignedString.length - 1);

        $('#EDIT_STAFF').val(assignedString);

        $('#edit_assigned_staff_table').bootstrapTable('showLoading');
        $('#edit_assigned_staff_table').bootstrapTable('load', staffRows);
        $('#edit_assigned_staff_table').bootstrapTable('hideLoading');

        $('#edit_assigned_staff').val('-');

    });

    $('#EDIT_TASK_TYPE').change(function() {

        taskType = $("#EDIT_TASK_TYPE").val();

        $.each(taskTypes, function(key, value) {
            if (taskTypes[key]['ID'] == taskType) {
                taskDuration = taskTypes[key]['DURATION'];
                taskColor = taskTypes[key]['COLOR'];
                $('#EDIT_COLOR').val(taskColor);
            }
        });

    });

    // Edit time pickers
    $('#EDIT_START').timepicker({
        'scrollDefault': 'now',
        'timeFormat': 'H:i',
        'forceRoundTime': true,
        'step': 15
    });

    $('#EDIT_START').timepicker('setTime', '07:00');

    $('#EDIT_END').timepicker({
        'scrollDefault': 'now',
        'timeFormat': 'H:i',
        'forceRoundTime': true,
        'minTime': $('#EDIT_START').val(),
        'showDuration': true,
        'step': 15
    });

    $('#EDIT_END').timepicker('setTime', '07:00');

    $('#EDIT_START').on('changeTime', function() {

        start = $(this).val();

        // Work out based on task type what the incremental is
        end = new moment(start, 'HH:mm').add(taskDuration, 'minutes').format('HH:mm');

        $('#EDIT_END').timepicker('option', 'minTime', start);
        $('#EDIT_END').timepicker('setTime', end);

    });

    $('#EDIT_END').on('changeTime', function() {

        end = $(this).val();

    });

    $('#change_date').on('click', function(event) {
        window.location = document.location.origin + '/day_plan_select.php';
    });

    $('#btn_edit_task').on('click', function(event) {
        task_edit(actTaskID);
    });

    $('#btn_details_close').on('click', function(event) {
        $('.task_details_modal').modal('hide');
    });

    $('#btn_delete_task').on('click', function(event) {
        $('#task_details_buttons').hide();
        $('.task-delete').fadeIn('fast');
    });

    $('#btn_delete_cancel').on('click', function(event) {
        $('.task-delete').hide();
        $('#task_details_buttons').fadeIn('fast');
    });

    $('#btn_delete_confirm').on('click', function(event) {

        // Delete the task & thread items
        HoldOn.open({
            theme: 'sk-bounce',
            message: "<h4>Deleting task, please wait...</h4>"
        });

        $.ajax({
            type        : 'POST',
            url         : 'task_delete_post.php',
            data        : { taskid: actTaskID },
            dataType    : 'json',
            encode      : true
        }).done(function(data) {

            if (data['success'] == 'true') {

                // Reload the whole window...
                window.location.reload();

            }
            else {

                if (data['message'] != '') {

                }

            }

            //HoldOn.close();

        });

    });

    $('#add_task_comment').keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $('#btn_add_comment').on('click', function(event) {

        var newComment = $('#add_task_comment').val();

        if (newComment == '') {
            popupNotify('Error!', 'Please enter a comment!', 2000, 'error', 'hand-paper-o', true, true)
            return;
        }

        HoldOn.open({
            theme: 'sk-bounce',
            message: "<h4>Saving new comment...</h4>"
        });

        $.ajax({
            type        : 'POST',
            url         : 'add_comment_post.php',
            data        : { taskid: actTaskID, comment: newComment },
            dataType    : 'json',
            encode      : true
        }).done(function(data) {

            if (data['success'] == 'true') {

                var thread = JSON.parse(data['thread']);

                // Reload the table
                threadRows = [];
                threadRows.length = 0;

                // Get JSON contents and draw the map
                $.each(thread, function(i, ti) {

                    var createdTS = moment(ti['CREATED']);

                    threadRows.push({
                        date: createdTS.format('DD/MM HH:mm'),
                        type: ti['THREAD_TYPE'],
                        content: ti['CONTENT']
                    });

                });

                $('#add_task_comment').val('');

                threadRows.reverse();

                $('#task_details_table').bootstrapTable('showLoading');
                $('#task_details_table').bootstrapTable('load', threadRows);
                $('#task_details_table').bootstrapTable('hideLoading');

            }
            else {

                if (data['message'] != '') {
                    popupNotify('Error!', data['message'], 6000, 'error', 'hand-paper-o', true, true);
                }

            }

            HoldOn.close();

        });

    });

    $('#btn_save_changes').on('click', function(event) {

        actPipeline = $('#EDIT_PIPELINE').val();
        taskName = $('#EDIT_TASK_NAME').val();
        taskComments = $('#EDIT_COMMENTS').val();
        actAddress = $('#EDIT_ADDRESS').val();
        start = $('#EDIT_START').val();
        end = $('#EDIT_END').val();

        var editDay = $('#EDIT_DATE').val();
        var editMoment = moment(editDay, 'DD/MM/YYYY');
        $('#EDIT_DAY').val(editMoment.format('YYYY-MM-DD'));

        // Checks
        if (actPipeline == '-') {
            popupNotify('Error!', 'Please select a Pipeline!', 3000, 'error', 'hand-paper-o', true, true);
            return;
        }

        if (taskType == '-') {
            popupNotify('Error!', 'Please select a Task type!', 3000, 'error', 'hand-paper-o', true, true);
            return;
        }

        if (taskName == '') {
            popupNotify('Error!', 'Please enter a Task name!', 3000, 'error', 'hand-paper-o', true, true);
            return;
        }

       /* if (start == end) {
            popupNotify('Error!', 'Start and end time cannot be the same!', 3000, 'error', 'hand-paper-o', true, true);
            return;
        }
*/
        if (moment(editMoment + ' ' + end, 'YYYY-MM-DD HH:mm').isBefore(editMoment + ' ' + start, 'YYYY-MM-DD HH:mm')) {
            popupNotify('Error!', 'End time cannot be earlier than start time!', 3000, 'error', 'hand-paper-o', true, true);
            return;
        }

        if (moment(editMoment + ' ' + end, 'YYYY-MM-DD HH:mm').isBefore(new Date())) {
            popupNotify('Error!', 'Schedule date cannot be in the past!', 3000, 'error', 'hand-paper-o', true, true);
            return;
        }

        HoldOn.open({
            theme: 'sk-bounce',
            message: "<h4>Saving task changes, please wait...</h4>"
        });

        // Try to save changes
        $.ajax({
            type        : 'POST',
            url         : 'task_edit_post.php',
            data        : $('#frm_task_edit').serializeArray(),
            dataType    : 'json',
            encode      : true
        }).done(function(data) {

            if (data['success'] == 'true') {
                popupNotify('Success!', 'Task changes saved OK', 1000, 'success', 'thumbs-o-up', false, false);
                // Close window
                $('.schedule_modal').modal('hide');
                window.location.reload();
            }
            else {
                HoldOn.close();
                if (data['message'] != '') {
                    popupNotify('Error!', data['message'], 6000, 'error', 'hand-paper-o', true, true);
                }

            }

        });

    });

    $('#btn_schedule_task').on('click', function(event) {

        actPipeline = $('#PIPELINE').val();
        taskName = $('#TASK_NAME').val();
        taskComments = $('#COMMENTS').val();
        actAddress = $('#ADDRESS').val();
        start = $('#START').val();
        end = $('#END').val();

        // Checks
        if (actPipeline == '-') {
            popupNotify('Error!', 'Please select a Pipeline!', 3000, 'error', 'hand-paper-o', true, true);
            return;
        }

        if (taskType == '-') {
            popupNotify('Error!', 'Please select a Task type!', 3000, 'error', 'hand-paper-o', true, true);
            return;
        }

        if (taskName == '') {
            popupNotify('Error!', 'Please enter a Task name!', 3000, 'error', 'hand-paper-o', true, true);
            return;
        }

       /* if (start == end) {
            popupNotify('Error!', 'Start and end time cannot be the same!', 3000, 'error', 'hand-paper-o', true, true);
            return;
        }*/

        if (moment(actDay + ' ' + end, 'YYYY-MM-DD HH:mm').isBefore(actDay + ' ' + start, 'YYYY-MM-DD HH:mm')) {
            popupNotify('Error!', 'End time cannot be earlier than start time!', 3000, 'error', 'hand-paper-o', true, true);
            return;
        }

        // We have passed, convert into final values
        $.each(pipelines, function(key, value) {
            if (value.ID == actPipeline) {
                actRow = key + 1;
                actPipelineName = value.NAME;
            }
        });

        if (actTeam > -1) {
            $.each(teams, function(key, value) {
                if (value.ID == actTeam) {
                    actTeamName = value.NAME;
                }
            });
        }
        else {
            actTeamName = 'NONE';
        }

        if (actVehicle > -1) {
            $.each(vehicles, function(key, value) {
                if (value.ID == actVehicle) {
                    actVehicleName = value.NAME;
                }
            });
        }
        else {
            actVehicleName = 'NONE';
        }

        // Compose body of task hover popup
        // *********************** FIX THIS ******
        if (actInstallType == 1) {
            taskBody = '<span><b>Type:</b> MTU Install<br/>';
        }
        else {
            taskBody = '<b>Type:</b> STU Install<br/>';
        }

        taskBody += '<b>Start:</b> ' + start + '&nbsp;&nbsp;<b>End:</b> ' + end + '<br/>';
        taskBody += '<b>Address:</b> ' + actAddress + '<br/>';
        taskBody += '<b>Team / Vehicle:</b> ' + actTeamName + ' / ' + actVehicleName + '<br/>';
        taskBody += '<b>Comments:</b> ' + taskComments + '</span>';

        // Try to store in database
        $.ajax({
            type        : 'POST',
            url         : 'task_schedule_post.php?edit=0',
            data        : $('#frm_task_schedule').serializeArray(),
            dataType    : 'json',
            encode      : true
        }).done(function(data) {

            if (data['success'] == 'true') {

                // Show pending as SCHEDULED
                popupNotify('Success!', 'Task scheduled OK', 1000, 'success', 'thumbs-o-up', false, false);

                // Add the task to the timeline
                tl.timeline().timeline('addEvent', [{
                    start: actDay +  ' ' + start,
                    end: actDay + ' ' + end,
                    label: taskName,
                    content: taskComments,
                    row: actRow,
                    bgColor: taskColor,
                    color: '#fff',
                    callback: 'task_details(' + data['task_id'] + ')',
                    extend: {
                        toggle:'popover',
                        placement:'bottom',
                        content: taskBody,
                        html: true,
                        container: 'body'
                    }
                }], function( self, data ){

                    $('.timeline-node').each(function(){

                        if ( $(this).data('toggle') === 'popover' ) {
                            $(this).attr( 'title', $(this).text() );
                            $(this).popover({
                                trigger: 'hover'
                            });
                        }

                    });

                });

                // Change row to SCHEDULED
                $('#' + scheduleSrc + '_row_' + actRowID + ' td:nth-child(' + actColID + ')').html('<i title="Scheduled" class="fa fa-check-square-o green-check"></i><a href="javascript:task_details(' + data['task_id'] + ');"><i title="Task details" class="fa fa-search"></i></a>');

                // Close window
                $('.schedule_modal').modal('hide');

            }
            else {

                if (data['message'] != '') {
                    popupNotify('Error!', data['message'], 6000, 'error', 'hand-paper-o', true, true);
                }

            }

        });

    });

    tasksTable = $('#tasks_table').dataTable({
        "autoWidth": false,
        "pageLength": 10,
        columnDefs: [{
            targets: 2,
            render: function ( data, type, row ) {
                return data;
            }
        }]
    });

});

function reset_edit_window() {

    assignedVehicles.length = 0;
    assignedStaff.length = 0;

    $('#frm_task_edit')[0].reset();
    $('#frm_staff_edit')[0].reset();
    $('#frm_vehicles_edit')[0].reset();
    $('#edit_assigned_staff_table').bootstrapTable('removeAll');
    $('#edit_assigned_vehicles_table').bootstrapTable('removeAll');
    $('.nav-tabs a[href="#tab_edit_main"]').tab('show');

}

function task_details(taskID) {

    actTaskID = taskID;
    var baseURL = "http://" + window.location.host + "/";
    var url = baseURL + "task/details/" + taskID;

    // Build the body of the window with the task details, and display
   // $.getJSON('task_get.php?task_id=' + taskID, function(data) {
        $.getJSON(url, function(data) {

        var t = data.task;
        var thread = data.thread;
        var sList = data.staff;
        var vList = data.vehicles;

        var sk = Object.keys(sList);
        var vk = Object.keys(vList);

        var sListStr = '';
        var vListStr = '';

        if (sk.length > 0) {
            $.each(sList, function (i, v) {
                sListStr += v['NAME'] + ', ';
            });
        }
        else {
            sListStr = 'None, ';
        }

        if (vk.length > 0) {
            $.each(vList, function (i, v) {
                vListStr += v['NAME'] + ', ';
            });
        }
        else {
            vListStr = 'None, ';
        }

        sListStr = sListStr.substring(0, sListStr.length - 2);
        vListStr = vListStr.substring(0, vListStr.length - 2);

        var startTS = moment.unix(t['START']);
        var endTS = moment.unix(t['END']);

        threadRows = [];
        threadRows.length = 0;

        // Create the thread
        $.each(thread, function(i, ti) {

            var createdTS = moment(ti['CREATED']);

            threadRows.push({
                date: createdTS.format('DD/MM HH:mm'),
                type: ti['THREAD_TYPE'],
                content: ti['CONTENT']
            });

        });

        var contactName = 'NOT SET';
        var contactNumber = '';

        if (t['CONTACT_NAME'] != '') {
            contactName = t['CONTACT_NAME'];
        }

        if (t['CONTACT_NUMBER'] != '') {
            contactNumber = ' (' + t['CONTACT_NUMBER'] + ')';
        }

        taskBody = '<span class="task_details_list">';
        taskBody += '<p><b>Type:</b> ' + t['TASK_TYPE'] + '</p>';
        taskBody += '<p><b>Scheduled day:</b> ' + startTS.format('DD/MM/YYYY') + '&nbsp;&nbsp;';
        taskBody += '<b>From:</b> ' + startTS.format('HH:mm') + '&nbsp;&nbsp;<b>To:</b> ' + endTS.format('HH:mm') + '</p>';
        taskBody += '<p><b>Address:</b> ' + t['ADDRESS'] + '</p>';
        taskBody += '<p><b>Contact:</b> ' + contactName + contactNumber + '</p>';
        taskBody += '<p><b>Staff:</b> ' + sListStr + '</p>';
        taskBody += '<p><b>Vehicles:</b> ' + vListStr + '</p>';
        taskBody += '<p><b>Comments:</b> ' + t['COMMENTS'] + '</p>';
        taskBody += '<p><b>Status:</b> ' + t['TASK_STATUS'] + '</p>';

        if (t['COMPLETED'] == '0') {
            taskBody += '<p><b>Completed:</b> NO</p>';
        }
        else {
            taskBody += '<p><b>Completed:</b> YES</p>';
        }

        taskBody += '</span>';

        // Show modal popup
        $('#task_details_heading').html('Scheduled Task - ' + t['NAME']);

        $('#task_details_body').html(taskBody);

        $('#add_task_comments').val('');

        $('.task_details_modal').modal('show');

        $('#task_details_table').bootstrapTable('showLoading');

        threadRows.reverse();

        setTimeout(function(){
            $('#task_details_table').bootstrapTable('load', threadRows);
            $('#task_details_table').bootstrapTable('hideLoading');
        }, 500);

    });
}

function task_edit(taskID) {

    reset_edit_window();

    $('.task_details_modal').modal('hide');

    // Build the body of the window with the task details, and display
    $.getJSON('task_get.php?task_id=' + taskID, function(data) {

        var t = data.task;
        var s = data.staff;
        var v = data.vehicles;

        // Reload the table
        var staffRows = [];
        var vehicleRows = [];

        var assignedStaffString = '';
        var assignedVehiclesString = '';

        // Build staff rows
        $.each(s, function(i, ti) {

            assignedStaffString += ti['ID'] + ',';

            staffRows.push({
                id: ti['ID'],
                name: ti['NAME'],
                actions: '<a href="javascript:remove_assigned_staff(' + ti['ID'] + ',\'edit_assigned_staff_table\');"><i class="fa fa-trash"></i></a>'
            });

            var sid = new Array();

            sid['ID'] = ti['ID'];
            sid['NAME'] = ti['NAME'];

            assignedStaff.push(sid);

        });

        assignedStaffString = assignedStaffString.substring(0, assignedStaffString.length - 1);

        // Build vehicle rows
        $.each(v, function(i, ti) {

            assignedVehiclesString += ti['ID'] + ',';

            vehicleRows.push({
                id: ti['ID'],
                name: ti['NAME'],
                actions: '<a href="javascript:remove_assigned_vehicle(' + ti['ID'] + ',\'edit_assigned_vehicles_table\');"><i class="fa fa-trash"></i></a>'
            });

            var sid = new Array();

            sid['ID'] = ti['ID'];
            sid['NAME'] = ti['NAME'];

            assignedVehicles.push(sid);

        });

        assignedVehiclesString = assignedVehiclesString.substring(0, assignedVehiclesString.length - 1);

        $('#EDIT_STAFF').val(assignedStaffString);
        $('#EDIT_VEHICLES').val(assignedVehiclesString);

        $('#edit_assigned_staff_table').bootstrapTable('load', staffRows);
        $('#edit_assigned_vehicles_table').bootstrapTable('load', vehicleRows);

        var startTS = moment.unix(t['START']);
        var endTS = moment.unix(t['END']);

        $('.input-group.date').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: "linked",
            clearBtn: false,
            orientation: "bottom auto",
            autoclose: true,
            todayHighlight: true
        }).on('hide', function(e) {

            if ($('#EDIT_DATE').val() == '') {
                $('#EDIT_DATE').val(startTS.format('DD/MM/YYYY'));
            }

        }).on('changeDate', function(e) {

            $('#EDIT_DAY').val(e.format('yyyy-mm-dd'));

        });

        $('.input-group.date').datepicker('update', startTS.format('DD/MM/YYYY'));

        $('#EDIT_ID').val(taskID);
        $('#EDIT_UID').val(t['UID']);
        $('#EDIT_TASK_NAME').val(t['NAME']);
        $('#EDIT_LAT').val(t['LAT']);
        $('#EDIT_LON').val(t['LON']);
        $('#EDIT_ADDRESS').val(t['ADDRESS']);
        $('#EDIT_CONTACT_NAME').val(t['CONTACT_NAME']);
        $('#EDIT_CONTACT_NUMBER').val(t['CONTACT_NUMBER']);
        $('#EDIT_COMMENTS').val(t['COMMENTS']);
        $('#EDIT_START').val(startTS.format('HH:mm'));
        $('#EDIT_END').val(endTS.format('HH:mm'));
        $('#EDIT_DATE').val(startTS.format('DD/MM/YYYY'));
        $('#EDIT_TASK_TYPE').val(t['TYPE']).change();
        $('#EDIT_PIPELINE').val(t['PIPELINE_ID']).change();

        // Show modal popup
        $('#task_details_heading').html('Edit Task - ' + t['NAME']);
        $('.task_edit_modal').modal('show');

    });
}

function remove_assigned_staff(sid, targetTable) {

    var assignedString = '';
    var removeIndex = 0;

    // Remove from the assigned table
    $.each(assignedStaff, function (i, ti) {

        if (ti['ID'] == sid) {
            removeIndex = i;
        }
        else {
            assignedString += ti['ID'] + ',';
        }

    });

    assignedStaff.splice(removeIndex, 1);

    assignedString = assignedString.substring(0, assignedString.length - 1);

    if (targetTable == 'assigned_staff_table') {
        $('#ASSIGNED_STAFF').val(assignedString);
    }
    else {
        $('#EDIT_STAFF').val(assignedString);
    }

    $('#' + targetTable).bootstrapTable('removeByUniqueId', sid);

}

function remove_assigned_vehicle(vid, targetTable) {

    var assignedString = '';
    var removeIndex = 0;

    // Remove from the assigned table
    $.each(assignedVehicles, function (i, ti) {

        if (ti['ID'] == vid) {
            removeIndex = i;

        }
        else {
            assignedString += ti['ID'] + ',';

        }

    });

    assignedVehicles.splice(removeIndex, 1);

    assignedString = assignedString.substring(0, assignedString.length - 1);

    if (targetTable == 'assigned_vehicles_table') {
        $('#ASSIGNED_VEHICLES').val(assignedString);
    }
    else {
        $('#EDIT_VEHICLES').val(assignedString);
    }

    $('#' + targetTable).bootstrapTable('removeByUniqueId', vid);

}

function isAssigned(id, arrType) {

    var ret = false;

    if (arrType == 'staff') {
        $.each(assignedStaff, function (i, v) {
            if (v['ID'] == id) {
                ret = true;
                return false;
            }
        });
    }

    if (arrType == 'vehicle') {
        $.each(assignedVehicles, function (i, v) {
            if (v['ID'] == id) {
                ret = true;
                return false;
            }
        });
    }

    return ret;

}

function popupNotify(title, msg, delay, type, icon, centered = false, animated = false) {

    var baseIcon = 'fa ';

    if (animated) {
        baseIcon += 'fa-fw faa-flash faa-fast animated fa-';
    }
    else {
        baseIcon += 'fa-';
    }

    if (centered) {
        var popup = new PNotify({
            title: title,
            text: msg,
            type: type,
            delay: delay,
            stack: stack_center,
            icon: baseIcon + icon,
            addclass: 'pnotify-' + type
        });
    }
    else {
        var popup = new PNotify({
            title: title,
            text: msg,
            type: type,
            delay: delay,
            icon: baseIcon + icon,
            addclass: 'pnotify-' + type
        });
    }

}

$(window).resize(function(){
    stack_center.firstpos2 = ($(window).width() / 2) - (Number(PNotify.prototype.options.width.replace(/\D/g, '')) / 2);
});