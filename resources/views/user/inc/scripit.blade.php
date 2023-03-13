 <!-- jQuery -->
 <script src="{{ asset('admin_assets/assets/js/jquery-3.2.1.min.js') }}"></script>

 <!-- Bootstrap Core JS -->
 <script src="{{ asset('admin_assets/assets/js/popper.min.js') }}"></script>
 <script src="{{ asset('admin_assets/assets/js/bootstrap.min.js') }}"></script>

 <!-- Slimscroll JS -->
 <script src="{{ asset('admin_assets/assets/js/jquery.slimscroll.min.js') }}"></script>

 <!-- Chart JS -->
 <script src="{{ asset('admin_assets/assets/plugins/morris/morris.min.js') }}"></script>
 <script src="{{ asset('admin_assets/assets/plugins/raphael/raphael.min.js') }}"></script>
 {{-- <script src="{{ asset('admin_assets/assets/js/chart.js') }}"></script> --}}

 <!-- Custom JS -->

 <script src="{{ asset('admin_assets/assets/js/moment.min.js') }}"></script>

 <script src="{{ asset('admin_assets/assets/js/app.js') }}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/1.1.6/choices.min.js"></script>
 <script src="{{ asset('admin_assets/assets/js/select2.min.js') }}"></script>

 <script>

    $('#ChanelList tr:first-child td:first-child').click();
    function GetChannelVideos(id,channel_name,channel_type)
    {
        var channel_id = id;
        var day = "all";
        $("#channelId").val(channel_id);
        $('#AddVideoButton').removeAttr('onclick');
        $('#AddVideoButton').attr('onclick', 'OpenVideosModel('+id+');');
        var video_rows = "";
        $.ajax({
            url: "{{ url('/channel_detail') }}",
            type: "POST",
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data)
            {
                video_rows = "";
                video_url = "";
                video_decimal_count = 0;
                if(channel_type == "ondemand")
                {
                    $("#AddVideoButton").show();
                    $("#ScheduleVideoButton").hide();
                    $("#ChannelTypeLogo").html('<i class="fa fa-list-ul text-blue"  style="font-size: 1.5em; padding-left: 10px; float: left; padding-top: 6px;"></i>');
                }
                else if(channel_type == "linear_looped")
                {
                    $("#AddVideoButton").show();
                    $("#ScheduleVideoButton").hide();
                    $("#ChannelTypeLogo").html('<i class="fa fa-repeat text-success"  style="font-size: 1.5em; padding-left: 10px; float: left; padding-top: 6px;"></i>');
                }
                else if(channel_type == "linear_schedule")
                {
                    if(data['channel'].scheduledDuration == 1)
                    {
                        $("#scheduleDays").prop("hidden",true);
                    }
                    else
                    {
                        $("#scheduleDays").prop("hidden",false);
                    }

                    if(data['channel'].scheduledDuration == 0)
                    {
                        day = $("#scheduleDays").val();
                    }

                    getScheduledVideosOfSpecificChannel(id,day);

                    $("#AddVideoButton").hide();
                    $("#ScheduleVideoButton").show();
                    $("#ScheduleVideoButton").prop("href","{{ url('/scheduleVideo') }}/"+channel_id);
                    $("#ChannelTypeLogo").html('<i class="fas fa-calendar-alt"  style="font-size: 1.5em; padding-left: 10px; float: left; padding-top: 6px;color: #FFBF00"></i>');
                }
                $("#ChannelName").html(channel_name);
                var total_videos = parseInt($("#total_videos").val());
                for (let i = 1; i <= total_videos; i++)
                {
                    $("#chk_video_id_avl_"+i).prop("checked",false)
                }
                for(var i = 0; i < data['videos'].length; i++)
                {
                    video_decimal_count = i+1;
                    video_id = parseInt(data['videos'][i].id);
                    if(parseInt(data['videos'][i].is_mtu8) == 1)
                    {
                        video_url = data['videos'][i].image_url;
                    }
                    else
                    {
                        video_url = data['videos'][i].image_url;
                    }
                    if(channel_type == "ondemand")
                    {
                        embed_video_button = '<a href="javascript:void(0)" type="button" onclick="OpenEmbedVideoModal(&#39;'+video_url+'&#39;,&#39;'+channel_id+'&#39;)"  name="embeded_video" class="btn btn-sm btn-primary"><i class="la la-code"></i></a>';
                    }
                    else if(channel_type == "linear_looped")
                    {
                        embed_video_button = "";
                    }
                    video_rows += '<tr draggable="true" ondragstart="start()" ondragover="dragover()"><td style="width: 17%;"><div><ul style="list-style: none;padding-left: 0px;float: left;"><li><span class="fa fa-angle-up" style="float:left;"></span></li><li><span class="fa fa-angle-down" style="float:left;"></span></li></ul></div><video width="50" height="30" style="float:right;border: 0.5px solid lightgray;"><source src="'+video_url+'" type="video/mp4"></video></td><td><span class="videosOrder">'+video_decimal_count+'. </span> <input type="hidden" class="videosOrderInput" value="'+video_id+'" /> '+data['videos'][i].name+'</td><td>'+embed_video_button+'<a href="{{ url("/channel/delete_video/") }}/'+channel_id+'/'+video_id+'" type="button" class="btn btn-sm btn-primary ml-2"><i class="la la-trash"></i></a></td></tr>';
                    if(i == 0)
                    {
                        $("#EmbedVideoSource").val(video_url);
                    }
                }
                $("#VideoListAccordingToChannel").html(video_rows);
            }
        });

    }

    function getScheduledVideosOfSpecificChannel(channelId,day)
    {
        jQuery.ajax({
            url:"getScheduledVideosOfSpecificChannel",
            method:"POST",
            data:{
                _token:"{{ csrf_token() }}",
                channelId:channelId,
                day:day
            },
            success:function(response)
            {
                var videosHtml = '';
                if(response != 0)
                {
                    for(var i = 0; i < response.length; i++)
                    {
                        count = i+1;
                        var videoUrl = '{{ url("uploads/") }}/' + response[i]['video_url'];
                        videosHtml += '<tr>';
                        videosHtml += '<td style="width: 17%;"><div><ul style="list-style: none;padding-left: 0px;float: left;"><li><span class="fa fa-angle-up" style="float:left;"></span></li><li><span class="fa fa-angle-down" style="float:left;"></span></li></ul></div><video width="50" height="30" style="float:right;border: 0.5px solid lightgray;"><source src="'+videoUrl+'" type="video/mp4"></video></td>';
                        videosHtml += '<td><span class="videosOrder">'+count+'. ' + response[i]['video_title'] + ' </span> <div style="color:#ff9b44;"> ' + response[i]['schedule_time'] + ' - ' + response[i]['end_time'] + ' </div> </td>';
                        videosHtml += '</tr>';
                    }
                }
                $("#VideoListAccordingToChannel").html(videosHtml);
            }
        });
    }

    function myFunction() {
        var copyText = document.getElementById("EmbedCode");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
    }
    function CopyEmbedCode() {
        var copyText = document.getElementById("EmbedCode");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
    }
     $(document).ready(function() {

        // var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        //     removeItemButton: true,
        //     maxItemCount: 5,
        //     searchResultLimit: 5,
        //     renderChoiceLimit: 5
        // });

     });
     var $window = $(window);
     var nav = $('.fixed-button');
     $window.scroll(function() {
         if ($window.scrollTop() >= 200) {
             nav.addClass('active');
         } else {
             nav.removeClass('active');
         }
     });

     $("#popup").hide();
     $("#tag_modal").hide();
     $("#EmbededVideoPopup").hide();
     $("#EditVideoPopup").hide();
     $('#edit_name').empty();
     $(".ModalCloseButton").click(function() {
        $("#popup").hide();
        $("#EmbededVideoPopup").hide();
        $("#EditVideoPopup").hide();
     });

    function OpenVideo(url_link, id) {
        $.ajax({
            url: "{{ url('edit_data_ajax') }}",
            type: "POST",
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $('.edit_video_id').val(data.video.id);
                $('.edit_video_name').val(data.video.name);
                $('#edit_video_tag').html('');
                if (data.video.tag != null && data.video.tag != "") {
                    var tags = JSON.parse(data.video.tag);
                    for (var i = 0; i < data.all_tags.length; i++) {
                        if(tags.includes(data.all_tags[i].tag))
                        {
                            $('#edit_video_tag').append("<option value='" + data.all_tags[i].tag + "' selected>" + data.all_tags[i].tag + "</option>");
                        }
                        else
                        {
                            $('#edit_video_tag').append("<option value='" + data.all_tags[i].tag + "'>" + data.all_tags[i].tag + "</option>");
                        }
                    }
                }
            }
        });
        var iframeSrc = "{{ url('/') }}/embed?url="+url_link+"&autoplay=0&volume=1&controls=1&title=0&share=1&open_playlist=1&disabled=0";
        var videoPreviewModalBodyHTML = '<iframe src="'+iframeSrc+'"width="640" height="360" title="MediaPro Video" allowfullscreen="true" frameBorder="0"> </iframe>';
        $("#popup").show();
        $(".VideoContainer").html(videoPreviewModalBodyHTML);

    }

    function addTagVideo(url_link, id)
    {
        $.ajax({
            url: "{{ url('add_tag_ajax') }}",
            type: "POST",
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data)
            {
                $("#add_video_tag").html();
                var tagsHTML = "";
                $('.edit_video_id').val(data.video.id);
                $('.edit_video_name').val(data.video.name);
                if (data.video.tag != null && data.video.tag != "")
                {
                    var tags = JSON.parse(data.video.tag);
                    for(var i = 0; i < data.all_tags.length; i++)
                    {
                        if(tags.includes(data.all_tags[i].tag))
                        {
                            tagsHTML += '<option value="'+data.all_tags[i].tag+'" selected>'+data.all_tags[i].tag+'</option>';
                        }
                        else
                        {
                            tagsHTML += '<option value="'+data.all_tags[i].tag+'">'+data.all_tags[i].tag+'</option>';
                        }
                    }
                }
                $("#add_video_tag").html(tagsHTML);
            }
        });
        $("#popup").show();
        $(".VideoContainer").html('<video width="700" height="300" controls><source src="' + url_link + '" type="video/mp4">Your browser does not support the video tag.</video>');
    }

     function OpenEmbededVideoModal(url_link) {
         var id = event.target.id;
         $.ajax({
             headers: {
                 'X-CSRF-TOKEN': "{{ csrf_token() }}",
             },
             url: "{{ route('edit_data_ajax') }}",
             type: "POST",
             data: {

                 edit_id: id,
             },
             success: function(response) {
                 $('#vedio_id_id').val(response.id);
                 $('#vedio_name_name').val(response.name);

             }
         });
         $(".VideoContainer").html('<video width="700" height="300" controls><source id="MyVideoSource" src="' +
             url_link +
             '" type="video/mp4">Your browser does not support the video tag.</video>');

     }
     $("#OnDemandButton").click(function() {
         $(".FirstSection").show();
     });
     $("#OnDemandButton").click(function() {
         $(".FirstSection").hide();
     });
     $("#LinearButton").click(function() {
         $(".SecondSection").show();
     });
     $("#OnDemandButton").click(function() {
         $(".SecondSection").hide();
     });

     $(".js-example-tokenizer").select2({
         tags: true,
         tokenSeparators: [',', ' ']
     })

     function Open_tag_modal(id) {
         alert(id);
     }

     function ChangeProperty() {
         var ratio = $("#aspect-ratio").val();
         if (ratio == '16:9') {
             padding = 56.25;
         }
         if (ratio == '4:3') {
             padding = 75;
         }
         if (ratio == '1:1') {
             padding = 100;
         }

         // id="aspect-ratio"
         //Volume
         var IsVolChecked = $("#VolumeCheck").prop("checked");
         var VolValue = 0;
         //Autoplay
         var Autoplay = $("#AutoplayCheck").prop("checked");
         var AutoplayVal = 0;
         //showcontrol
         var showcontrol = $("#ShowControl").prop("checked");
         var ShowControlVal = 0;
         //   ShowContentTitle
         var showcontent = $("#ShowContentTitle").prop("checked");
         var ShowContentVal = 0;
         //   Show share buttons
         var showsharebutton = $("#ShowShareButtons").prop("checked");
         var ShowShareButtonVal = 0;

         var VideoSource = $("#MyVideoSource").prop("src");
         // var is_select_aspectRatio = $('#aspect-ratio').prop("selected");
         // var aspectratio = this.val(is_select_aspectRatio);
         if (showsharebutton == true) {
             ShowShareButtonVal = 1;
         }
         if (showcontent == true) {
             ShowContentVal = 1;
         }
         if (showcontrol == true) {
             ShowControlVal = 1;
         }
         if (Autoplay == true) {
             AutoplayVal = 1;
         }

         if (IsVolChecked == true) {
             VolValue = 1;
         }
         $("#EmbedCode").html("<div style='position: relative; padding-bottom: " + padding +
             "%; height: 0;'><iframe src=" +
             VideoSource + "?autoplay=" + AutoplayVal + "&volume=" + VolValue + "&controls=" + ShowControlVal +
             "&title=" + ShowContentVal + "&share=" + ShowShareButtonVal +
             "&open_playlist=0' style='position: absolute; top: 0; left: 0; width: 100%; height: 100%;' frameborder='0' allow='autoplay' allowfullscreen></iframe></div>"
         );
     }


    function checkChooseDomain()
    {
        var is_checked = $("#choose_domain").prop("checked");
        if(is_checked)
        {
            $("#domain_name").show();
            $("#anywhere").prop("checked",false);
        }
        else
        {
            $("#domain_name").hide();
            $("#anywhere").prop("checked",true);
        }
    }
    $("#choose_domain").click(function(){
        checkChooseDomain();
    });
    checkChooseDomain();

    $("#LinearLoopedFormSubmit").click(function(){
        var IsAnywhereChecked = $("#anywhere").prop("checked");
        var IsDoaminChecked = $("#choose_domain").prop("checked");
        if(IsAnywhereChecked == false && IsDoaminChecked == false)
        {
            $("#PrivacySettingsValidation").html("Select atleast one option in Privacy Settings.");
            return false;
        }
        else
        {
            $("#PrivacySettingsValidation").html("");
        }
    });

    $("#OnDemandFormSubmit").click(function(){
        var IsAnywhereChecked = $("#anywhere").prop("checked");
        var IsDoaminChecked = $("#choose_domain").prop("checked");
        if(IsAnywhereChecked == false && IsDoaminChecked == false)
        {
            $("#PrivacySettingsValidation").html("Select atleast one option in Privacy Settings.");
            return false;
        }
        else
        {
            $("#PrivacySettingsValidation").html("");
        }
    });

    $("#LinearSchduledFormSubmit").click(function(){
        var IsAnywhereChecked = $("#anywhere").prop("checked");
        var IsDoaminChecked = $("#choose_domain").prop("checked");
        if(IsAnywhereChecked == false && IsDoaminChecked == false)
        {
            $("#PrivacySettingsValidation").html("Select atleast one option in Privacy Settings.");
            return false;
        }
        else
        {
            $("#PrivacySettingsValidation").html("");
        }
    });
    scheduleDuration();
    $("#schedule").change(function(){
        scheduleDuration();
    });

    function scheduleDuration()
    {
        let schedule = $("#schedule").val();
        if(schedule != null && schedule != "")
        {
            schedule = parseInt(schedule);
            if(schedule == 0)
            {
                $("#info").html("You will schedule a whole week 24/7 and content will be repeated weekly");
            }
            else if(schedule == 1)
            {
                $("#info").html("You will schedule one day (24 hours) and content will be repeated daily");
            }
            else
            {
                $("#info").html("");
            }
        }
    }

    const dt = new DataTransfer();
    $("#file").on('change', function(e){
        for(var i = 0; i < this.files.length; i++){
            const urlSerial = URL.createObjectURL(this.files[i]);
            const thumbUrl =  getThumbnailForVideo(urlSerial);
            console.log(thumbUrl);
            fileNo = i+1;
            let fileBloc = $('<span/>', {class: 'file-block'}),
            fileName = $('<span/>', {class: 'name', text: this.files.item(i).name});
            // if(this.files.item(i).size > 5000000)
            // {
            //     Size = parseFloat(this.files.item(i).size) / parseFloat(1000000);
            //     fileSize = "<span class='size text-danger pl-2'>"+Size+" Mbs</span>";
            // }
            // else
            // {
            // }
            Size = (parseFloat(this.files.item(i).size)) / parseFloat(1049000);
            Size = Size.toFixed(2);
            fileSize = "<span class='size text-success pl-2 pt-1'>"+Size+" Mbs</span>";
            btnWaterMark = "<div class='add-watermark' style='border-radius:none;' onclick='SelectWaterMark("+fileNo+")'>Watermark</div>";
            fileWaterMark = "<input type='file' class='file-watermark-"+fileNo+"' name='file-watermark-"+fileNo+"' id='file-watermark-"+fileNo+"' style='display:none;' onchange='ValidateSingleInput(this);' />";

            fileBloc.append('<span class="file-delete"><span>x</span></span>').append(fileName).append(fileSize);
            $("#filesList > #files-names").append(fileBloc);
        };
        // Ajout des fichiers dans l'objet DataTransfer
        for (let file of this.files) {
            dt.items.add(file);
        }
        // Mise à jour des fichiers de l'input file après ajout
        this.files = dt.files;

        // EventListener pour le bouton de suppression créé
        $('span.file-delete').click(function(){
            let name = $(this).next('span.name').text();
            // Supprimer l'affichage du nom de fichier
            $(this).parent().remove();
            for(let i = 0; i < dt.items.length; i++){
                // Correspondance du fichier et du nom
                if(name === dt.items[i].getAsFile().name){
                    // Suppression du fichier dans l'objet DataTransfer
                    dt.items.remove(i);
                    continue;
                }
            }
            // Mise à jour des fichiers de l'input file après suppression
            document.getElementById('file').files = dt.files;
        });
    });

    function getThumbnailForVideo(videoUrl)
    {
        const video = document.createElement("video");
        const canvas = document.createElement("canvas");
        video.style.display = "none";
        canvas.style.display = "none";


        video.addEventListener("loadedmetadata", () => {
            video.width = video.videoWidth;
            video.height = video.videoHeight;
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            // Seek the video to 25%
            video.currentTime = video.duration * 0.25;
        });
        // video.addEventListener("seeked", () => resolve());
        video.src = videoUrl;


        // Draw the thumbnailz
        canvas
            .getContext("2d")
            .drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
        const imageUrl = canvas.toDataURL("image/png");
        return imageUrl;
    }

    $("#anywhere").click(function(){
        var is_checked = $("#anywhere").prop("checked");
        if(is_checked)
        {
            $("#domain_name").hide();
            $("#choose_domain").prop("checked",false);
        }
        else
        {
            $("#domain_name").show();
            $("#choose_domain").prop("checked",true);
        }
    });

    function SelectWaterMark(video_no)
    {
        alert(video_no);
        $("#file-watermark-"+video_no).click();
    }
    var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
    function ValidateSingleInput(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }

                if (!blnValid) {
                    alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                    oInput.value = "";
                    return false;
                }
            }
        }
        return true;
    }

    $('#VideoListingOnChannelPanel tr').click(function(event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    });

    $('#ChanelList tr').click(function(event) {
        $('#ChanelList tr.active').removeClass('active');
        $(this).addClass('active');
    });

    $("#ChanelList tr:first-child td").click();

    function SetEmbedChannel()
    {
        var EmbedType = $("#EmbedType").val();
        var EmbedVideoSource =  $("#EmbedVideoSource").val();
        var channelId = $("#channelId").val();
        var ratio = $("#aspect-ratio").val();
        if (ratio == '16:9') {
            padding = 56.25;
        }
        else if (ratio == '4:3') {
            padding = 75;
        }
        else if (ratio == '1:1') {
            padding = 100;
        }
        else {
            padding = 0;
        }

        var IsVolChecked = $("#VolumeCheck").prop("checked");
        var VolValue = 0;
        //Autoplay
        var Autoplay = $("#AutoplayCheck").prop("checked");
        var AutoplayVal = 0;
        //showcontrol
        var showcontrol = $("#ShowControl").prop("checked");
        var ShowControlVal = 0;
        //ShowContentTitle
        var showcontent = $("#ShowContentTitle").prop("checked");
        var ShowContentVal = 0;
        //Show share buttons
        var showsharebutton = $("#ShowShareButtons").prop("checked");
        var ShowShareButtonVal = 0;
        //Open playlist onload
        var Playlist = $("#PlaylistMode").prop("checked");
        var PlaylistVal = 0;
        //Open playlist onload
        var OpenPlaylist = $("#OpenPlaylist").prop("checked");
        var OpenPlaylistVal = 0;
        var VideoSource = $("#EmbedVideoSource").val();
        if (showsharebutton == true) {
            ShowShareButtonVal = 1;
        }
        if (showcontent == true) {
            ShowContentVal = 1;
        }
        if (showcontrol == true) {
            ShowControlVal = 1;
        }
        if (Autoplay == true) {
            AutoplayVal = 1;
        }
        if (IsVolChecked == true) {
            VolValue = 1;
        }
        if (Playlist == true) {
            PlaylistVal = 1;
        }
        if (OpenPlaylist == true) {
            OpenPlaylistVal = 1;
        }
        if(EmbedType == "channel")
        {
            PlaylistVal = 1;
        }
        var code_type = $("#CodeType").val();
        var Pixel1 = $("#Pixel1").val();
        var Pixel2 = $("#Pixel2").val();

        if(code_type == "Responsive")
        {
            var iframeSrc = "{{ url('/') }}/embed/"+channelId+"?url="+EmbedVideoSource+"&autoplay="+AutoplayVal+"&volume="+VolValue+"&controls="+ShowControlVal+"&title="+ShowContentVal+"&share="+ShowShareButtonVal+"&playlist="+PlaylistVal+"&open_playlist="+OpenPlaylistVal;
            var ResponsiveCodeHTML = '<div style="position: relative; padding-bottom: '+padding+'%; height: 0;"><iframe src="'+iframeSrc+'"width="100%" height="100%" frameborder="0" allow="autoplay" allowfullscreen style="position:absolute;"> </iframe></div>';
            $("#EmbedCode").html(ResponsiveCodeHTML);
            $("#EmbedVideoContainer").html(ResponsiveCodeHTML);
        }
        else if(code_type == "Fixed")
        {
            var iframeSrc = "{{ url('/') }}/embed/"+channelId+"?url="+EmbedVideoSource+"&autoplay="+AutoplayVal+"&volume="+VolValue+"&controls="+ShowControlVal+"&title="+ShowContentVal+"&share="+ShowShareButtonVal+"&playlist="+PlaylistVal+"&open_playlist="+OpenPlaylistVal;
            var ResponsiveCodeHTMLForPreview = '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="'+iframeSrc+'"width="100%" height="100%" frameborder="0" allow="autoplay" allowfullscreen style="position:absolute;"> </iframe></div>';
            var ResponsiveCodeHTMLForDesigning = '<iframe src="'+iframeSrc+'" width="'+Pixel1+'" height="'+Pixel2+'" frameborder="0" allow="autoplay" allowfullscreen> </iframe>';
            $("#EmbedCode").html(ResponsiveCodeHTMLForDesigning);
            $("#EmbedVideoContainer").html(ResponsiveCodeHTMLForPreview);
        }
    }

    function OpenEmbedChannelModal(channelId)
    {
        channelId = parseInt(channelId);
        $("#EmbedType").val("channel");
        $("#OpenPlaylistContainer").prop("hidden",false);
        $("#OpenPlaylist").prop("checked",false);
        $("#PlaylistModeContainer").prop("hidden",true);
        $("#PlaylistMode").prop("checked",false);
        $("#ResponsiveTab").click();
        $("#aspect-ratio").val("16:9").change();
        $("#AutoplayCheck").prop("checked",false);
        $("#VolumeCheck").prop("checked",true);
        $("#ShowControl").prop("checked",true);
        $("#ShowContentTitle").prop("checked",true);
        $("#ShowShareButtons").prop("checked",true);
        $("#Pixel1").val(640);
        $("#Pixel2").val(360);
        var EmbedVideoSource = $("#EmbedVideoSource").val();
        var iframeSrc = "{{ url('/') }}/embed/"+channelId+"?url="+EmbedVideoSource+"&autoplay=0&volume=1&controls=1&title=1&share=1&playlist=1&open_playlist=0&disabled=0";
        var EmbedVideoContainerHTML = '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="'+iframeSrc+'"width="100%" height="100%" frameborder="0" allow="autoplay" allowfullscreen style="position:absolute;"> </iframe></div>';
        $("#EmbedCode").html(EmbedVideoContainerHTML)
        $("#EmbedVideoContainer").html(EmbedVideoContainerHTML);
        $("#EmbedModalTitle").html("Preview & Embed Channel");
        $("#embed_channel").modal("show");
    }

    function OpenEmbedVideoModal(EmbedVideoSource,channelId)
    {
        channelId = parseInt(channelId);
        $("#EmbedVideoSource").val(EmbedVideoSource);
        if(channelId == 0)
        {
            $("#EmbedType").val("video");
        }
        else
        {
            $("#EmbedType").val("videoWithChannel");
        }
        $("#ResponsiveTab").click();
        $("#aspect-ratio").val("16:9").change();
        $("#AutoplayCheck").prop("checked",false);
        $("#VolumeCheck").prop("checked",true);
        $("#ShowControl").prop("checked",true);
        $("#ShowContentTitle").prop("checked",true);
        $("#ShowShareButtons").prop("checked",true);
        $("#Pixel1").val(640);
        $("#Pixel2").val(360);
        $("#PlaylistModeContainer").prop("hidden",false);
        $("#PlaylistMode").prop("checked",false);
        $("#OpenPlaylistContainer").prop("hidden",true);
        $("#OpenPlaylist").prop("checked",false);
        var iframeSrc = "{{ url('/') }}/embed/"+channelId+"?url="+EmbedVideoSource+"&autoplay=0&volume=1&controls=1&title=1&share=1&playlist=0&open_playlist=0&disabled=0";
        var EmbedVideoContainerHTML = '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="'+iframeSrc+'"width="100%" height="100%" frameborder="0" allow="autoplay" allowfullscreen style="position:absolute;"> </iframe></div>';
        $("#EmbedCode").html(EmbedVideoContainerHTML)
        $("#EmbedVideoContainer").html(EmbedVideoContainerHTML);
        $("#EmbedModalTitle").html("Embed Video");
        $("#embed_channel").modal('show');
    }

    $("#ResponsiveTab").click(function(){
        $("#CodeType").val("Responsive");
        SetEmbedChannel();
    });

    $("#FixedTab").click(function(){
        $("#CodeType").val("Fixed");
        SetEmbedChannel();
    });

    function validURL(str)
    {
        var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
        '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
        return !!pattern.test(str);
    }
    $("#addM3u8LinkBtn").click(function(){
        var m3u8Link = $("#m3u8Link").val();
        urlValidity = validURL(m3u8Link);
        if(urlValidity == true)
        {
            let URL = m3u8Link;
            let xhr = new XMLHttpRequest();
            xhr.open('HEAD', m3u8Link, true);
            xhr.onload = function() {
                let contentType = xhr.getResponseHeader('Content-Type');
                if (contentType == 'application/x-mpegURL')
                {
                    $("#incorrectM3u8Url").html("");
                    $("#addM3u8LinkForm").submit();
                    return true;
                }
                else
                {
                    $("#incorrectM3u8Url").html("Stream not found or not supported!");
                    return false;
                }
            }
            xhr.send();
            $("#incorrectM3u8Url").html("Stream not found or not supported!");
            return false;
        }
        else
        {
            $("#incorrectM3u8Url").html('Insert a valid URL, example: "https://yourcdn.com/video.m3u8".');
            return false;
        }
    });


    function OpenVideoPreview(videoUrl){
        var iframeSrc = "{{ url('/') }}/embed?url="+videoUrl+"&autoplay=0&volume=1&controls=1&title=0&share=1&open_playlist=1&disabled=0";
        var videoPreviewModalBodyHTML = '<iframe src="'+iframeSrc+'"width="640" height="360" title="MediaPro Video" allowfullscreen="true" frameBorder="0"> </iframe>';
        $("#videoPreviewModalBody").html(videoPreviewModalBodyHTML);
        $("#videoPreviewModal").modal("show");
    }

    $("#submitVideosForm").click(function(){
        $("#videosForm").css("opacity","0");
        $("#UploadingLoader").css("display","flex");
        $(".file-delete").css("pointer-events","none");
        $(".file-block").css("cursor","not-allowed");
    });


    $("#videoPreviewModalCloseBtn").click(function(){
        $("#videoPreviewModalBody").html("");
    });

    $("#LinearTabButton").click(function(){
        $("#LinearScheduledTabButton").click();
        $("#LoopedNextButton").prop("href","{{ url('/linear_scheduled') }}");
    });

    $("#LinearScheduledTabButton").click(function(){
        $("#LoopedNextButton").prop("href","{{ url('/linear_scheduled') }}");
    });

    $("#LinearLoopedTabButton").click(function(){
        $("#LoopedNextButton").prop("href","{{ url('/looped') }}");
    });

    $("#toggleLogo").click(function(){
        var isLogoChecked = $("#toggleLogo").prop("checked");
        if(isLogoChecked)
        {
            setLogoOnOff();
        }
        else
        {
            setLogoOnOff();
        }
    });

    $("#watermarkPreview").click(function(){
        $("#watermarkLogo").click();
    });
    $("#btnUploadLogo").click(function(){
        $("#watermarkLogo").click();
    });

    var loadFile = function(event) {
        var fileInput = document.getElementById('watermarkLogo');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if(!allowedExtensions.exec(filePath)){
            alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
            fileInput.value = '';
            $("#output").prop("src","");
            return false;
        }
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src)
        }

        var previewWatermarkInVideo = document.getElementById('previewWatermarkInVideo');
        previewWatermarkInVideo.src = URL.createObjectURL(event.target.files[0]);
        previewWatermarkInVideo.onload = function() {
            URL.revokeObjectURL(previewWatermarkInVideo.src)
        }
    };

    setLogoOnOff();

    function setLogoOnOff()
    {
        var isLogoChecked = $("#toggleLogo").prop("checked");
        if(isLogoChecked)
        {
            $(".switch-title").css("left","5px");
            $(".switch-title").html("ON");
            $(".switch-title").css("color","white");
            $("#logoLink").prop("disabled",false);
            $("#logoPositionLeft").prop("disabled",false);
            $("#logoPositionRight").prop("disabled",false);
            $("#watermarkLogo").prop("disabled",false);
            $("#btnUploadLogo").removeClass("btn-secondary");
            $("#btnUploadLogo").addClass("btn-primary");
            $("#previewWatermarkInVideo").show();
        }
        else
        {
            $(".switch-title").css("left","20px");
            $(".switch-title").html("OFF");
            $(".switch-title").css("color","darkslategrey");
            $("#logoLink").prop("disabled",true);
            $("#logoPositionLeft").prop("disabled",true);
            $("#logoPositionRight").prop("disabled",true);
            $("#watermarkLogo").prop("disabled",true);
            $("#btnUploadLogo").removeClass("btn-primary");
            $("#btnUploadLogo").addClass("btn-secondary");
            $("#previewWatermarkInVideo").hide();
        }
    }


    var logoPositionLeft = $("#logoPositionLeft").val();
    $("#hiddenLogoPosition").val(logoPositionLeft);

    $("#logoPositionRight").click(function(){
        var logoPositionRight = $("#logoPositionRight").val();
        $("#hiddenLogoPosition").val(logoPositionRight);
        $("#previewWatermarkInVideo").css("left","81%");
    });

    $("#logoPositionLeft").click(function(){
        var logoPositionLeft = $("#logoPositionLeft").val();
        $("#hiddenLogoPosition").val(logoPositionLeft);
        $("#previewWatermarkInVideo").css("left","3%");
    });

    $("#previewWatermarkInVideo").click(function(){
        var logoLink = $("#logoLink").val();
        if(logoLink != null && logoLink != "")
        {
            window.open(logoLink, '_blank');
        }
    });


    $("#scheduleDays").change(function(){
        var day = $("#scheduleDays").val();
        var channelId = $("#channelId").val();
        getScheduledVideosOfSpecificChannel(channelId,day);

    });

 </script>
