<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestCronJobController extends Controller
{
    public function testCronJob()
    {
        return view('embed.testcronjob');
    }
    public function setVideoTiming(Request $request)
    {
        $model = DB::table('channels')->where('ChanelType','=','linear_looped')->get();
        for($i = 0; $i < count($model); $i++)
        {
            $videos = $model[$i]->videos;
            $channelId = $model[$i]->id;
            $currentVideoIndex = $model[$i]->currentVideo;
            $videosArray = explode(",",$videos);
            if(isset($videosArray[$currentVideoIndex]))
            {
                $currentVideoID = $videosArray[$currentVideoIndex];
            }
            else
            {
                $currentVideoID = $videosArray[0];
            }
            $currentVideoTime = $model[$i]->currentVideoTime;
            $currentVideoDuration = DB::table('videos')->where('id','=',$currentVideoID)->select('duration')->get();
            $currentVideoDuration = $currentVideoDuration[0]->duration;
            if($currentVideoTime <= $currentVideoDuration)
            {
                $newVideoTime = (int)$currentVideoTime + 1;
                $updateCurrentVideoTime = DB::table('channels')->where('id', $channelId)->update(['currentVideoTime' => $newVideoTime]);
            }
            else
            {
                $lastIndexOfVideo = count($videosArray) - 1;
                if(($currentVideoIndex == $lastIndexOfVideo) || ($currentVideoIndex > $lastIndexOfVideo))
                {
                    $newVideoTime = 0;
                    $newVideoIndex = 0;
                    $updateCurrentVideoTime = DB::table('channels')->where('id', $channelId)->update(['currentVideoTime' => $newVideoTime]);
                    $updateCurrentIndex = DB::table('channels')->where('id', $channelId)->update(['currentVideo' => $newVideoIndex]);
                }
                else
                {
                    $newVideoTime = 0;
                    $newVideoIndex = $currentVideoIndex + 1;
                    $updateCurrentVideoTime = DB::table('channels')->where('id', $channelId)->update(['currentVideoTime' => $newVideoTime]);
                    $updateCurrentIndex = DB::table('channels')->where('id', $channelId)->update(['currentVideo' => $newVideoIndex]);
                }
            }
        }
    }
}
