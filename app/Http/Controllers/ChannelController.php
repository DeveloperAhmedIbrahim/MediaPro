<?php

namespace App\Http\Controllers;
use App\Models\Channel;
use App\Models\video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class ChannelController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $is_channel_exists = DB::table('channels')->where('user_id', '=', $user_id);
        // dd($is_channel_exists);
        if ($is_channel_exists == null) {
            return view('users.channel.index');
        } else {
            return redirect('chanel_list');
        }
    }
    public function create_channel()
    {

        return view('users.channel.create_chanel');
    }
    public function chanel_list()
    {
        $user_id = Auth::user()->id;
        $videos = DB::table('videos')->where('user_id', '=', $user_id)->get();
        $chanels = Channel::latest()->where('user_id', '=', $user_id)->paginate(5);
        if ($chanels[0] == null)
        {
            return view('users.channel.index');
        }
        else
        {
            return view('users.channel.chanel_list', compact('chanels', 'videos'))->with('i', (request()->input('page', 1) - 1) * 5);
        }

    }
    public function channel_select_detail(Request $req)
    {
        $get = Channel::find($req->id);
        $data['channel'] = $get;
        $videos_array = array();
        if($get->videos == null)
        {
            $videos = "";
        }
        else
        {
            $videos = $get->videos;
            $ids_array = explode(",",$videos);
            for ($i=0; $i < count($ids_array); $i++)
            {
                $id = $ids_array[$i];
                $array = DB::table('videos')->where('id',$id)->get(['id','image_url','name','is_mtu8']);
                $videos_array[] = $array[0];
            }
        }
        $data['videos'] = $videos_array;
        return $data;
    }

    public function add_video(Request $request)
    {
        $chanel_id = $request->ChanelID;
        $videos = implode(',', $request->videos);
        $model = Channel::find($chanel_id);
        if($model->videos != null && $model->videos != "")
        {
            $videos = $model->videos.",".$videos;
            $videos = explode(",",$videos);
            sort($videos);
            $videos = implode(",",$videos);
        }
        $model->videos = $videos;
        $model->save();
        return redirect('/chanel_list');
    }

    public function delete_channel($id)
    {
        $model = Channel::find($id);
        $delete = Channel::where('id', $id)->delete();
        if($model != null)
        {
            if($model->logo != "" || $model->logo != null)
            {
                $imageFullPath =  public_path() . '/uploads/' . $model->logo;
                if(file_exists($imageFullPath))
                {
                    unlink($imageFullPath);
                }
            }
        }
        return redirect()->back();
    }
    public function edit_channel(Channel $chanel)
    {
        return view('user.edit', compact('chanel'));
    }

    public function linear_scheduled(Request $request, $id = null)
    {
        if($id > 0)
        {
            $model['data'] = Channel::find($id);
            if($model == null)
            {
                return view('users.channel.schedule.linear');
            }
            else
            {
                return view('users.channel.schedule.linear',$model);
            }
        }
        else
        {
            return view('users.channel.schedule.linear');
        }
    }
    public function submit_linear_chanel(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'schedule_duration' => 'required',
            'anywhere' => 'required',
            'choose_domain' => 'required',
            'adtagurl' => 'required',
        );

        if($request->choose_domain)
        {
            $domain_name = $request->domain_name;
        }
        else
        {
            $domain_name = "";
        }

        if($domain_name == null)
        {
            $domain_name = "";
        }

        $channelId = $request->post("channelId");
        if($channelId == null)
        {
            $chanel = new Channel;
        }
        else
        {
            $chanel = Channel::find($channelId);
            if($chanel->scheduledDuration != $request->schedule_duration)
            {
                DB::table('schedule_record')->where(
                    'scheduledChannelId','=',$channelId
                )->delete();
                DB::table('schedule_videos')->where(
                    'channel_id','=',$channelId
                )->delete();
            }
        }

        $logoName = "";
        $logoVisiblity = 0;
        $logoLink = "";
        $logoPosition = "";
        $twitterHandle = "";
        if($request->toggleLogo)
        {
            $logoVisiblity = 1;
            $logoLink = $request->logoLink;
            $logoPosition = $request->hiddenLogoPosition;
            $twitterHandle = $request->twitterHandle;
            if($request->file('watermarkLogo'))
            {
                $logo = $request->file('watermarkLogo');
                $logoName = rand(111,999) . time() . rand(111,999) . '.' . $logo->extension();
                $logo->move(public_path() . '/uploads/', $logoName);
            }
            else
            {
                $checkLogoRecord = Channel::find($channelId);
                if($checkLogoRecord != null)
                {
                    $logoName = $checkLogoRecord->logo;
                }
            }
        }
        if($chanel->scheduledDuration != $request->schedule_duration)
        {
            DB::table('schedule_record')->where('scheduledChannelId','=',$channelId)->delete();
            DB::table('schedule_videos')->where('channel_id','=',$channelId)->delete();
        }
        $chanel->name = $request->name;
        $chanel->scheduledDuration = $request->schedule_duration;
        $chanel->anywhere = $request->anywhere;
        $chanel->choose_domain = $request->choose_domain;
        $chanel->adtagurl = $request->adtagurl;
        $chanel->ChanelType = "linear_schedule";
        $chanel->user_id = Auth::user()->id;
        $chanel->domain_name = $domain_name;
        $chanel->loopedTime = "00:00:00";
        $chanel->logo = $logoName;
        $chanel->logoLink = $logoLink;
        $chanel->logoPosition = $logoPosition;
        $chanel->logoVisiblity = $logoVisiblity;
        $chanel->twitterHandle = $twitterHandle;
        $chanel->timeZone = Auth::user()->timezone;
        $chanel->save();
        return redirect('/scheduleVideo/'.$chanel->id);
    }
    public function edit_linear_chanel(Request $req)
    {
        $chanel = Channel::where('id', $req->id)->update([
            'name' => $req->name,
            'schedule_duration' => $req->schedule_duration,
            'anywhere' => $req->anywhere,
            'choose_domain' => $req->choose_domain,
            'adtagurl' => $req->adtagurl,
        ]);
        return redirect('/chanel_list', compact('chanel'));

    }
    public function submit_looped_chanel(Request $request)
    {
        $timeZone = Auth::user()->timezone;
        date_default_timezone_set($timeZone);
        if($request->choose_domain)
        {
            $domain_name = $request->domain_name;
        }
        else
        {
            $domain_name = "";
        }

        if($domain_name == null)
        {
            $domain_name = "";
        }

        $channelId = $request->post("channelId");
        if($channelId == null)
        {
            $chanel = new Channel;
        }
        else
        {
            $chanel = Channel::find($channelId);
        }

        $logoName = "";
        $logoVisiblity = 0;
        $logoLink = "";
        $logoPosition = "";
        $twitterHandle = "";

        if($request->toggleLogo)
        {
            $logoVisiblity = 1;
            $logoLink = $request->logoLink;
            $logoPosition = $request->hiddenLogoPosition;
            $twitterHandle = $request->twitterHandle;
            if($request->file('watermarkLogo'))
            {
                $logo = $request->file('watermarkLogo');
                $logoName = rand(111,999) . time() . rand(111,999) . '.' . $logo->extension();
                $logo->move(public_path() . '/uploads/', $logoName);
            }
            else
            {
                $checkLogoRecord = Channel::find($channelId);
                if($checkLogoRecord != null)
                {
                    $logoName = $checkLogoRecord->logo;
                }
            }
        }
        $chanel->name = $request->name;
        $chanel->loopedTime = $request->time == null ? "00:00:00" : $request->time;
        $chanel->anywhere = $request->anywhere;
        $chanel->choose_domain = $request->choose_domain;
        $chanel->adtagurl = $request->adtagurl;
        $chanel->ChanelType = "linear_looped";
        $chanel->user_id = Auth::user()->id;
        $chanel->domain_name = $domain_name;
        $chanel->logo = $logoName;
        $chanel->logoLink = $logoLink;
        $chanel->logoPosition = $logoPosition;
        $chanel->logoVisiblity = $logoVisiblity;
        $chanel->twitterHandle = $twitterHandle;
        $chanel->currentVideo = 0;
        $chanel->currentVideoTime = 0;
        $chanel->lastVideoUpdatedTime = date('Y-m-d H:i:s');
        $chanel->timeZone = Auth::user()->timezone;
        $chanel->save();
        return redirect('/chanel_list');
    }
    public function submit_ondemand_chanel(Request $request)
    {
        if($request->choose_domain)
        {
            $domain_name = $request->domain_name;
        }
        else
        {
            $domain_name = "";
        }

        if($domain_name == null)
        {
            $domain_name = "";
        }

        $channelId = $request->post("channelId");
        if($channelId == null)
        {
            $chanel = new Channel;
        }
        else
        {
            $chanel = Channel::find($channelId);
        }

        $logoName = "";
        $logoVisiblity = 0;
        $logoLink = "";
        $logoPosition = "";
        $twitterHandle = "";

        if($request->toggleLogo)
        {
            $logoVisiblity = 1;
            $logoLink = $request->logoLink;
            $logoPosition = $request->hiddenLogoPosition;
            $twitterHandle = $request->twitterHandle;
            if($request->file('watermarkLogo'))
            {
                $logo = $request->file('watermarkLogo');
                $logoName = rand(111,999) . time() . rand(111,999) . '.' . $logo->extension();
                $logo->move(public_path() . '/uploads/', $logoName);
            }
            else
            {
                $checkLogoRecord = Channel::find($channelId);
                if($checkLogoRecord != null)
                {
                    $logoName = $checkLogoRecord->logo;
                }
            }
        }

        $chanel->name = $request->name;
        $chanel->anywhere = $request->anywhere;
        $chanel->choose_domain = $request->choose_domain;
        $chanel->adtagurl = $request->adtagurl;
        $chanel->ChanelType = "ondemand";
        $chanel->user_id = Auth::user()->id;
        $chanel->domain_name = $domain_name;
        $chanel->logo = $logoName;
        $chanel->logoLink = $logoLink;
        $chanel->logoPosition = $logoPosition;
        $chanel->logoVisiblity = $logoVisiblity;
        $chanel->twitterHandle = $twitterHandle;
        $chanel->loopedTime = "00:00:00";
        $chanel->save();
        return redirect('/chanel_list');
    }
    public function addlogomark(Request $request)
    {
        $video = $request->file('video');
        $input['video'] = time() . '.' . $video->extension();
        $videoFilePath = public_path('uploads');
        $video->text('by online web tutor', 450, 100, function ($font) {
            $font->size(40);
            $font->align('center');
            $font->align('bottom');
        });
        $video->save($videoFilePath . '.' . $input['video']);
    }
    public function schedule_videos(){
        return view('users.channel.schedule.schedule');
    }
    public function linear_looped(Request $request, $id = null)
    {
        if($id > 0)
        {
            $model['data'] = Channel::find($id);
            if($model == null)
            {
                return view('users.channel.looped.looped');
            }
            else
            {
                return view('users.channel.looped.looped',$model);
            }
        }
        else
        {
            return view('users.channel.looped.looped');
        }
    }
    public function ondemand(Request $request, $id = null)
    {
        if($id > 0)
        {
            $model['data'] = Channel::find($id);
            if($model == null)
            {
                return view('users.channel.ondemand.ondemand');
            }
            else
            {
                return view('users.channel.ondemand.ondemand',$model);
            }
        }
        else
        {
            return view('users.channel.ondemand.ondemand');
        }
    }

    public function delete_video_from_channel(Request $request, $channel_id, $video_id)
    {
        $model = Channel::find($channel_id);
        $videos = $model->videos;
        $videos = explode(',',$videos);
        for($i = 0; $i < count($videos); $i++)
        {
            if($videos[$i] == $video_id)
            {
                unset($videos[$i]);
                break;
            }
        }
        $videos = implode(",",$videos);
        $model->videos = $videos;
        $model->save();
        return redirect('/chanel_list');
    }

    public function sortVideos(Request $request)
    {
        $channelId = $request->post('channelId');
        $implodeVideos = $request->post('implodeVideos');
        $model = Channel::find($channelId);
        if($model != null)
        {
            $model->videos = $implodeVideos;
            $model->save();
        }
        return 1;
    }

    public function createDuplicateChannel(Request $request)
    {
        $channelName = $request->post('duplicateChannelName');
        $channelId = $request->post('channelIdForDublicate');
        $model = Channel::find($channelId);
        $newChannel = new Channel;
        $newChannel->name = $channelName;
        $newChannel->scheduledDuration = $model->scheduledDuration;
        $newChannel->loopedTime = $model->loopedTime;
        $newChannel->user_id = $model->user_id;
        $newChannel->anywhere = $model->anywhere;
        $newChannel->choose_domain = $model->choose_domain;
        $newChannel->domain_name = $model->domain_name;
        $newChannel->adtagurl = $model->adtagurl;
        $newChannel->ChanelType = $model->ChanelType;
        $newChannel->videos = $model->videos;
        $newChannel->logo = $model->logo;
        $newChannel->logoLink = $model->logoLink;
        $newChannel->logoVisiblity = $model->logoVisiblity;
        $newChannel->logoPosition = $model->logoPosition;
        $newChannel->twitterHandle = $model->twitterHandle;
        $newChannel->save();
        return redirect('/chanel_list');
    }
}
