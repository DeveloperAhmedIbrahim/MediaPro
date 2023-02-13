
@php
$videoUrl = '';
$autoplay = 0;
$volume = 1;
$title = 0;
$controls = 0;
$share = 0;
$playlist = 0;
$videoUrlCleaned = '';
$videoTitle = '';
$disabled=0;
$videoType = '';
$channelId = 0;
$logo = '';
$logoLink = '';
$logoPosition = '';
$logoVisiblity = '';
$isVideosAssigned = 0;
$assignedVideosArray = array();
$allVideosLinks = '';
$allVideosNames = '';
$playlist = 0;
$open_playlist = 0;
$loop_channel = 0;
$timeZone = "";

if(isset($_GET["url"]))
{
    $videoUrl = $_GET["url"];
}
if(isset($_GET["autoplay"]) && $_GET["autoplay"] == 1)
{
    $autoplay = $_GET["autoplay"];
}
if(isset($_GET["volume"]) && $_GET["volume"] == 0)
{
    $volume = $_GET["volume"];
}
if(isset($_GET["title"]) && $_GET["title"] == 1)
{
    $title = $_GET["title"];
}
if(isset($_GET["controls"]) && $_GET["controls"] == 1)
{
    $controls = $_GET["controls"];
}
if(isset($_GET["controls"]) && $_GET["controls"] == 1)
{
    $controls = $_GET["controls"];
}
if(isset($_GET["share"]) && $_GET["share"] == 1)
{
    $share = $_GET["share"];
}
if(isset($_GET["disabled"]) && $_GET["disabled"] == 1)
{
    $disabled = $_GET["disabled"];
}
if(isset($_GET["playlist"]) && $_GET["playlist"] == 1)
{
    $playlist = $_GET["playlist"];
}
if (isset($_GET["open_playlist"]) && $_GET["open_playlist"] == 1)
{
    $open_playlist = $_GET["open_playlist"];
}
if (isset($_GET["loop_channel"]) && $_GET["loop_channel"] == 1)
{
    $loop_channel = $_GET["loop_channel"];
}
if($videoUrl != null && $videoUrl != "")
{
    $videoUrl = url('uploads/') . '/' . $videoUrl;
    $videoUrlArray = explode("/",$videoUrl);
    if(count($videoUrlArray) > 0)
    {
        $videoUrlCleaned =  end($videoUrlArray);
    }
}


$videoUrlExtension = pathinfo($videoUrl, PATHINFO_EXTENSION);
if($videoUrlExtension == "m3u8")
{
    $videoData = DB::table('videos')->where("image_url","=",$videoUrl)->get();
}
else
{
    $videoData = DB::table('videos')->where("image_url","=",$videoUrlCleaned)->get();
}

if(count($videoData) > 0)
{
    $videoTitle = $videoData[0]->name;
    if($videoData[0]->is_mtu8 == 1)
    {
        $videoType = "application/x-mpegURL";
    }
    else
    {
        $videoType = "video/mp4";
    }
}
if(isset($channelInfo->id))
{
    $channelId = $channelInfo->id;
    $timeZone = $channelInfo->timeZone;
    $channelType = $channelInfo->ChanelType;
    if($channelType == "linear_looped")
    {
        $loop_channel = 1;
    }
    $logoVisiblity = $channelInfo->logoVisiblity;
    $logo = $channelInfo->logo == null ? '' : $channelInfo->logo;
    $logoLink = $channelInfo->logoLink == null ? '' : $channelInfo->logoLink;
    $logoPosition = $channelInfo->logoPosition == null ? '' : $channelInfo->logoPosition;
    $assignedVideosIds = $channelInfo->videos;
    if($assignedVideosIds != null || $assignedVideosIds != "")
    {
        $isVideosAssigned = 1;
        $assignedVideosIds = explode(",",$assignedVideosIds);
        for($i = 0; $i < count($assignedVideosIds) ; $i++)
        {
            $eachVideoRecord = DB::table('videos')->where("id","=",$assignedVideosIds[$i])->get();
            $assignedVideosArray[] = json_decode(json_encode($eachVideoRecord[0]), true);
        }
        $videosUrlArray = array();
        for($i = 0; $i < count($assignedVideosIds) ; $i++)
        {
            $videosUrlArray[] = $assignedVideosArray[$i]["image_url"];
        }
        $allVideosLinks =  implode(",",$videosUrlArray);
        $videosNameArray = array();
        for($i = 0; $i < count($assignedVideosIds) ; $i++)
        {
            $videosNameArray[] = $assignedVideosArray[$i]["name"];
        }
        $allVideosNames =  implode(",",$videosNameArray);
    }
}

@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediaPro Player</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body style="overflow: hidden !important;">
    <style>
        body{
            margin: 0 !important;
            width: 100% !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }
        .video-js .vjs-big-play-button .vjs-icon-placeholder:before {
            content: "";
            background-image: url('http://localhost:8000/images/playbutton.png');
            background-repeat: no-repeat;
            background-size: 46px;
            background-position: 50% calc(50% - 0px);
            border: none !important;
            box-shadow: none !important;
        }
        .video-js .vjs-big-play-button {
            font-size: 10em;
            height: 1em;
            width: 1em;
            padding: 0;
            cursor: pointer;
            opacity: 1;
            border: 2px solid #fff;
            background-color: #2B333F;
            background-color: rgba(43, 51, 63, 0.7);
            border-radius: 100%;
            transition: all 0.4s;
            position: fixed;
            top: 50%;
            transform: translate(0, -50%);
            left:45% ;

        }
        #videoTitle{
            position: absolute;
            left: 10px;
            bottom: 10px;
        }
        .vjs-has-started .vjs-control-bar{
            position: fixed !important;
            font-size: 15px;
            background-color: rgba(43, 51, 63, 0.2)
        }
        .modal-content{
            border: 2px solid lightslategray;
            background-color: rgba(0, 0, 0, 0.2)
        }
        #multiShareVideoLink:focus {
            outline: none;
            box-shadow: none;
            border: none;
            border-radius: 0px;
            color: lightgray;
        }
        #multiShareIframe:focus {
            outline: none;
            box-shadow: none;
            border: none;
            border-radius: 0px;
            color: lightgray;
        }
        #multiShareVideoLink{
            color: lightgray;
        }
        #multiShareIframe{
            color: lightgray;
        }
        .vjs-watermark img{
            width: 100px !important;
            position: fixed !important;
            top: 4% !important;
        }
        .playlistContainer{
            width: 30%;
            height: 100% !important;
            background: rgba(0,0,0,0.8);
            z-index: 1;
            position: fixed;
            right: -30%;
            transition: 0.4s;
        }
        .btnPlaylistClose{
            font-size: 20px;
            color: white;
            position: absolute;
            top: 0px;
            right: 25px;
            padding: 5px;
            background: rgba(0,0,0,0.5);
        }
        .btnPlaylistClose:hover{
            cursor: pointer;
        }
        .assinedVideosContainer{

        }
        .assinedVideosContainer::-webkit-scrollbar {
            width: 8px;
        }

        .assinedVideosContainer::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px #DCDCDC;
            border-radius: 0;
        }

        .assinedVideosContainer::-webkit-scrollbar-thumb {
            border-radius: 0px;
            background:  #FD6E6A;
        }
    </style>
    <input type="hidden" id="volume" value="{{ $volume }}">
    <input type="hidden" id="autoplay" value="{{ $autoplay }}">
    <input type="hidden" id="title" value="{{ $title }}">
    <input type="hidden" id="titleName" value="{{ $videoTitle }}">
    <input type="hidden" id="controls" value="{{ $controls }}">
    <input type="hidden" id="share" value="{{ $share }}">
    <input type="hidden" id="disabled" value="{{ $disabled }}">
    <input type="hidden" id="logo" value="{{ $logo }}">
    <input type="hidden" id="logoVisiblity" value="{{ $logoVisiblity }}">
    <input type="hidden" id="logoPosition" value="{{ $logoPosition }}">
    <input type="hidden" id="logoLink" value="{{ $logoLink }}">
    <input type="hidden" id="allVideosLinks" value="{{ $allVideosLinks }}">
    <input type="hidden" id="allVideosNames" value="{{ $allVideosNames }}">
    <input type="hidden" id="playlist" value="{{ $playlist }}">
    <input type="hidden" id="open_playlist" value="{{ $open_playlist }}">
    <input type="hidden" id="loop_channel" value="{{ $loop_channel }}">
    <input type="hidden" id="channelId" value="{{ $channelId }}">
    <div class="row playlistContainer">
        <i class="fa-solid fa-xmark btnPlaylistClose"></i>
        @php
            if($loop_channel == 1)
            {
                $pointerEvent = 'pointer-events: none;';
            }
            else
            {
                $pointerEvent = 'pointer-events: auto;';
            }
        @endphp
        <div class="row container assinedVideosContainer"  style="width: 100%;height: 100%;overflow: auto;">
            <?php for($i = 0; $i < count($assignedVideosArray); $i++){ ?>
                <div class="row container" style="background: rgba(0,0,50,0.5);width: 103%;height: 15%;margin-left:0;padding: 0;margin-top: 1%;">
                    <div style="width: 30%;height: 100%;justify-content: center;align-items: center;display: flex;">
                        <img src="{{ asset('admin_assets/assets/img/video-preview-icon.png') }}" style="height: 80%" alt="">
                    </div>
                    <div style="width: 70%;height: 100%;justify-content: center;align-items:center;display: flex;">
                        <a href="javascript:void(0)" onclick="setSelectedVideo('{{ $assignedVideosArray[$i]['image_url'] }}','{{ $assignedVideosArray[$i]['name'] }}','{{ $i }}')" style="width: 100%; white-space: nowrap; display: inherit;color: white;{{ $pointerEvent }}">
                            <span style="overflow: hidden !important; text-overflow: ellipsis;">
                                {{ $assignedVideosArray[$i]["name"] }}
                                <br>
                                @php
                                    $showVideoTimeHiddenAttr = "";
                                    $nowPlayingHiddenAttr = "hidden";
                                    if($i == 0)
                                    {
                                        $showVideoTimeHiddenAttr = "hidden";
                                        $nowPlayingHiddenAttr = "";
                                        $previouseDuration = $assignedVideosArray[$i]['duration'];
                                        $previouseVideoTime = strtotime(date("H:i:s"));
                                    }
                                @endphp
                                <span class="showVideoTime_{{ $i }} showVideoTime" {{ $showVideoTimeHiddenAttr }}>
                                    @php
                                        if($loop_channel == 1)
                                        {
                                            date_default_timezone_set($timeZone);
                                            $nextVideoTime = $previouseVideoTime + $previouseDuration;
                                            $previouseVideoTime = $nextVideoTime;
                                            $nextVideoTime =  date("h:i:s A",$nextVideoTime);
                                            echo $nextVideoTime;
                                            $previouseDuration = $assignedVideosArray[$i]['duration'];
                                        }
                                        else
                                        {
                                            echo date("H:i:s",(int)$assignedVideosArray[$i]['duration']);
                                        }
                                    @endphp
                                </span>
                                <span class="nowPlaying_{{ $i }} nowPlaying" {{ $nowPlayingHiddenAttr }}>
                                    NOW PLAYING
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
                <br>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" id="videoContainer">
            <video class="video-js vjs-custom-theme" id="my-player"  style="position: fixed; bottom: 0;min-width: 100%;min-height: 100%; overflow: hidden !important;">
                <source  src="{{ $videoUrl }}" type="{{ $videoType }}" />
            </video>
        </div>
    </div>
    <div class="modal fade" id="modalMultiShare" tabindex="-1" aria-labelledby="modalMultiShare" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center" style="border: none;padding-bottom: 0px;">
                <h1 class="modal-title fs-1 text-light" style="font-size: 30px;">Share / Embed</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute;right: 15px;"></button>
            </div>
            <div class="modal-body">
                <div class="row d-flex justify-content-center" style="padding-top: 0px;">
                    <div class="btn" style="font-size: 30px;" id="btnFachbookMultiShare">
                        <i class="fa-brands fa-square-facebook" style="color: lightgray"></i>
                    </div>
                    <div class="btn" style="font-size: 30px;" id="btnTwitterMultiShare">
                        <i class="fa-brands fa-square-twitter" style="color: lightgray"></i>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-1" style="border: 2px solid lightslategray;padding: 0px;color: lightgray;font-size: 20px;">
                            <i class="fa-solid fa-link" style="margin: 5px;"></i>
                        </div>
                        <div class="col-md-11" style="border: 2px solid lightslategray;padding: 0px;" >
                            <input type="text" id="multiShareVideoLink" onClick="copyToClipboard(this)" class="form-control" value="{{ $videoUrl }}" style="border:none; border-radius:0px; background-color: transparent;" >
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-1" style="border: 2px solid lightslategray;padding: 0px;color: lightgray;font-size: 20px;">
                            <i class="fa-solid fa-code" style="margin: 5px;"></i>
                        </div>
                        <div class="col-md-11" style="border: 2px solid lightslategray;padding: 0px;" >
                            <textarea name="" id="multiShareIframe" onClick="copyToClipboard(this)" cols="30" rows="7" style="border:none; border-radius:0px; background-color: transparent;width: 100%"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="row" style="position: absolute;bottom: 12px;right: 15px; color: white;" id="btnSharesOnControlHide">
        <i class="fa-brands fa-facebook-f" style="font-weight: bolder;margin: 0px 10px;" id="btnOutFacebookShare"></i>
        <i class="fa-brands fa-twitter twitterShare" style="font-weight: bolder;margin: 0px 10px;" id="btnOutTwitterShare"></i>
        <i class="fa-solid fa-share-nodes" style="font-weight: bolder;margin: 0px 10px;font-size: 20px;" id="btnOutMultiShare"></i>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v15.0" nonce="EO5ZQw04"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="{{ asset('admin_assets/assets/js/videojs.watermark.js') }}"></script>
    <script>

        // set variables
        var volume = $("#volume").val();
        var autoplay = $("#autoplay").val();
        var title = $("#title").val();
        var titleName = $("#titleName").val();
        var controls = $("#controls").val();
        var share = $("#share").val();
        var disabled = $("#disabled").val();
        var playlist = $("#playlist").val();
        var open_playlist = $("#open_playlist").val();
        var loop_channel = $("#loop_channel").val();
        var mutedValued = false;
        var autoplayValue = false;
        var controlsValue = false;

        // set properties values
        if(autoplay == 1)
        {
            autoplayValue = true;
        }
        if(volume == 0)
        {
            mutedValued = true;
        }
        if(controls == 1)
        {
            controlsValue = true;
        }

        if(playlist == 1)
        {
            var videoAnotherObj = document.getElementById("my-player");
            var videoIndex = 0;
            var videosList = 0;
            var allVideosLinks = $("#allVideosLinks").val();
            var allVideosNames = $("#allVideosNames").val();
            var lastVideoIndex = 0;
            var newVideoUrl = "";
            if(allVideosLinks != "")
            {
                allVideosLinks = allVideosLinks.split(",");
                allVideosNames = allVideosNames.split(",");
                lastVideoIndex = allVideosLinks.length - 1;
                videoAnotherObj.onended = function() {
                    videoIndex++;
                    if(loop_channel == 1)
                    {
                        if(videoIndex > lastVideoIndex)
                        {
                            videoIndex = 0;
                        }
                    }
                    newVideoUrl = "{{ url('/uploads') }}" + "/" + allVideosLinks[videoIndex];
                    linkAndExt = allVideosLinks[videoIndex].split(".");
                    videoType = "video/mp4";
                    if(linkAndExt[linkAndExt.length - 1] == "m3u8")
                    {
                        videoType = "application/x-mpegURL";
                        newVideoUrl = allVideosLinks[videoIndex];
                    }
                    videoObject.src({"type":videoType, "src":newVideoUrl});
                    videoObject.play();
                    titleName = allVideosNames[videoIndex];
                    $(".nowPlaying").attr("hidden",true);
                    $(".showVideoTime").attr("hidden",false);
                    $(".showVideoTime_"+videoIndex).attr("hidden",true);
                    $(".nowPlaying_"+videoIndex).attr("hidden",false);

                    if(loop_channel == 1)
                    {
                        $.ajax({
                            url: "{{ url('setNextVideoAndTimeOnVideoEnded') }}",
                            type: "POST",
                            data: {
                                channelId: channelId,
                                _token: '{{ csrf_token() }}'
                            },
                            success:function(response)
                            {
                                $.ajax({
                                    url:"{{ url('loopChannelDynamicPlaylist') }}",
                                    method:"POST",
                                    data: {
                                        channelId: channelId,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success:function(htmlResponse)
                                    {
                                        $(".assinedVideosContainer").html(htmlResponse);
                                    }
                                });
                            }
                        });

                    }
                };
            }
        }

        // video object
        var videoObject = videojs('my-player', {
            controls: true,
            preload: 'auto',
            muted: mutedValued,
            autoplay: autoplayValue,
            controls:controlsValue,
            fluid: true,
        });

        if(share == 1)
        {
            // add facebook share button
            var btnFacebook = videoObject.controlBar.addChild('button', {});
            btnFacebook.addClass("facebookShare");
            var btnFacebookDOM = btnFacebook.el();
            btnFacebookDOM.innerHTML = '<i class="fa-brands fa-facebook-f" style="font-weight: bolder;" ></i>';
            btnFacebookDOM.onclick = function () {
                window.open('https://www.facebook.com/sharer/sharer.php?u={{ $videoUrl }}','facebook-share-dialog','width=800,height=600');
                return false;
            };

            // add twitter share button
            var btnTwitter = videoObject.controlBar.addChild('button', {});
            btnTwitter.addClass("facebookShare");
            var btnTwitterDOM = btnTwitter.el();
            btnTwitterDOM.innerHTML = '<i class="fa-brands fa-twitter" style="font-weight: bolder;" ></i>';
            btnTwitterDOM.onclick = function () {
                window.open('https://twitter.com/intent/tweet?text='+titleName+'&url={{ $videoUrl }}','facebook-share-dialog','width=800,height=600');
                return false;
            };

            // add multi share button
            var btnMultiShare = videoObject.controlBar.addChild('button', {});
            btnMultiShare.addClass("facebookShare");
            var btnMultiShareDOM = btnMultiShare.el();
            btnMultiShareDOM.innerHTML = '<i class="fa-solid fa-share-nodes" style="font-size: 20px;" ></i>';
            btnMultiShareDOM.onclick = function () {
                $("#modalMultiShare").modal("show");
                return false;
            };
        }


        // remove picture mode & and hide full screen mode actual button
        $(".vjs-picture-in-picture-control").remove();
        $(".vjs-fullscreen-control").hide();

        if(playlist == 1)
        {
            // add full screen button at the last of all controls
            var btnPlaylist = videoObject.controlBar.addChild('button', {});
            btnPlaylist.addClass("playlist");
            var btnbtnPlaylistDOM = btnPlaylist.el();
            btnbtnPlaylistDOM.innerHTML = '<i class="fa-solid fa-list" style="font-size: 20px;"></i>';
            btnbtnPlaylistDOM.onclick = function () {
                if(loop_channel != 1)
                {
                    $(".vjs-playing").click();
                }
                $(".playlistContainer").css("right","0%");
                $(".playlistContainer").css("right","0%");
            }
        }

        // add full screen button at the last of all controls
        var btnFullScreen = videoObject.controlBar.addChild('button', {});
        btnFullScreen.addClass("vjs-fullscreen-control");
        var btnFullScreenDOM = btnFullScreen.el();
        btnFullScreenDOM.innerHTML = '<span aria-hidden="true" class="vjs-icon-placeholder"></span>';
        btnFullScreenDOM.onclick = function () {
            $(".vjs-fullscreen-control .vjs-control-text").click();
        }

        //  set video title
        if(title == 1)
        {
            setTimeout(function(){
                $(".vjs-text-track-display").append('<div id="videoTitle"><h5>'+titleName+'</h5></div>');
                setInterval(function () {
                    $("#videoTitle").remove();
                    $(".vjs-text-track-display").append('<div id="videoTitle"></div>');
                    $("#videoTitle").html("<h5>"+titleName+"</h5>");
                }, 500);
            }, 500);
        }

        // set controls show hide
        if(controls == 0)
        {
            if(autoplay == 0)
            {
                $(".vjs-big-play-button").css("display","block");
            }
            $(".vjs-tech").click(function(){
                var bigPlayBtnIsDiplay = $(".vjs-big-play-button").css("display");
                if(bigPlayBtnIsDiplay == "none")
                {
                    $(".vjs-paused").click();
                    $(".vjs-big-play-button").css("display","block");
                    $(".vjs-playing").click();
                }
            });
            $(".vjs-big-play-button").click(function(){
                var bigPlayBtnIsDiplay = $(".vjs-big-play-button").css("display");
                if(bigPlayBtnIsDiplay == "none")
                {
                    $(".vjs-paused").click();
                    $(".vjs-big-play-button").css("display","block");
                }
                else if(bigPlayBtnIsDiplay == "block")
                {
                    $(".vjs-playing").click();
                    $(".vjs-big-play-button").css("display","none");
                }
            });

            if(share == 1)
            {
                $("#btnSharesOnControlHide").show();
            }
            else
            {
                $("#btnSharesOnControlHide").hide();
            }
        }
        else
        {
            $("#btnSharesOnControlHide").hide();
        }

        // set multishare iframe
        fullLink = window.location.href;
        multiShareIframeHTML = "<iframe src='"+fullLink+"' width='640' height='360' frameborder='0' allow='autoplay' allowfullscreen></iframe>";
        $("#multiShareIframe").html(multiShareIframeHTML);

        // set facebook in multishare
        $("#btnFachbookMultiShare").click(function(){
            window.open('https://www.facebook.com/sharer/sharer.php?u={{ $videoUrl }}','facebook-share-dialog','width=800,height=600');
            return false;
        });

        // set twitter in multishare
        $("#btnTwitterMultiShare").click(function(){
            window.open('https://twitter.com/intent/tweet?text='+titleName+'&url={{ $videoUrl }}','facebook-share-dialog','width=800,height=600');
            return false;
        });

        // set facebook share in controls off mode
        $("#btnOutFacebookShare").click(function(){
            window.open('https://www.facebook.com/sharer/sharer.php?u={{ $videoUrl }}','facebook-share-dialog','width=800,height=600');
            return false;
        });

        // set twitter share in controls off mode
        $("#btnOutTwitterShare").click(function(){
            window.open('https://twitter.com/intent/tweet?text='+titleName+'&url={{ $videoUrl }}','facebook-share-dialog','width=800,height=600');
            return false;
        });

        //
        $("#btnOutMultiShare").click(function(){
            $("#modalMultiShare").modal("show");
            return false;
        });

        // function for copy to clipboeard
        function copyToClipboard(elem)
        {
            elem.focus();
            elem.select();
            document.execCommand("copy");
        }

        // add disabled handling
        if(disabled == 1)
        {
            $("#videoContainer").css("pointer-events","none");
            $(".vjs-big-play-button").css("display","none");
        }

        var logoVisiblity = parseInt($("#logoVisiblity").val());
        if(logoVisiblity == 1)
        {
            var logo = $("#logo").val();
            var logoPosition = $("#logoPosition").val();
            var logoLink = $("#logoLink").val();
            var logoPath = "{{ url('/uploads') }}" + "/" + logo;

            videoObject.watermark({
                file: logoPath,
                xpos: 0,
                ypos: 80,
                opacity: 0.5,
                clickable: true,
                url: logoLink,
            });

            if(logoPosition == "right")
            {
                $(".vjs-watermark img").css("right","3%");
            }
            else
            {
                $(".vjs-watermark img").css("left","3%");
            }
        }

        $(".btnPlaylistClose").click(function(){
            $(".playlistContainer").css("right","-30%");
        });

        function setSelectedVideo(videoUrl,videoName,Index)
        {
            linkAndExt = videoUrl.split(".");
            newVideoUrl = "{{ url('/uploads') }}" + "/" + videoUrl;
            var videoType = "video/mp4";
            if(linkAndExt[linkAndExt.length - 1] == "m3u8")
            {
                videoType = "application/x-mpegURL";
                newVideoUrl = videoUrl;
            }
            videoObject.src({"type":videoType, "src":newVideoUrl});
            videoObject.play();
            videoIndex = Index;
            titleName = videoName;
            $(".showVideoTime").attr("hidden",false);
            $(".nowPlaying").attr("hidden",true);
            $(".showVideoTime_"+Index).attr("hidden",true);
            $(".nowPlaying_"+Index).attr("hidden",false);
        }

        if(open_playlist == 1)
        {
            $(".playlist").click();
        }

        if(loop_channel == 1)
        {
            $(".vjs-progress-holder").css("display","none");
            $(".vjs-remaining-time").css("display","none");
            var onAirHTML = "<span style='color: red; font-size: 30px;margin-right: 5px;'>•</span> ON AIR";
            $(".vjs-progress-control").append(onAirHTML);
        }

        if(loop_channel == 1)
        {
            videoAnotherObj.onplay = function() {
                $(".vjs-big-play-button").css("display","none");
                if(controls == 0)
                {
                    videoObject.controls(0);
                    $("#btnSharesOnControlHide").show();
                }
                else
                {
                    videoObject.controls(1);
                }
            };
            videoAnotherObj.onpause = function() {
                $(".vjs-big-play-button").css("display","block");
                titleName = "";
                videoObject.controls(0);
                $("#btnSharesOnControlHide").hide();
            };
            $(".vjs-big-play-button").click(function(){
                var channelId = $("#channelId").val();
                $.ajax({
                    url: "{{ url('getCurrentVideoAndTime') }}",
                    type: "POST",
                    data: {
                        channelId: channelId,
                        _token: '{{ csrf_token() }}'
                    },
                    success:function(response)
                    {
                        var name = response['name'];
                        var url = response['url'];
                        var is_m3u8 = response['is_m3u8'];
                        var currentTime = response['currentTime'];
                        var videoType = "video/mp4";
                        var currentVideoIndex = response['videoIndex'];
                        if(is_m3u8 == 1)
                        {
                            videoType = "application/x-mpegURL";
                        }
                        videoObject.src({"type":videoType, "src":url});
                        titleName = name;
                        setTimeout(function(){
                            videoObject.play();
                            videoAnotherObj.currentTime = currentTime;
                        }, 500);
                        videoIndex = currentVideoIndex;
                        $(".nowPlaying").attr("hidden",true);
                        $(".showVideoTime").attr("hidden",false);
                        $(".showVideoTime_"+currentVideoIndex).attr("hidden",true);
                        $(".nowPlaying_"+currentVideoIndex).attr("hidden",false);

                        $.ajax({
                            url:"{{ url('loopChannelDynamicPlaylist') }}",
                            method:"POST",
                            data: {
                                channelId: channelId,
                                _token: '{{ csrf_token() }}'
                            },
                            success:function(htmlResponse)
                            {
                                $(".assinedVideosContainer").html(htmlResponse);
                            }
                        });
                    }
                });
            });
            var channelId = $("#channelId").val();
            $.ajax({
                url: "{{ url('getCurrentVideoAndTime') }}",
                type: "POST",
                data: {
                    channelId: channelId,
                    _token: '{{ csrf_token() }}'
                },
                success:function(response)
                {
                    var name = response['name'];
                    var url = response['url'];
                    var is_m3u8 = response['is_m3u8'];
                    var currentTime = response['currentTime'];
                    var videoType = "video/mp4";
                    if(is_m3u8 == 1)
                    {
                        videoType = "application/x-mpegURL";
                    }
                    videoObject.src({"type":videoType, "src":url});
                    titleName = "";
                    $("#btnSharesOnControlHide").hide();
                }
            });
        }
    </script>
</body>
</html>
