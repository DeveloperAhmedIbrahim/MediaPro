<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LoopChannelCronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loop_channel:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $channelList = DB::table('channels')->where('ChanelType','=','linear_looped')->get();
        for($i = 0; $i < count($channelList); $i++)
        {
            $timeZone = $channelList[$i]->timeZone;
            date_default_timezone_set($timeZone);
            $lastVideoUpdatedTime = $channelList[$i]->lastVideoUpdatedTime;
            $currentDateAndTime = date('Y-m-d H:i:s');
            $timeDifference = strtotime($currentDateAndTime) - strtotime($lastVideoUpdatedTime);
            $channelId = $channelList[$i]->id;
            for ($j=1; $j <= $timeDifference; $j++)
            {
                $model = DB::table('channels')->where('id','=',$channelId)->get();
                $videos = $model[0]->videos;
                $currentVideoIndex = $model[0]->currentVideo;
                $videosArray = explode(",",$videos);
                if(isset($videosArray[$currentVideoIndex]))
                {
                    $currentVideoID = $videosArray[$currentVideoIndex];
                }
                else
                {
                    $currentVideoID = $videosArray[0];
                }
                $currentVideoTime = $model[0]->currentVideoTime;
                $currentVideoDuration = DB::table('videos')->where('id','=',$currentVideoID)->select('duration')->get();
                $currentVideoDuration = $currentVideoDuration[0]->duration;
                if($currentVideoTime <= $currentVideoDuration)
                {
                    $newVideoTime = (int)$currentVideoTime + 1;
                    $currentDateAndTime = date('Y-m-d H:i:s');
                    $updateCurrentVideoTime = DB::table('channels')->where('id', $channelId)->update(['currentVideoTime' => $newVideoTime]);
                    $updateCurrentDateAndTime = DB::table('channels')->where('id', $channelId)->update(['lastVideoUpdatedTime' => $currentDateAndTime]);
                }
                else
                {
                    $lastIndexOfVideo = count($videosArray) - 1;
                    if(($currentVideoIndex == $lastIndexOfVideo) || ($currentVideoIndex > $lastIndexOfVideo))
                    {
                        $newVideoTime = 0;
                        $newVideoIndex = 0;
                        $currentDateAndTime = date('Y-m-d H:i:s');
                        $updateCurrentVideoTime = DB::table('channels')->where('id', $channelId)->update(['currentVideoTime' => $newVideoTime]);
                        $updateCurrentIndex = DB::table('channels')->where('id', $channelId)->update(['currentVideo' => $newVideoIndex]);
                        $updateCurrentDateAndTime = DB::table('channels')->where('id', $channelId)->update(['lastVideoUpdatedTime' => $currentDateAndTime]);
                    }
                    else
                    {
                        $newVideoTime = 0;
                        $newVideoIndex = $currentVideoIndex + 1;
                        $currentDateAndTime = date('Y-m-d H:i:s');
                        $updateCurrentVideoTime = DB::table('channels')->where('id', $channelId)->update(['currentVideoTime' => $newVideoTime]);
                        $updateCurrentIndex = DB::table('channels')->where('id', $channelId)->update(['currentVideo' => $newVideoIndex]);
                        $updateCurrentDateAndTime = DB::table('channels')->where('id', $channelId)->update(['lastVideoUpdatedTime' => $currentDateAndTime]);
                    }
                }
            }
        }

        return Command::SUCCESS;
    }
}
