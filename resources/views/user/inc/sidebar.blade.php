<div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="menu-title"> 
								<span>Main</span>
							</li>
                            <li class="submenu">
                            <li><a href="{{url('/dashboard')}}"><i class="la la-dashboard"></i><span>User Dashboard</span></a></li>
                     
							</li>
                            
                            <li class="submenu">
                            <li>
                        
                            <a href="{{url('/manage/channels')}}"><i class="la la-file-video-o"></i> <span> Channels</span></a>
                 
                        </li>
							
							</li>
                            <li class="submenu">
                            <li><a href="{{url('/manage/videos')}}"><i class="la la-youtube-play"></i> <span> Videos</span></a></li>			
							</li>
					
                            <li class="submenu">
                            <li><a href="{{ url('/select_video') }}"><i class="la la-cloud-download"></i> <span> Uploads</span></a>
</li>
							</li>
                            <li class="submenu">
                            <li><a href="{{ route('websites.index') }}"><i class="la la-globe"></i> <span> Website</span></a></li>
							</li>
                            <li class="submenu">
                            <li><a href="{{ url('/Analytics') }}"><i class="la la-bar-chart"></i> <span> Analytics</span></a>
</li>
							</li>
						</ul>
					</div>
                </div>
            </div>
