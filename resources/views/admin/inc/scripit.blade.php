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
 <script src="{{ asset('admin_assets/assets/js/chart.js') }}"></script>

 <!-- Custom JS -->

 <script src="{{ asset('admin_assets/assets/js/moment.min.js') }}"></script>

 <script src="{{ asset('admin_assets/assets/js/app.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script>
     // $(document).ready(function(){
     //     $(function(){
     //        $("form").ajaxForm({
     //            beforeSend:function(){
     //             $(".progress-bar").css("display","");
     //             var percentVal = "0%";
     //             $(".bar")
     //            },
     //            uploadProgress:function{},
     //            complete:function(){}
     //        });
     //     });
     // });
     //
     $(function() {
         $('.toggle-class').change(function() {
             var status = $(this).prop('checked') == true ? 1 : 0;
             var user_id = $(this).data('id');

             $.ajax({
                 type: "GET",
                 dataType: "json",
                 url: '/changeStatus',
                 data: {
                     'status': status,
                     'user_id': user_id
                 },
                 success: function(data) {
                     console.log(data.success)
                 }
             });
         })
     })
     $('body').on('keyup', '#search-posts', function() {
         var searchvideo = $(this).val();
         $.ajax({
             method: 'POST',
             type: 'POST',
             url: '{{ url('search-videos') }}',
             dataType: 'json',
             data: {
                 _token: '{{ csrf_token() }}',
                 searchvideo: searchvideo,
             },
             success: function(response) {
                 console.log(response);
                 $('#dynamic-row').html("");
                 for (var i = 0; i < response.length; i++) {
                     $('#dynamic-row').append(response[i]);
                     console.log(response[i]);
                 }
                 // alert();

                 // var container = '';
                 // $('#dynamic-row').html(response);
                 // $.each(response, function(index, value) {
                 //     div = '';
                 //
                 // });
             }
         });
     });

     $('body').on('keyup', '#search-posts-tag', function() {
         var searchvideo = $(this).val();
         $.ajax({
             method: 'POST',
             url: '{{ url('search-videos_by_tag') }}',
             dataType: 'json',
             data: {
                 _token: '{{ csrf_token() }}',
                 searchvideo: searchvideo,
             },
             success: function(response) {
                 console.log(response);
                 $('#dynamic-row').html("");
                 for (var i = 0; i < response.length; i++) {
                     $('#dynamic-row').append(response[i]);
                     console.log(response[i]);
                 }
                 // alert();

                 // var container = '';
                 // $('#dynamic-row').html(response);
                 // $.each(response, function(index, value) {
                 //     div = '';
                 //
                 // });
             }
         });
     });

     function myFunction() {
         // Get the text field
         var copyText = document.getElementById("EmbedCode");

         // Select the text field
         copyText.select();
         copyText.setSelectionRange(0, 99999);

         // Copy the text inside the text field
         navigator.clipboard.writeText(copyText.value);

         // Alert the copied text

     }
     $(document).ready(function() {

         var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
             removeItemButton: true,
             maxItemCount: 5,
             searchResultLimit: 5,
             renderChoiceLimit: 5
         });


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
         console.log(id);
         $.ajax({
             url: "{{ url('edit_data_ajax') }}",
             type: "POST",
             data: {
                 id: id,
                 _token: '{{ csrf_token() }}'
             },
             success: function(data) {
                 $('.edit_video_id').val(data.id);
                 $('.edit_video_name').val(data.name);
                 $('.edit_video_tag').html('');
                 if (data.tag != null && data.tag != "") {
                     var tags = data.tag.split('"');
                     for (var i = 0; i < tags.length; i++) {
                         if ((i % 2) != 0) {
                             $('.edit_video_tag').append("<option value='" + tags[i] +
                                 "' selected>" + tags[i] + "</option>");
                         }
                     }
                 }
             }
         });
         $("#popup").show();
         $(".VideoContainer").html('<video width="700" height="300" controls><source src="' + url_link +
             '" type="video/mp4">Your browser does not support the video tag.</video>');

     }

     function addTagVideo(url_link, id) {

         $.ajax({
             url: "{{ url('add_tag_ajax') }}",
             type: "POST",
             data: {
                 id: id,
                 _token: '{{ csrf_token() }}'
             },
             success: function(data) {
                 $('.edit_video_id').val(data.id);
                 $('.edit_video_name').val(data.name);

             }
         });
         $("#popup").show();
         $(".VideoContainer").html('<video width="700" height="300" controls><source src="' + url_link +
             '" type="video/mp4">Your browser does not support the video tag.</video>');

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
             VideoSource + "?autoplay=" + AutoplayVal + "&volume=" + VolValue + "&controls=" +
             ShowControlVal +
             "&title=" + ShowContentVal + "&share=" + ShowShareButtonVal +
             "&open_playlist=0' style='position: absolute; top: 0; left: 0; width: 100%; height: 100%;' frameborder='0' allow='autoplay' allowfullscreen></iframe></div>"
         );
     }

    function GetUserByIDView(ID)
    {
        $.ajax({
            type:'POST',
            url:"{{ route('admin.get_user_by_id') }}",
            data: {"_token": "{{ csrf_token() }}","id":ID},
            success:function(data){
                var name = data[0][0].name;
                var email = data[0][0].email;
                var role = data[0][0].role;
                $(".view_user_name").val(name);
                $(".view_user_email").val(email);
                $(".view_user_role").val(role);
            }
        });
    }

    function GetUserByIDEdit(ID)
    {
        $.ajax({
            type:'POST',
            url:"{{ route('admin.get_user_by_id') }}",
            data: {"_token": "{{ csrf_token() }}","id":ID},
            success:function(data){
                var id = data[0][0].id;
                var name = data[0][0].name;
                var email = data[0][0].email;
                var role = data[0][0].role;
                var status = data[0][0].status;
                $(".edit_user_id").val(id)
                $(".edit_user_name").val(name);
                $(".edit_user_email").val(email);
                $(".edit_user_password").val('');
                $(".edit_user_password_confirm").val('');
                $(".edit_user_role").val(role).change();
                $(".edit_user_status").val(status).change();
            }
        });
    }


    $("#SubmitAddUserByAdmin").click(function(){
        var user_name = $("#user_name").val();
        var user_email = $("#user_email").val();
        var user_password = $("#user_password").val();
        var user_password_confirm = $("#user_password_confirm").val();
        if(user_name != "" && user_email != "" && user_password != "" && user_password_confirm != "")
        {
            if(user_password != user_password_confirm)
            {
                $("#add_user_password_validation").html("Password fields didn't match.");
                return false;
            }
            else
            {
                $("#add_user_password_validation").html("");
            }
        }
    });

    $("#choose_domain").click(function(){
        var is_checked = $("#choose_domain").prop("checked");
        if(is_checked)
        {
            $("#domain_name").show();
        }
        else
        {
            $("#domain_name").hide();
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




 </script>
