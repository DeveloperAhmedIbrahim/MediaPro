@extends('user.layouts.app')
@section('content')
    <style>
        *{
            border-radius: 0px !important;
        }
        .drop {
            width: 100%;
            height: 100%;
            background-color: #E8E8E8;
        }
        .schedulerContainer::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .schedulerContainer::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px #E8E8E8;
            background-color: #E8E8E8;
            border-radius: 0;
        }

        .schedulerContainer::-webkit-scrollbar-thumb {
            border-radius: 0px;
            background:  #FD6E6A;
        }
        .loader{
            width: 100%;
            height: 100%;
            background-color: rgba(217,193,255,0.5);
            position: absolute;
            z-index: 1;
        }
        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #dee2e6;
            background-color: #f1f1f1;
            justify-content: center;
            align-items: center;
            display: flex;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 8px 16px;
            transition: 0.3s;
            font-size: 15px;
            color: lightslategray;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #dee2e6;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #dee2e6;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
        }

        .specificVideo{
            cursor: all-scroll;
            position:relative;
        }

        .specificVideo a{
            position:absolute;
            top:0;
            rigth:0;
            cursor: pointer;
            font-weight: bolder;
            color: #FD3F35 !important;
            padding-left: 4px;
        }

        .specificVideo a:hover{
            color: #CA4E5D !important;
        }

        .specificVideoTime{
            position: absolute !important;
            left: 0;
            background: rgba(0,0,0,0.5);
            color: white;
            padding: 0px 5px;
            font-size: 12px;
        }

        table tbody tr td{
            width: 100px !important;
            height: 100px !important;
            padding-bottom:50px !important;
        }

        label
        {
            color: lightslategray;
        }

        .modal .modal-body .start
        {
            text-align: center;
            background: #ED5A6E;
            padding: 5px 0px;
            color: white;
        }

        .modal .modal-body .end
        {
            text-align: center;
            background: #ED5A6E;
            padding: 5px 0px;
            color: white;
        }

        .disabledSelect{
            pointer-events: none;
            background-color: lightgray;
            -webkit-appearance: none;
        }

    </style>
    <div class="content container-fluid">
        <div class="page-header mt-5">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title" style="color: #fc6075;">{{ $data->name }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Schedule Videos</li>
                    </ul>
                    <div style="color: gray; float: right;">Timezone: {{ $data->timeZone }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    @if ($data->scheduledDuration == 0)
                    <div class="tab">
                        <button class="tablinks" id="tabMonday" onclick="openTab(event, 'Monday')">Monday</button>
                        <button class="tablinks" id="tabTuesday" onclick="openTab(event, 'Tuesday')">Tuesday</button>
                        <button class="tablinks" id="tabWednesday" onclick="openTab(event, 'Wednesday')">Wednesday</button>
                        <button class="tablinks" id="tabThursday" onclick="openTab(event, 'Thursday')">Thursday</button>
                        <button class="tablinks" id="tabFriday" onclick="openTab(event, 'Friday')">Friday</button>
                        <button class="tablinks" id="tabSaturday" onclick="openTab(event, 'Saturday')">Saturday</button>
                        <button class="tablinks" id="tabSunday" onclick="openTab(event, 'Sunday')">Sunday</button>
                    </div>
                    @endif
                    <div class="schedulerContainer" style="overflow: auto;">
                        <div class="loader" style="justify-content: center; align-items: center; display: flex;" hidden>
                            <img src="{{ url('/images/scheduler-loding.gif') }}" width="200" height="200" style="opacity: 0.5;" alt="">
                        </div>
                        @if ($data->scheduledDuration == 1)
                        <div id="scheduleHTML">
                            <table class="table table-bordered" style="width: 250%;">
                                <thead>
                                    <tr>
                                        <?php for ($i = 0; $i < 24; $i++) { ?>
                                            <th style="color: lightslategray;background-color:#f1f1f1;"><?= $i ?>h</td>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody id="scheduleRow">
                                    <tr>
                                        <?php for ($i = 0; $i < 24; $i++) { ?>
                                            <td class="drop" ondrop="drop(event,'{{ $i }}')" ondragover="allowDrop(event)" ></td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @elseif ($data->scheduledDuration == 0)
                        <div id="scheduleHTML">
                            <div id="Monday" class="tabcontent">
                                <table class="table table-bordered" style="width: 250%;">
                                    <thead>
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <th style="color: lightslategray;background-color:#f1f1f1;"><?= $i ?>h</td>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleRow">
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <td class="drop" ondrop="drop(event,'{{ $i }}')" ondragover="allowDrop(event)" ></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="Tuesday" class="tabcontent">
                                <table class="table table-bordered" style="width: 250%;">
                                    <thead>
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <th style="color: lightslategray;background-color:#f1f1f1;"><?= $i ?>h</td>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleRow">
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <td class="drop" ondrop="drop(event,'{{ $i }}')" ondragover="allowDrop(event)" ></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="Wednesday" class="tabcontent">
                                <table class="table table-bordered" style="width: 250%;">
                                    <thead>
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <th style="color: lightslategray;background-color:#f1f1f1;"><?= $i ?>h</td>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleRow">
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <td class="drop" ondrop="drop(event,'{{ $i }}')" ondragover="allowDrop(event)" ></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="Thursday" class="tabcontent">
                                <table class="table table-bordered" style="width: 250%;">
                                    <thead>
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <th style="color: lightslategray;background-color:#f1f1f1;"><?= $i ?>h</td>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleRow">
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <td class="drop" ondrop="drop(event,'{{ $i }}')" ondragover="allowDrop(event)" ></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="Friday" class="tabcontent">
                                <table class="table table-bordered" style="width: 250%;">
                                    <thead>
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <th style="color: lightslategray;background-color:#f1f1f1;"><?= $i ?>h</td>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleRow">
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <td class="drop" ondrop="drop(event,'{{ $i }}')" ondragover="allowDrop(event)" ></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="Saturday" class="tabcontent">
                                <table class="table table-bordered" style="width: 250%;">
                                    <thead>
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <th style="color: lightslategray;background-color:#f1f1f1;"><?= $i ?>h</td>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleRow">
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <td class="drop" ondrop="drop(event,'{{ $i }}')" ondragover="allowDrop(event)" ></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="Sunday" class="tabcontent">
                                <table class="table table-bordered" style="width: 250%;">
                                    <thead>
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <th style="color: lightslategray;background-color:#f1f1f1;"><?= $i ?>h</td>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleRow">
                                        <tr>
                                            <?php for ($i = 0; $i < 24; $i++) { ?>
                                                <td class="drop" ondrop="drop(event,'{{ $i }}')" ondragover="allowDrop(event)" ></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row container" id="realVideosHtml">
                    @php
                        $videoCount = 0;
                    @endphp
                    @for ($i = 0; $i < count($video); $i++)
                        @php
                            $videoCount++;
                        @endphp
                        <div id="video_<?= $videoCount ?>" class="specificVideo" draggable="true" ondragstart="drag(event)" style="cursor: all-scroll;position:relative;">
                            <input class="videoId" value="<?= $video[$i]->id ?>" type="hidden">
                            <input class="scheduleRowId" value="" type="hidden">
                            <video width="100" height="70" style="border: 0.5px solid lightgray;">
                                <source src="{{ url('uploads/') . '/' . $video[$i]->image_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @endfor
                </div>
                <input type="hidden" id="videosCount" value="{{ count($video) }}">
                <input type="hidden" id="selectedTab" value="">
                <input type="hidden" id="channelId" value="{{ $data->id }}">
                <input type="hidden" id="scheduledType" value="{{ $data->scheduledDuration }}">
                @for ($i = 0; $i < count($video); $i++)
                    <input type="hidden" id="videoUrl_<?= $i ?>" value="{{ url('uploads/') . '/' . $video[$i]->image_url }}" />
                @endfor
                @for ($i = 0; $i < count($video); $i++)
                    <input type="hidden" id="videoId_<?= $i ?>" value="{{ $video[$i]->id }}" />
                @endfor
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTiming" tabindex="-1" aria-labelledby="modalTimingLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="modalTimingLabel">Modal title</h5> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('ajaxScheduleVideo') }}" method="post">
                        <input type="hidden" value="" name="selectedSchedulerId" id="selectedSchedulerId">
                        <label for="Start" class="container start">Start</label>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">hour</label>
                                <select class="form-control disabledSelect" name="scheduleHours" id="scheduleHours">
                                    <option value="1" selected>1</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">minutes</label>
                                <select class="form-control" name="scheduleMinutes" id="scheduleMinutes" onchange="previewCustomSchedule()">
                                    @php
                                        $minutes = 0;
                                        for ($i = 0; $i < 60; $i++)
                                        {
                                            if($i < 10)
                                            {
                                                $minutes = "0".$i;
                                            }
                                            else
                                            {
                                                $minutes = $i;
                                            }
                                            echo '<option value="'.$minutes.'">'.$minutes.'</option>';
                                        }
                                    @endphp

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">seconds</label>
                                <select class="form-control disabledSelect" name="scheduleSeconds" id="scheduleSeconds">
                                    <option value="1" selected>1</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <label for="End" class="container end">End</label>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">hour</label>
                                <select class="form-control disabledSelect" name="endHours" id="endHours">
                                    <option value="1" selected>1</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">minutes</label>
                                <select class="form-control disabledSelect" name="endMinutes" id="endMinutes">
                                    <option value="1" selected>1</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">seconds</label>
                                <select class="form-control disabledSelect" name="endSeconds" id="endSeconds">
                                    <option value="1" selected>1</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="float: left;">Cancel</button>
                    <button type="button" class="btn btn-primary" style="background: #fc6075;" onclick="customSchedule()">Schedule</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        // onload variables
        var videoCount = $("#videosCount").val();
        var videoContainerCount = videoCount;
        var videoUrl = "";
        var lastInsertedId = 0;
        var scheduledType = $("#scheduledType").val();
        getScheduleRow();
        setTimeout(function(){
            if(scheduledType == 0)
            {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++)
                {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++)
                {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                $("#tabMonday").addClass("active");
                $("#Monday").css("display","block");
                $("#selectedTab").val("Monday");
            }
        },1500);

        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text/html", ev.target.id);
        }

        function drop(ev,i)
        {
            var checkTargetClass = ev.target.className;
            if(checkTargetClass == "drop")
            {
                $(".loader").attr("hidden",false);
                ev.preventDefault();
                var hour =  parseInt(i) < 10 ? "0" + i : i;
                var data = ev.dataTransfer.getData("text/html");
                var videoId = $("#"+data+" .videoId").val();
                ev.target.appendChild(document.getElementById(data));
                $("#"+data).append('<a onclick="removeVideo(\''+data+'\')">✕</a>');
                $("#"+data).attr("title","Double click to change time.");
                $("#scheduleHours").html("<option value='"+hour+"' selected>"+hour+"</option>");
                $("#scheduleMinutes").val("00").change();
                selectedSchedulerId = $("#"+data+" .scheduleRowId").val();
                ajaxScheduleVideo(videoId,hour,selectedSchedulerId);

                setTimeout(function(){
                    if(lastInsertedId != 1)
                    {
                        $("#"+data+" .scheduleRowId").val(lastInsertedId);
                        $("#selectedSchedulerId").val(lastInsertedId);
                        $("#"+data).attr("ondblclick","openScheduleModalOnDblClick('"+lastInsertedId+"')");
                        $("#"+data).append('<span class="specificVideoTime" id="specificVideoTime_'+lastInsertedId+'">'+hour+':00:00</span>');
                    }
                    setScheduleRow();
                    getScheduleRow();
                    $("#modalTiming").modal("show");
                },1500);
            }
        }

        function videoHtml() {
            html = "";
            for (i = 0; i < videoCount; i++) {
                videoUrl = $("#videoUrl_" + i).val();
                videoId = $("#videoId_" + i).val();
                videoContainerCount = parseInt(videoContainerCount) + 1;
                html += '<div id="video_' + videoContainerCount +
                    '" class="specificVideo" draggable="true" ondragstart="drag(event)" style=""><input class="videoId" value="'+videoId+'" type="hidden"><input class="scheduleRowId" value="" type="hidden"><video width="100" height="70" style="border: 0.5px solid lightgray;"> <source src="' +
                    videoUrl + '" type="video/mp4"> Your browser does not support the video tag. </video></div>';
            }
            return html;
        }

        function ajaxScheduleVideo(videoId,hour,selectedSchedulerId)
        {
            var channelId = $("#channelId").val();
            var scheduleTime = hour+":00:00";
            var selectedTab = $("#selectedTab").val();
            jQuery.ajax({
                url:"{{ url('ajaxScheduleVideo') }}",
                method:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    channelId:channelId,
                    videoId:videoId,
                    scheduleTime:scheduleTime,
                    selectedTab:selectedTab,
                    selectedSchedulerId:selectedSchedulerId
                },
                success:function(response){
                    lastInsertedId = response;
                    console.log('video has been scheduled.');
                }
            });
        }
        function setScheduleRow()
        {
            var channelId = $("#channelId").val();
            var scheduleRowHTML = $("#scheduleHTML").html();
            var videoSerialFirstCount = videoContainerCount;
            jQuery.ajax({
                url:"{{ url('setScheduleRow') }}",
                method:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    channelId:channelId,
                    videoCount:videoSerialFirstCount,
                    scheduleRowHTML:scheduleRowHTML
                },
                success:function(response){
                    console.log("schedule table updated.");
                }
            });
        }
        function getScheduleRow()
        {
            var channelId = $("#channelId").val();
            var scheduledType = $("#scheduledType").val();
            jQuery.ajax({
                url:"{{ url('getScheduleRow') }}",
                method:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    channelId:channelId,
                },
                success:function(response){
                    if(response["scheduleHTML"] != '')
                    {
                        $("#scheduleHTML").html(response["scheduleHTML"]);
                        videoContainerCount = parseInt(response["videoCount"]);
                        $("#realVideosHtml").html(videoHtml());
                        console.log('updated table has been set.');
                        $(".loader").attr("hidden",true);
                    }
                    else
                    {
                        if(scheduledType == 0)
                        {
                            $("#tabMonday").addClass("active");
                            $("#Monday").css("display","block");
                            $("#selectedTab").val("Monday");
                        }
                        console.log('no video scheduled.');
                        $(".loader").attr("hidden",true);
                    }
                }
            });
        }

        function customSchedule()
        {
            $(".loader").attr("hidden",false);
            var selectedSchedulerId = $("#selectedSchedulerId").val();
            var scheduleHours = $("#scheduleHours").val();
            var scheduleMinutes = $("#scheduleMinutes").val();
            var channelId = $("#channelId").val();
            var scheduleTime = scheduleHours+":"+scheduleMinutes+":00";
            jQuery.ajax({
                url:"{{ url('ajaxScheduleVideo') }}",
                method:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    channelId:channelId,
                    selectedSchedulerId:selectedSchedulerId,
                    scheduleTime:scheduleTime,
                },
                success:function(response)
                {
                    console.log('video has been scheduled.');
                    $("#specificVideoTime_"+selectedSchedulerId).html(scheduleTime);
                    setScheduleRow();
                    $("#modalTiming").modal("hide");
                    $(".loader").attr("hidden",true);
                }
            });
        }

        function previewCustomSchedule()
        {
            // $(".loader").attr("hidden",false);
            var selectedSchedulerId = $("#selectedSchedulerId").val();
            var scheduleHours = $("#scheduleHours").val();
            var scheduleMinutes = $("#scheduleMinutes").val();
            var channelId = $("#channelId").val();
            var scheduleTime = scheduleHours+":"+scheduleMinutes+":00";
            jQuery.ajax({
                url:"{{ url('previewCustomSchedule') }}",
                method:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    channelId:channelId,
                    selectedSchedulerId:selectedSchedulerId,
                    scheduleTime:scheduleTime,
                },
                success:function(response)
                {
                    var endTime = response.split(":");
                    var endHours = endTime[0];
                    var endMinutes = endTime[1];
                    var endSeconds = endTime[2];
                    $("#endHours").html('<option value="'+endHours+'">'+endHours+'</option>');
                    $("#endMinutes").html('<option value="'+endMinutes+'">'+endMinutes+'</option>');
                    $("#endSeconds").html('<option value="'+endSeconds+'">'+endSeconds+'</option>');
                }
            });
        }

        function openTab(evt, day)
        {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++)
            {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++)
            {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(day).style.display = "block";
            evt.currentTarget.className += " active";
            $("#selectedTab").val(day);
        }

        function openScheduleModalOnDblClick(selectedSchedulerId)
        {
            $("#selectedSchedulerId").val(selectedSchedulerId);
            jQuery.ajax({
                url:"{{ url('getSpecificVideoScheduleTime') }}",
                method:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    selectedSchedulerId:selectedSchedulerId,
                },
                success:function(response){
                    var scheduleTime = response[0]["schedule_time"];
                    var endTime = response[0]["end_time"];
                    scheduleTime = scheduleTime.split(":");
                    endTime = endTime.split(":");
                    var startHours = scheduleTime[0];
                    var startMinutes = scheduleTime[1];
                    var startSeconds = scheduleTime[2];
                    var endHours = endTime[0];
                    var endMinutes = endTime[1];
                    var endSeconds = endTime[2];
                    $("#scheduleHours").html('<option value="'+startHours+'">'+startHours+'</option>');
                    $("#scheduleMinutes").val(startMinutes).change();
                    $("#scheduleSeconds").html('<option value="'+startSeconds+'">'+startSeconds+'</option>');
                    $("#endHours").html('<option value="'+endHours+'">'+endHours+'</option>');
                    $("#endMinutes").html('<option value="'+endMinutes+'">'+endMinutes+'</option>');
                    $("#endSeconds").html('<option value="'+endSeconds+'">'+endSeconds+'</option>');
                    $("#modalTiming").modal("show");
                }
            });
        }


        function removeVideo(attribute)
        {
            $(".loader").attr("hidden",false);
            var selectedSchedulerId = $("#"+attribute+" .scheduleRowId").val();
            jQuery.ajax({
                url:"{{ url('/removeSpecificVideoScheduleTime') }}",
                method:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    selectedSchedulerId:selectedSchedulerId,
                },
                success:function(response){
                    $("#"+attribute).remove();
                    setScheduleRow();
                    getScheduleRow();
                    // $(".loader").attr("hidden",true);
                }
            });
        }
    </script>
@endsection
