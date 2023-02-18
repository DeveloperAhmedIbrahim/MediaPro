@extends('user.layouts.app')
@section('content')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {

            position: absolute;
            content: "";
            height: 20px;
            width: 18px;
            left: 0px;
            bottom: 0px;
            border: 2px solid lightslategray;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            color: darkslategray;
            z-index: 1;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(30px);
            -ms-transform: translateX(30px);
            transform: translateX(30px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .switch-title {
            position: absolute;
            z-index: 1;
            right: 0;
            font-size: 12px;
            top: 1px;
            right: 3px;
            color: darkslategray;
            font-weight: bolder;
            transition: 0.3s;
        }

        #watermarkPreview {
            width: 150px;
            height: 150px;
            background: lightgrey;
        }

        #previewWatermarkInVideo {
            position: absolute;
            opacity: 0.6;
            width: 100px;
            top: 15px;
            cursor: pointer;
            left: 3%;
        }
    </style>
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Create Channel</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Create Channel</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <form action="{{ url('/submit_looped_chanel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($data->id))
                <input type="hidden" id="channelId" name="channelId" value="{{ $data->id }}">
            @else
                <input type="hidden" id="channelId" name="channelId" value="">
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Looped (Linear)</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Name</label>
                                <div class="col-md-10">
                                    @if (isset($data->name))
                                        <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
                                    @else
                                        <input type="text" class="form-control" name="name" value="Untitled Channel" required>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-12">Start time:</label>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        @if (isset($data->loopedTime))
                                            <input type="time" id="time input" class="form-control" name="time" value="{{ $data->loopedTime }}">
                                        @else
                                            <input type="time" id="time input" class="form-control" name="time">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div id="timezoneMessage" class="text-secondary pt-2"> Your current timezone is
                                        {{ Auth::user()->timezone }} </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-12">Player Settings</label>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Player Setting</h4>
                                            <div class="container">
                                                <div class="row">
                                                    <ul class="nav nav-tabs nav-tabs-solid nav-justified"
                                                        style="width: 100%;">
                                                        <li class="nav-item" style="width: 100%; text-align: center;">
                                                            <a class="nav-link active" href="#" data-toggle="tab"
                                                                style="width: 100%; text-align: center;">
                                                                Player Customization
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-6 mt-3">
                                                        <div class="row">
                                                            <span>
                                                                Logo :
                                                                <label class="switch">
                                                                    <div class="switch-title">OFF</div>
                                                                    @if (isset($data->logoVisiblity) && $data->logoVisiblity == 1)
                                                                        <input type="checkbox" id="toggleLogo"
                                                                            name="toggleLogo" checked>
                                                                    @else
                                                                        <input type="checkbox" id="toggleLogo"
                                                                            name="toggleLogo">
                                                                    @endif
                                                                    <span class="slider"></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                        <div class="row" style="display: inline-grid;">
                                                            <input type="file" name="watermarkLogo" id="watermarkLogo"
                                                                onchange="loadFile(event)" hidden>
                                                            <div id="watermarkPreview" style="text-align: center;">
                                                                @if (isset($data->logo) && $data->logo != null && $data->logo != '')
                                                                    <img id="output" width="150" height="150"
                                                                        src="{{ url('/uploads') . '/' . $data->logo }}" />
                                                                @else
                                                                    <img id="output" width="150" height="150" />
                                                                @endif
                                                            </div>
                                                            <div class="btn btn-primary"
                                                                style="width: 150px; border-radius: 0;" id="btnUploadLogo">
                                                                Upload logo</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <div class="row">
                                                            <label for="logoLink">Logo link</label>
                                                            @if (isset($data->logoLink) && $data->logoLink != null && $data->logoLink != '')
                                                                <input type="text" class="form-control" name="logoLink"
                                                                    id="logoLink" value="{{ $data->logoLink }}"
                                                                    placeholder="http://mediapro.az-solutions.pk/">
                                                            @else
                                                                <input type="text" class="form-control" name="logoLink"
                                                                    id="logoLink"
                                                                    placeholder="http://mediapro.az-solutions.pk/">
                                                            @endif
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div style="width: 100%;">
                                                                <label for="">Logo position</label>
                                                            </div>
                                                            <div class="form-check px-5">
                                                                @if (isset($data->logoPosition))
                                                                    @if ($data->logoPosition == 'left')
                                                                        <input class="form-check-input" type="radio"
                                                                            name="logoPosition" id="logoPositionLeft"
                                                                            value="left" checked>
                                                                    @else
                                                                        <input class="form-check-input" type="radio"
                                                                            name="logoPosition" id="logoPositionLeft"
                                                                            value="left">
                                                                    @endif
                                                                @else
                                                                    <input class="form-check-input" type="radio"
                                                                        name="logoPosition" id="logoPositionLeft"
                                                                        value="left" checked>
                                                                @endif
                                                                <label class="form-check-label" for="logoPositionLeft">
                                                                    Left
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @if (isset($data->logoPosition) && $data->logoPosition == 'right')
                                                                    <input class="form-check-input" type="radio"
                                                                        name="logoPosition" id="logoPositionRight"
                                                                        value="right" checked>
                                                                @else
                                                                    <input class="form-check-input" type="radio"
                                                                        name="logoPosition" id="logoPositionRight"
                                                                        value="right">
                                                                @endif
                                                                <label class="form-check-label" for="logoPositionRight">
                                                                    Right
                                                                </label>
                                                            </div>
                                                            @if (isset($data->logoPosition) && $data->logoPosition != '' && $data->logoPosition != null)
                                                                <input type="hidden" id="hiddenLogoPosition"
                                                                    name="hiddenLogoPosition"
                                                                    value="{{ $data->logoPosition }}">
                                                            @else
                                                                <input type="hidden" id="hiddenLogoPosition"
                                                                    name="hiddenLogoPosition">
                                                            @endif
                                                        </div>
                                                        <div class="row mt-3">
                                                            <label for="twitterHandle">Twitter</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text" id="basic-addon1">@</span>
                                                                @if (isset($data->twitterHandle) && $data->twitterHandle != '' && $data->twitterHandle != null)
                                                                    <input type="text" class="form-control"
                                                                        placeholder="" aria-label="twitterHandle"
                                                                        aria-describedby="basic-addon1"
                                                                        name="twitterHandle" id="twitterHandle"
                                                                        value="{{ $data->twitterHandle }}">
                                                                @else
                                                                    <input type="text" class="form-control"
                                                                        placeholder="" aria-label="twitterHandle"
                                                                        aria-describedby="basic-addon1"
                                                                        name="twitterHandle" id="twitterHandle">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                                <li class="nav-item"><a class="nav-link active"
                                                        href="#solid-justified-tab1" data-toggle="tab">Privacy Settings
                                                    </a></li>
                                                <li class="nav-item"><a class="nav-link" href="#solid-justified-tab2"
                                                        data-toggle="tab">Ads Monetization</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane  show active" id="solid-justified-tab1">
                                                    <label for="">Where can this channel be embedded?</label>
                                                    <div class="form-check"
                                                        style="margin-left:20px;margin-right:10px;margin-bottom:10px">
                                                        <label for="chkme" class="form-check-label">
                                                            @if (isset($data->anywhere) && $data->anywhere == 1)
                                                                <input type="checkbox" name="anywhere"
                                                                    class="form-check-input" value="1"
                                                                    id="anywhere" checked>
                                                            @else
                                                                <input type="checkbox" name="anywhere"
                                                                    class="form-check-input" value="1"
                                                                    id="anywhere">
                                                            @endif
                                                            Anywhere ?
                                                        </label>
                                                    </div>
                                                    <div class="form-check"
                                                        style="margin-left:20px;margin-right:10px;margin-bottom:10px">
                                                        <label for="chkme" class="form-check-label">
                                                            @if (isset($data->choose_domain) && $data->choose_domain == 1)
                                                                <input type="checkbox" name="choose_domain"
                                                                    class="form-check-input" id="choose_domain"
                                                                    value="1" checked>
                                                            @else
                                                                <input type="checkbox" name="choose_domain"
                                                                    class="form-check-input" id="choose_domain"
                                                                    value="1">
                                                            @endif
                                                            Only on domains I choose
                                                        </label>
                                                        @if (isset($data->choose_domain) && $data->choose_domain == 1)
                                                            <input type="text" class="form-control" name="domain_name"
                                                                id="domain_name" placeholder="Enter domain name"
                                                                style="display:none;" value="{{ $data->domain_name }}">
                                                        @else
                                                            <input type="text" class="form-control" name="domain_name"
                                                                id="domain_name" placeholder="Enter domain name"
                                                                style="display:none;" value="">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="solid-justified-tab2">
                                                    <div class="form-group"
                                                        style="margin-left:10px;margin-right:10px;margin-bottom:10px">
                                                        <label for="exampleInputEmail1" class="form-control-label">Ad tag
                                                            URL:</label>
                                                        @if (isset($data->adtagurl))
                                                            <input type="name" class="form-control" name="adtagurl"
                                                                placeholder="Ad tag URL:" value="{{ $data->adtagurl }}">
                                                        @else
                                                            <input type="name" class="form-control" name="adtagurl"
                                                                placeholder="Ad tag URL:">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-danger" id="PrivacySettingsValidation"></h4>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div style="position: relative;overflow: auto;">
                                            @if (isset($data->logo) && $data->logo != null && $data->logo != '')
                                                @if ($data->logoPosition == 'right')
                                                    <img src="{{ url('/uploads') . '/' . $data->logo }}"
                                                        id="previewWatermarkInVideo" alt="" style="left: 81%">
                                                @else
                                                    <img src="{{ url('/uploads') . '/' . $data->logo }}"
                                                        id="previewWatermarkInVideo" alt="">
                                                @endif
                                            @else
                                                <img src="" id="previewWatermarkInVideo" alt="">
                                            @endif
                                            <iframe
                                                src="{{ url('/') }}/embed?url=videoSampleOne.mp4&autoplay=0&volume=1&controls=1&title=1&share=1&open_playlist=0&disabled=0"
                                                width="600" height="340" title="MediaPro Video"
                                                allowfullscreen="true" frameBorder="0">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success waves-effect waves-light m-r-30"
                    id="LinearLoopedFormSubmit">Submit</button>
            </div>
        </form>
    </div>

@endsection
