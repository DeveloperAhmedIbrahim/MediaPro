@extends('user.layouts.app')
@section('content')
    <style>
        div#VideoContainer {
            display: flex;
            justify-content: center;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            display: block !important;
        }
        .select2-container {
            display: initial !important;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: solid lightgray 1px !important;
            z-index: 1 !important;
        }
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #e3e3e3 !important;
            z-index: 1 !important;
        }
        #videoPreviewModalCloseBtn {
            position: absolute;
            top: -6%;
            right: 10%;
            color: white;
            text-shadow: none;
            background: none;
            font-size: 40px;
        }
        #videoNameSpan {
            display: inline-block;
            width: 90%;
            white-space: nowrap;
            overflow: hidden !important;
            text-overflow: ellipsis;
            transition: 0.2;
            cursor: pointer;
        }
        #videoNameSpan:hover {
            color: dodgerblue;
        }
        .videoBtn{
            font-size: 25px;
            font-weight: bold;
            color: white;
            border-radius: 0px;
            padding: 0 10px;
        }
    </style>

    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Videos</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Videos</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"> </div>
            <div class="col-md-2">
                <span class="input-group-addon" style="padding:0">
                    <a id="add-video-url" vl-animated-button="" class="btn btn-primary ng-binding ng-isolate-scope"
                        style="width: 140px; height: 50px; font-size: 16px !important; border-radius: 0; margin-top:-1px;justify-content: center;align-items: center; display: flex;"
                        href="{{ url('/select_video') }}">
                        Upload Video
                    </a>
                </span>
            </div>
            <div class="col-md-1" style="justify-content: center;align-items: center; display: flex;">
                <h4>or</h4>
            </div>
            <div class="col-md-5">
                <form action="{{ url('addM3u8Link') }}" method="post" id="addM3u8LinkForm">
                    @csrf
                    <div class="input-prepend input-group">
                        <input class="form-control focused ng-pristine ng-valid ng-empty ng-touched" type="text"
                            name="m3u8Link"
                            style="width: 5%; height: 50px; font-size: 16px !important; border-top: 1px solid rgb(204, 204, 204) !important; border-bottom: 1px solid rgb(204, 204, 204) !important; border-left: 1px solid rgb(204, 204, 204) !important; border-image: initial !important; border-right: none !important;"
                            placeholder="Video URL (.m3u8 link)" id="m3u8Link" required>
                        <span class="input-group-addon" style="padding:0">
                            <button id="addM3u8LinkBtn" class="btn btn-primary ng-binding ng-isolate-scope"
                                style="width: 140px; height: 50px; font-size: 16px !important; border-radius: 0; margin-top:-1px;">
                                Add Video URL
                            </button>
                        </span>
                        <span data-ng-controller="HelpController" style="padding:0 0 0 5px;display: table-cell;width: 30px"
                            class="ng-scope">
                            <a data-ng-click="openWhichFormatsWeSupport()" href="javascript:void(0)" class="vl_question"
                                data-toggle="tooltip" data-original-title="Learn more" data-placement="right"
                                vl-tooltip=""><i class="fa fa-question-circle"></i></a>
                        </span>
                    </div>
                    <div id="incorrectM3u8Url" class="text-danger" style="font-size: 14px">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ url('/user/search_video') }}" method="post">
            @csrf
            <div class="row filter-row">
                <div class="col-sm-6 col-md-2">
                    <label for="">Search by name</label>
                    <input type="text" class="form-control floating" name="searching_name" id="searching_name"
                        placeholder="" style="height: 33px !important;">
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="form-group form-focus">
                        <label for="">Search by tag</label>
                        <select class="searching_tags form-control js-example-tokenizer" name="searching_tag[]"
                            multiple="multiple" id="searching_tag">
                            @foreach ($tags_for_searching as $tags_info)
                                <option value="{{ $tags_info->tag }}">{{ $tags_info->tag }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="form-group form-focus select-focus focused">
                        <label for="">&nbsp;</label>
                        <select class="form-control" name="searching_type"
                            style="padding: 0px !important; padding-left: 8px !important;height: 33px;">
                            <option value="any" selected>Match Any Tags</option>
                            <option value="all">Match All Tags</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <label for="">&nbsp;</label>
                    <input type="submit" class="btn btn-purple btn-block" value="Search"
                        style="padding: 0px !important;min-height: 33px !important; border-radius: 0px; letter-spacing: 2px;" />
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="form-group form-focus select-focus focused">
                        <label for="">&nbsp;</label>
                        <select class="form-control" name="video_type"
                            style="padding: 0px !important; padding-left: 8px !important;height: 33px;">
                            <option value="all" selected>All Media Type</option>
                            <option value="hosted">Hosted Videos</option>
                            <option value="external">External Links</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <label for="">&nbsp;</label>
                    <a href="{{ url('/manage/videos') }}" class="btn btn-danger btn-block" value="Reset"
                        style="padding: 0px !important;min-height: 33px !important; border-radius: 0px; letter-spacing: 1px; padding-top: 3px !important;">
                        RESET </a>
                </div>
            </div>
        </form>
    </div>

    <div class="container" style="margin-top:10px;margin-left:10px" id="Content">
        <div class="row" id="dynamic-row">
            <input type="hidden" name="" id="channelId" value="0">
            @foreach ($videos as $video)
                <div class="col-md-4 col-sm-6 col-xs-12 mb-3 mx-1">
                    <div>
                        @php
                            if ($video->is_mtu8 == 1) {
                                $videoUrl = $video->image_url;
                            } else {
                                $videoUrl = $video->image_url;
                            }
                        @endphp
                        <iframe
                            src="{{ url('/') }}/embed?url={{ $videoUrl }}&autoplay=0&volume=1&controls=1&title=0&share=1&open_playlist=1&disabled=1"
                            width="280" height="160" title="MediaPro Video" allowfullscreen="true"
                            frameBorder="0">
                        </iframe>
                    </div>
                    <div class="row container">
                        <span id="videoNameSpan" onclick="OpenVideoPreview('{{ $videoUrl }}');">
                            {{ $video->name }}
                        </span>
                    </div>
                    <div class="row" style="margin-left: -24px;padding-left: 10px;padding-right: 35px;">
                        <div class="col-md-2">
                            <button type="button" id={{ $video->id }} name="edit"
                                class="btn btn-warning openEditVideoMadal videoBtn"
                                onclick="OpenVideo('{{ $videoUrl }}','{{ $video->id }}')"data-toggle="tooltip"
                                data-placement="top" title="" data-original-title="Edit">
                                <i class="la la-pencil"></i>
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button type="button"
                                class="btn btn-warning openEmbedVideoMadal videoBtn"
                                onclick="OpenEmbedVideoModal('{{ $videoUrl }}','0')"
                                data-toggle="tooltip"
                                data-placement="top" title="" data-original-title="Embed">
                                <i class="la la-code"></i>
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" name="tag"
                                class="btn btn-warning openManageTagsModal videoBtn"
                                onclick="addTagVideo('{{ $videoUrl }}','{{ $video->id }}')"
                                data-toggle="tooltip"
                                data-placement="top" title="" data-original-title="Tags">
                                <i class="la la-tag"></i>
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="">
                                <a href="{{ url('/download/video/' . $video->id) }}" type="button" target="_blank"
                                    class="btn btn-warning videoBtn" data-toggle="tooltip"
                                    data-placement="top" title="" data-original-title="Download">
                                    <i class="la la-cloud-download"></i>
                                </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ url('/delete/vedio/' . $video->id) }}" type="button"
                                class="btn btn-warning videoBtn" data-toggle="tooltip"
                                data-placement="top" title="" data-original-title="Delete">
                                <i class="la la-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div id="searchbytag"> </div>
    </div>

    <!-- Edit Video Modal -->
    <div id="edit_video" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container VideoContainer" id="VideoContainer">
                    </div>
                    <form action="{{ route('edit_vedio_post') }}" method="POST">
                        @csrf
                        <input type="hidden" class="edit_video_id" name="id">
                        <div class="row container mt-4">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                    <input class="edit_video_name form-control" type="text" name="name">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Tags</label>
                                    <div>
                                        <select class="form-control js-example-tokenizer" name="tag[]"
                                            multiple="multiple" id="edit_video_tag"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12"></div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Embed Video Modal -->
    <!-- Add tag Modal -->
    <div id="manage_tags" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Tags</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('insert_tag') }}" method="POST">
                        @csrf
                        <input type="hidden" class="edit_video_id" name="id">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                    <input class="edit_video_name form-control" type="text" readonly name="name">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Tags</label>
                                    <div>
                                        <select class="form-control js-example-tokenizer" name="tag[]"
                                            multiple="multiple" id="add_video_tag"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- Embed Video Modal --}}
    <div id="embed_channel" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EmbedModalTitle" style="font-size: 18px">Embed Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container EmbedVideoContainer" id="EmbedVideoContainer">
                    </div>
                    <input type="hidden" id="CodeType">
                    <input type="hidden" id="EmbedVideoSource">
                    <div class="row mt-2">
                        <div class="col-md-4">

                            <div class="card">
                                <div class="card-body">
                                    <h5>Size</h5>
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a class="nav-link active" href="#basictab1"
                                                data-toggle="tab" id="ResponsiveTab">Responsive</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#basictab2" data-toggle="tab"
                                                id="FixedTab">Fixed</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="basictab1">
                                            <select class="form-control" id="aspect-ratio" onchange="SetEmbedChannel()">
                                                <option value="16:9" selected>16:9</option>
                                                <option value="4:3">4:3</option>
                                                <option value="1:1">1:1</option>
                                            </select>
                                        </div>
                                        <div class="tab-pane" id="basictab2">
                                            <div class="row"
                                                style="justify-content: center; align-items: center;background-color: white">
                                                <div class="col-md-5">
                                                    <input min="0" class="form-control" id="Pixel1"
                                                        onkeyup="SetEmbedChannel()" onkeydown="SetEmbedChannel()"
                                                        onkeypress="SetEmbedChannel()"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                                                </div>
                                                <div class="col-md-2">X</div>
                                                <div class="col-md-5">
                                                    <input min="0" class="form-control" id="Pixel2"
                                                        onkeyup="SetEmbedChannel()" onkeydown="SetEmbedChannel()"
                                                        onkeypress="SetEmbedChannel()"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" id="PlaybackOptionsBlock" style="text-align: left">
                            <h5>Playback Options</h5>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" onclick="SetEmbedChannel()"
                                        id="AutoplayCheck"name="checkbox">
                                    <span>Autoplay (if possible)</span>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" onclick="SetEmbedChannel()" id="VolumeCheck" name="checkbox"
                                        checked>
                                    <span>Volume</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4" id="DisplayOptions" style="text-align: left">
                            <h5>Display options</h5>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" onclick="SetEmbedChannel()" id="ShowControl" name="checkbox"
                                        checked>
                                    <span>Show Control</span>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" onclick="SetEmbedChannel()" id="ShowContentTitle"
                                        name="checkbox" checked>
                                    <span>Show content title</span>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" onclick="SetEmbedChannel()" id="ShowShareButtons"
                                        name="checkbox" checked>
                                    <span>Show share buttons</span>
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Code<span class="text-danger">*</span></label>
                            <textarea rows="5" cols="5" id="EmbedCode" class="form-control" placeholder="Enter text here"
                                name="embed_code"></textarea>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary" onclick="CopyEmbedCode()">Copy Embed Code</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Video Preview Modal --}}
    <div id="videoPreviewModal" class="modal custom-modal fade" role="dialog" style="border-radius: 0px !important;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content"
                style="border-radius: 0px;padding: 0px !important;background: none;position: absolute;top: 6%;">
                <button type="button" id="videoPreviewModalCloseBtn" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body"
                    style="padding: 0px !important;justify-content: center;align-items:center; display: flex;background: none;"
                    id="videoPreviewModalBody">
                    <iframe
                        src="{{ url('/') }}/embed?url=http://localhost:8000/uploads/7771666598132925.mp4&autoplay=0&volume=1&controls=1&title=0&share=1&open_playlist=1&disabled=0"
                        width="700" height="400" title="MediaPro Video" allowfullscreen="true" frameBorder="0">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(".openManageTagsModal").click(function(){
            $("#manage_tags").modal("show");
        })
        $(".openEditVideoMadal").click(function(){
            $("#edit_video").modal("show");
        });
    </script>

@endsection
