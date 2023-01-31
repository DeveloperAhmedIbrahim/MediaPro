@extends('user.layouts.app')
@section('content')
    <style>
        #files-area {
            width: 40%;
            margin: 0 auto;
            max-height: 200px !important;
            background: #E5E4E2;
            overflow: auto;
        }
        .file-block {
            border-radius: 0px;
            background-color: whitesmoke;
            margin: 5px;
            color: initial;
            display: inline-flex;
            padding: 10px;
            width:95% !important;
            border: 0.5px dashed gray;
        }
        .file-delete {
            display: flex;
            width: 24px;
            color: initial;
            background-color: #6eb4ff00;
            font-size: large;
            justify-content: center;
            margin-right: 3px;
            cursor: pointer;

        }
        .name{
            width: 70%;
            color: #F55D30;
            white-space: nowrap;
            overflow: hidden !important;
            text-overflow: ellipsis;
            padding-top: 4px;
        }
        .file-delete{
            color: red;
        }
        #files-area{
            text-align: left !important;
        }
        #files-area::-webkit-scrollbar {
            background: lightyellow;
            width: 12px;
        }
        #files-area::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            border-radius: 0px;
        }
        #files-area::-webkit-scrollbar-thumb {
            border-radius: 0px;
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
        }
        .add-watermark{
            font-size: 15px;
            color: darkcyan;
            margin-left: 20px;
        }
        .add-watermark:hover{
            cursor: pointer;
            color: dodgerblue;
        }
        #UploadingLoader{
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
            display: flex;
        }
        .loader {
            border: 10px solid #f3f3f3;
            border-radius: 50%;
            border-top: 10px solid #3498db;
            width: 150px;
            height: 150px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 1s linear infinite;
            position: absolute;
        }

        /* Safari */
        @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
        }
        .size{
            width: 30%;
        }
    </style>
    <div class="content-wrapper">
        <div class="container-fluid mb-5">
            <div class="row">
                <div class="main-header">
                    <h4>Select Video</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center">
        <div class="row" style="display:flex;justify-content:center">
            <div class="wrapper">
                <header>File Uploader </header>
                <div id="UploadingLoader" style="display: none;">
                    <span style="position: absolute;">Processing...</span>
                    <div class="loader">
                    </div>
                </div>
                <form action="{{ url('/insert_video') }}" method="post" enctype="multipart/form-data" id="videosForm">
                    @csrf
                    <div class="col-md-9">
                        <label for="" style="margin-left: 22px;margin-top:93px">upload video</label>
                        <input class="file-input" type="file" id="file" placeholder="Choose the file" name="image_url[]" multiple>

                    </div>
                    <div class="col-md-9" style="margin-top:20px">
                        <input type="submit" name="upload" class="btn btn-primary btn- text-center" id="submitVideosForm" style="width: 100%;border-radius:0px;" />
                    </div>
                    @if (Session::has('error_message'))
                        <span class="text-danger">
                            <h4>{{ session('error_message') }}</h4>
                        </span>
                    @endif
                </form>
            </div>
        </div>
        <div class="container">
            <p id="files-area">
                <span id="filesList">
                    <span id="files-names"></span>
                </span>
            </p>
        </div>
        <div class="container" style="justify-content: center;align-items: center;display: flex;">
            @if (count($model) > 0)
                <table class="table table-striped" style="text-align: left ;width:60% !important;">
                    <tbody>
                    @foreach (json_decode($model) as $data)
                        @if ($data->is_mtu8 != 1)
                            <tr>
                                <td style="width: 10%">
                                    <video width="60" height="60" style="border: 0.5px lightgray solid">
                                        <source src="{{ url('uploads/' . $data->image_url) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </td>
                                <td style="width: 60%;">{{ $data->name }}</td>
                                <td>
                                    <div class="text-success">✔ Ready</div>
                                    <a href="{{ url('/manage/videos/single/' . $data->id) }}" style="font-size: 15px; font-weight: lighter;">View in content ►</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    </div>
    </div>
    </div>


@endsection
