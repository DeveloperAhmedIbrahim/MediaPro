@extends('user.layouts.app')
@section('content')
    <!-- Page Content -->

    @php
        $user = \App\Models\Channel::where('user_id', auth()->user()->id)->first();
    @endphp

    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">CREATE CHANNEL</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">CREATE CHANNEL</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <h3 style="color:darkslategray;font-weight: lighter"> 1. Choose the channel type</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                            <li class="nav-item"><a class="nav-link active btn-md" href="#linearPanel" data-toggle="tab" id="LinearTabButton">Linear</a></li>
                            <li class="nav-item"><a class="nav-link" href="#ondemandPanel" data-toggle="tab" id="OnDemandButton">On Demand</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="row">
                    <div class="tab-content" style="width: 100%; height: 50vh;">
                        <div class="tab-pane show active" id="linearPanel">
                            <div class="container" style="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <h3 style="color:darkslategray;font-weight: lighter">
                                                <div class="container mt-5">
                                                    2. Do you want the channel content to repeat on a fixed schedule or in a loop?
                                                </div>
                                            </h3>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                                    <li class="nav-item"><a class="nav-link active btn-md" href="#linearScheduled" data-toggle="tab" id="LinearScheduledTabButton">Scheduled</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#linearLooped" data-toggle="tab" id="LinearLoopedTabButton">Looped</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                        <div class="row">
                                            <div class="container">
                                                <a class="btn btn-primary btn-md waves-effect waves-light" data-toggle="tooltip"
                                                    style="padding: 10px 30px 30px;border-radius:0px;margin-top: 10.5%; "
                                                    data-placement="top" title=""
                                                    href="{{ url('/linear_scheduled') }}"
                                                    role="button" id="LoopedNextButton">NEXT
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="ondemandPanel">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a class="btn btn-primary btn-md waves-effect waves-light" data-toggle="tooltip"
                                            style="padding: 10px 30px 30px;border-radius:0px;margin-top: 24.5%; "
                                            data-placement="top" title="" href="{{ url('/ondemand') }}"
                                            role="button">NEXT
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
