@extends('user.layouts.app')
@section('content')

<style>
    #ChanelList tr:hover,
    #VideoListingOnChannelPanel tr:hover
    {
        background-color: #DCDCDC;
        cursor: pointer;
    }
    .active{
        background-color: #DCDCDC;
    }
    #channelNameSpan
    {
        display: inline-block;
        width: 150px;
        white-space: nowrap;
        overflow: hidden !important;
        text-overflow: ellipsis;
    }
</style>


<div class="content-wrappe r">
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="main-header">

            </div>
        </div>
    </div>
</div>
<div class="container text-center">
    <div class="row">
        <div class="col-lg-6">
            <input type="hidden" id="channelId" name="channelId">
            <div class="card">
                <div class="card-header">
                    <a href="{{url('/create_channel')}}" class="btn btn-primary text-center" style="float: right;">Create Channels</a>
                    <h4 class="card-title mb-0" style="float: left;">Channels</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th style="width: 58%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="ChanelList">
                                @foreach ($chanels as $chanel)
                                <tr>
                                    <td  onclick="GetChannelVideos('{{ $chanel->id }}','{{ $chanel->name }}','{{ $chanel->ChanelType }}')" style="text-align:left;">
                                        @if ($chanel->ChanelType == "ondemand")
                                            <i class="fa fa-list-ul text-blue"  style="font-size: 1.1em;margin-top: 1px;float: left;"></i>
                                        @elseif($chanel->ChanelType == "linear_looped")
                                            <i class="fa fa-repeat text-success" style="font-size: 1.1em;margin-top: 1px;float: left;"></i>
                                        @elseif($chanel->ChanelType == "linear_schedule")
                                            <i class="fas fa-calendar-alt" style="font-size: 1.2em;margin-top: 1px;float: left;color: #FFBF00"></i>
                                        @endif
                                        <span class="ml-2" id="channelNameSpan">
                                            {{ $chanel->name }}
                                        </span>
                                    </td>
                                    @php
                                        if($chanel->ChanelType == "ondemand")
                                        {
                                            $editChannelUrl = url('/ondemand') . '/' . $chanel->id;
                                            $channelType = "ondemand";
                                        }
                                        else if($chanel->ChanelType == "linear_looped")
                                        {
                                            $editChannelUrl = url('/looped') . '/' . $chanel->id;
                                            $channelType = "linearLooped";
                                        }
                                        else if($chanel->ChanelType == "linear_schedule")
                                        {
                                            $editChannelUrl = url('/linear_scheduled') . '/' . $chanel->id;
                                            $channelType = "linearSchedule";
                                        }
                                    @endphp
                                    <td style="text-align:right;" onclick="GetChannelVideos('{{ $chanel->id }}','{{ $chanel->name }}','{{ $channelType }}')">
                                        <div class="btn btn-sm btn-primary openEmbedChannelModal"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title=""
                                            data-original-title="Preview & Embed"
                                            onclick="OpenEmbedChannelModal('{{ $chanel->id }}')">
                                            <i class="la la-code"></i>
                                            Preview & Embed
                                        </div>
                                        <a href="javascript:void(0)"
                                            type="button"
                                            title=""
                                            name="duplicate"
                                            class="btn btn-sm btn-primary"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title=""
                                            data-original-title="Duplicate"
                                            onclick="openDuplicateChannelModal('{{ $chanel->id }}','{{ $chanel->name }}','{{ $channelType }}')"
                                            >
                                            <i class="la la-copy" onclick=""></i>
                                        </a>
                                        <a href="{{ $editChannelUrl }}"
                                            type="button"
                                            title=""
                                            name="edit"
                                            class="btn btn-sm btn-primary"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title=""
                                            data-original-title="Edit">
                                            <i class="la la-pencil"></i>
                                        </a>

                                        <a href="{{ url('delete-chanel/' . $chanel->id) }}" type="button"
                                            class="btn btn-sm btn-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Delete">
                                            <i class="la la-trash"></i>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Video Panel --}}
        <div class="col-lg-6"  id="card_1">
            <div class="card">
                <div class="card-header">
                    <div id="ChannelTypeLogo">
                    </div>
                    <h4 class="card-title mb-0 mt-1 ml-5" style="text-align: left;" id="ChannelName">
                    </h4>
                </div>
                <div class="card-body row">
                    <div class="col-md-12 mb-2">
                        <a type="button" title="" name="add_video" id="AddVideoButton" class="btn btn-primary mb-2 ml-2 btn-sm" style="float:left;color:white;"  onclick="OpenVideosModel(0)">
                            <i class="la la-plus" style="font-weight: bolder;"></i>
                            Add Video
                        </a>
                        <a type="button" title="" name="add_video" id="ScheduleVideoButton" class="btn btn-primary mb-2 ml-2 btn-sm" style="float:left;color: white" href="/scheduleVideo/74" >
                            <i class="la la-plus" style="font-weight: bolder;"></i>
                            Schedule
                        </a>
                    </div>
                    <table class="table table-striped" style="text-align: left;">
                        <thead>
                            <tr>
                                <th width="10%">Video</th>
                                <th>Name</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="VideoListAccordingToChannel">
                        </tbody>
                    </table>
                </div>
        </div>

    </div>
</div>
</div>
<!-- Edit Video Modal -->

<!-- Add Video Modal -->
<div id="add_video" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/video_store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="ChanelID" id="ChanelID" class="ChanelID" value="0">
                <div class="modal-body">
                    <div class="container">
                        <input type="hidden" value="{{count($videos)}}" id="total_videos">
                        <table class="table mb-0" style="text-align: left;border: 0.5px solid lightgray;">
                            <thead>
                            </thead>
                            <tbody id="VideoListingOnChannelPanel">
                                @php
                                    $video_count = 0;
                                @endphp
                                @foreach ($videos as $video)
                                <tr>
                                    <td>
                                        <input type="hidden" value="{{$video->id}}" id="video_id_avl_{{ ++$video_count }}">
                                        <input type="checkbox" name="videos[]" value="{{$video->id}}" id="chk_video_id_avl_{{ $video_count }}" style="width:16px;height: 16px;">
                                    </td>
                                    <td>
                                        <video width="50" height="30" style="border: 0.5px solid lightgray;">
                                            <source src="{{ url('uploads/' . $video->image_url) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        @php
                                            $url_vid = url('uploads/' . $video->image_url);
                                        @endphp
                                    </td>
                                    <td>
                                        <h5 style="font-weight: lighter;" >{{$video->name}}</h5>
                                    </td>
                                </tr>
                                @endforeach
                            <tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" style="float: right;margin-right:15px;">
                    <div class="form-group" style="float: right;margin-left: 15px;">
                        <button type="submit"class="btn btn-success waves-effect waves-light m-r-30">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Embed Video Modal --}}
<div id="embed_channel" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EmbedModalTitle"  style="font-size: 18px">Embed Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="EmbedVideoSource" id="EmbedVideoSource" value="">
                <input type="hidden" id="EmbedType"  value="">
                <div class="container EmbedVideoContainer" id="EmbedVideoContainer">
                </div>
                <input type="hidden" id="CodeType">
                <div class="row mt-2">
                    <div class="col-md-4">

                        <div class="card">
                            <div class="card-body">
                                <h5>Size</h5>

                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a class="nav-link active" href="#basictab1" data-toggle="tab" id="ResponsiveTab">Responsive</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#basictab2" data-toggle="tab" id="FixedTab">Fixed</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="basictab1">
                                        <select class="form-control" id="aspect-ratio" onchange="SetEmbedChannel()">
                                            <option value="16:9" selected >16:9</option>
                                            <option value="4:3">4:3</option>
                                            <option value="1:1">1:1</option>

                                        </select>
                                    </div>
                                    <div class="tab-pane" id="basictab2">
                                        <div class="row" style="justify-content: center; align-items: center;background-color: white">
                                            <div class="col-md-5">
                                                <input min="0" class="form-control" id="Pixel1" onkeyup="SetEmbedChannel()" onkeydown="SetEmbedChannel()" onkeypress="SetEmbedChannel()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                                            </div>
                                            <div class="col-md-2">X</div>
                                            <div class="col-md-5">
                                                <input min="0" class="form-control" id="Pixel2" onkeyup="SetEmbedChannel()" onkeydown="SetEmbedChannel()" onkeypress="SetEmbedChannel()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" id="PlaybackOptionsBlock" style="text-align: left" >
                        <h5>Playback Options</h5>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" onclick="SetEmbedChannel()" id="AutoplayCheck"name="checkbox">
                                <span>Autoplay (if possible)</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" onclick="SetEmbedChannel()" id="VolumeCheck" name="checkbox" checked>
                                <span>Volume</span>
                            </label>
                        </div>
                        <div class="checkbox" id="PlaylistModeContainer" hidden>
                            <label>
                                <input type="checkbox" onclick="SetEmbedChannel()" id="PlaylistMode"  name="checkbox">
                                <span>Playlist mode</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4" id="DisplayOptions" style="text-align: left">
                        <h5>Display options</h5>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" onclick="SetEmbedChannel()" id="ShowControl" name="checkbox" checked>
                                <span>Show Control</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" onclick="SetEmbedChannel()" id="ShowContentTitle" name="checkbox" checked>
                                <span>Show content title</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" onclick="SetEmbedChannel()" id="ShowShareButtons" name="checkbox" checked>
                                <span>Show share buttons</span>
                            </label>
                        </div>
                        <div class="checkbox" id="OpenPlaylistContainer" hidden>
                            <label>
                                <input type="checkbox" onclick="SetEmbedChannel()" id="OpenPlaylist"  name="checkbox">
                                <span>Open playlist on load</span>
                            </label>
                        </div>
                    </div>

                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label">Code<span class="text-danger">*</span></label>
                        <textarea rows="5" cols="5" id="EmbedCode" class="form-control" placeholder="Enter text here" name="embed_code"></textarea>
                    </div>
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary" onclick="CopyEmbedCode()" >Copy Embed Code</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Video Modal -->
<div id="duplicateChannelModal" class="modal custom-modal fade" role="dialog">
    <form action="{{url('/createDuplicateChannel')}}" method="POST">
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Duplicate Channel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="channelIdForDublicate" name="channelIdForDublicate" value="0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Name <span class="text-danger"></span></label>
                                <input type="text"  class="form-control" id="duplicateChannelName"  name="duplicateChannelName" value="" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Yes">
                </div>
            </div>
        </div>
    </form>
</div>

<script>

    function OpenVideosModel(id)
    {
        if(id == 0)
        {
            alert("Please Select Any Channel");
        }
        else
        {
            $(".ChanelID").val(id);
            $("#add_video").modal('show');
        }
    }

    function openDuplicateChannelModal(channelId,channelName,channelType)
    {
        channelName = "Copy Of " + channelName;
        $("#channelIdForDublicate").val(channelId);
        $("#duplicateChannelName").val(channelName);
        $("#duplicateChannelModal").modal('show');
    }

</script>

<script type="text/javascript">
    var video_tabl_row;
    function start()
    {
        video_tabl_row = event.target;
    }
    function dragover()
    {
        var e = event;
        e.preventDefault();
        let children = Array.from(e.target.parentNode.parentNode.children);
        if (children.indexOf(e.target.parentNode) > children.indexOf(video_tabl_row))
        {
            e.target.parentNode.after(video_tabl_row);
            sortVideosOrder();
        }
        else
        {
            e.target.parentNode.before(video_tabl_row);
        }


        if (children.indexOf(e.target.parentNode) < children.indexOf(video_tabl_row))
        {
            sortVideosOrder();
        }
    }

    function sortVideosOrder()
    {
        var videosOrderInput = $(".videosOrderInput");
        var channelId = $("#channelId").val();
        const videosArray = [];

        for(var i = 0; i < videosOrderInput.length; i++)
        {
            videosArray[i] = $(videosOrderInput[i]).val();
        }

        let implodeVideos = videosArray.join(",");
        console.log(implodeVideos);
        console.log(channelId);
        var videosOrderCount = $(".videosOrder");

        for(var i = 0; i < videosOrderCount.length; i++)
        {
            counting = i + 1;
            $(videosOrderCount[i]).html(counting + '. ');
        }

        $.ajax({
            url: "{{ url('/channel/sortVideos') }}",
            type: "POST",
            data: {
                channelId: channelId,
                implodeVideos: implodeVideos,
                _token: '{{ csrf_token() }}'
            },
            success: function(data)
            {
                console.log(data);
            }
        });
    }


</script>


@endsection

