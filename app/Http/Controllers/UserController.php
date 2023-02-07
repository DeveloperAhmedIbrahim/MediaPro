<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Owenoj\LaravelGetId3\GetId3;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }
    public function profile()
    {
        return view('users.user.profile');
    }
    public function video()
    {
        $user_id = Auth::user()->id;
        $model['videos'] = DB::table('videos')->where('user_id', '=', $user_id)->get();
        $model['tags_for_searching'] = DB::table('tags')->where('user_id', '=', $user_id)->get();
        return view('users.videos.index', $model);
    }
    public function select_video()
    {
        $user_id = Auth::user()->id;
        $data['model'] = DB::table('videos')->where('user_id', '=', $user_id)->get();
        return view('users.videos.select_video', $data);
    }

    public function insert_video(Request $request)
    {
        $data = [];
        $this->validate($request, [
            'image_url' => 'required',
            'image_url.*' => 'mimes:mp4,mov,m4v,webm,ogv,mp3',
        ]);
        $file_size = "";
        if ($request->hasfile('image_url'))
        {
            foreach ($request->file('image_url') as $file)
            {
                $videoObj = new GetId3($file);
                $videoObj = GetId3::fromUploadedFile($file);
                $videoInfo = $videoObj->extractInfo();
                $videoDuration =  $videoInfo['playtime_seconds'];
                $videoExtension = $videoObj->getFileFormat();
                $name = rand(111,999) . time() . rand(111,999) . '.' . $file->extension();
                $original_name = $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/', $name);
                $data[] = $name;
                $file = new video();
                $file->image_url = $name;
                $file->name = $original_name;
                $file->user_id = Auth::user()->id;
                $file->duration = $videoDuration;
                $file->extension = $videoExtension;
                $file->save();
            }
        }
        return redirect('/manage/videos');
    }

    public function edit_data()
    {
        $data = video::get();
        return view('users.videos.select_video', compact($data));
    }

    public function download(Request $request, $file)
    {
        return response()->download(public_path('/uploads/' . $file));
    }
    public function fetch_ajax_vedio(Request $req)
    {
        return redirect()->back();
    }

    public function delete_vedio($id)
    {
        $model = video::find($id);
        $delete = video::where('id', $id)->delete();
        if($model != null)
        {
            $imageFullPath =  public_path() . '/uploads/' . $model->image_url;
            if(file_exists($imageFullPath))
            {
                unlink($imageFullPath);
            }
        }
        $user_id = Auth::user()->id;
        $channel = DB::table('channels')->where('user_id',$user_id)->select('videos','id')->get();
        for($i = 0; $i < count($channel); $i++)
        {
            $videos = $channel[$i]->videos;
            $channel_id = $channel[$i]->id;
            $videos = explode(",",$videos);
            for ($j=0; $j < count($videos); $j++)
            {
                if($videos[$j] == $id)
                {
                    unset($videos[$j]);
                }
            }
            $videos = implode(",",$videos);
            $channel_model = Channel::find($channel_id);
            $channel_model->videos = $videos;
            $channel_model->save();
        }
        return redirect()->back();
    }
    public function download_video($id)
    {
        $get = video::where('id', $id)->first();
        $video = $get->image_url;
        if($video != null && $video != "")
        {
            $file_path = public_path('uploads/' . $video);
            return response()->download($file_path);
        }
    }
    public function edit_vedio_post(Request $req)
    {
        $user_id = Auth::user()->id;
        $tags_old = DB::table('tags')->where('user_id','=',$user_id)->get();
        $tags = $req->tag;
        if($req->name == null)
        {
            $video_name = "";
        }
        else
        {
            $video_name = $req->name;
        }
        if($tags != null && $tags != "")
        {
            if(count($tags_old) > 0)
            {
                for ($i=0; $i < count($tags); $i++)
                {
                    $already_existed = DB::table('tags')->where('tag','=',$tags[$i])->get();
                    if(count($already_existed) == 0)
                    {
                        DB::table('tags')->insert([
                            'tag' => $tags[$i],
                            'user_id' => $user_id
                        ]);
                    }
                }
                $model = video::find($req->id);
                if($model != null)
                {
                    $model->name = $video_name;
                    $model->tag = $req->tag;
                    $model->save();
                }
            }
            else
            {
                for ($i = 0; $i < count($tags); $i++)
                {
                    DB::table('tags')->insert([
                        'tag' => $tags[$i],
                        'user_id' => $user_id
                    ]);
                }
                $model = video::find($req->id);
                if($model != null)
                {
                    $model->name = $video_name;
                    $model->tag = $req->tag;
                    $model->save();
                }
            }
        }
        else
        {
            $tags = "";
            $model = video::find($req->id);
            if($model != null)
            {
                $model->name = $video_name;
                $model->tag = $req->tag;
                $model->save();
            }
        }
        $all_tags = DB::table('tags')->where('user_id','=',$user_id)->select('tag')->get();
        for ($i=0; $i < count($all_tags); $i++)
        {
            $current_tag = $all_tags[$i]->tag;
            $is_tag_in_used = DB::table('videos')->where([['tag','LIKE','%'.$current_tag.'%'],['user_id','=',$user_id]])->select('tag')->get();
            if(count($is_tag_in_used) == 0)
            {
                $delete_tag = DB::table('tags')->where([['tag','=',$current_tag],['user_id','=',$user_id]])->delete();
            }
        }
        return redirect()->back();
    }
    public function edit_data_ajax(Request $req)
    {
        $user_id = Auth::user()->id;
        $get['video'] = video::find($req->id);
        $get['all_tags'] = DB::table('tags')->where('user_id','=',$user_id)->get();
        return $get;
    }
    public function add_tag_ajax(Request $req)
    {
        $user_id = Auth::user()->id;
        $get['video'] = video::find($req->id);
        $get['all_tags'] = DB::table('tags')->where('user_id','=',$user_id)->get();
        return $get;
    }
    public function insert_tag(Request $req)
    {
        $user_id = Auth::user()->id;
        $tags_old = DB::table('tags')->where('user_id','=',$user_id)->get();
        $tags = $req->tag;
        if($tags != null && $tags != "")
        {
            if(count($tags_old) > 0)
            {
                for ($i=0; $i < count($tags); $i++)
                {
                    $already_existed = DB::table('tags')->where('tag','=',$tags[$i])->get();
                    if(count($already_existed) == 0)
                    {
                        DB::table('tags')->insert([
                            'tag' => $tags[$i],
                            'user_id' => $user_id
                        ]);
                    }
                }
                $model = video::find($req->id);
                if($model != null)
                {
                    $model->tag = $req->tag;
                    $model->save();
                }
            }
            else
            {
                for ($i = 0; $i < count($tags); $i++)
                {
                    DB::table('tags')->insert([
                        'tag' => $tags[$i],
                        'user_id' => $user_id
                    ]);
                }
                $model = video::find($req->id);
                if($model != null)
                {
                    $model->tag = $req->tag;
                    $model->save();
                }
            }
        }
        else
        {
            $tags = "";
            $model = video::find($req->id);
            if($model != null)
            {
                $model->tag = $req->tag;
                $model->save();
            }
        }
        $all_tags = DB::table('tags')->where('user_id','=',$user_id)->select('tag')->get();
        for ($i=0; $i < count($all_tags); $i++)
        {
            $current_tag = $all_tags[$i]->tag;
            $is_tag_in_used = DB::table('videos')->where([['tag','LIKE','%'.$current_tag.'%'],['user_id','=',$user_id]])->select('tag')->get();
            if(count($is_tag_in_used) == 0)
            {
                $delete_tag = DB::table('tags')->where([['tag','=',$current_tag],['user_id','=',$user_id]])->delete();
            }
        }

        return redirect()->back();
    }
    public function searchvideotag(Request $request)
    {
        $request->get('searchvideotag');
        $video = video::where('tag', 'LIKE', '%' . $request->get('searchvideotag') . '%')->get();
        return json_decode($video);
    }


    public function searchPosts_by_name(Request $request)
    {
        $Name = $request->get('searchQuery');
        $TagName = $request->get('TagName');
        $video = "";
        if (($TagName != null || $TagName != "") && ($Name != null || $Name != "")) {
            $video = video::where([['name', 'LIKE', '%' . $Name . '%'], ['tag', 'LIKE', '%' . $TagName . '%']])->get();
        } else if ($TagName == null || $TagName == "") {
            $video = video::where([['name', 'LIKE', '%' . $Name . '%']])->get();
        } else if ($Name == null || $Name == "") {
            $video = video::where([['tag', 'LIKE', '%' . $TagName . '%']])->get();
        }
        return json_encode($video);
    }

    public function search_video(Request $request)
    {
        // dd($request->all());
        $user_id = Auth::user()->id;
        $name = $request->post('searching_name');
        $type = $request->post('searching_type');
        $videoType = $request->post('video_type');

        if($videoType == "all")
        {
            $tags = array();
            if($request->post('searching_tag'))
            {
                $tags = $request->post('searching_tag');
            }
            else
            {
                $tags = null;
            }
            if($tags == null && $name != null)
            {
                $model['videos'] = DB::table('videos')->where([['name', 'LIKE', '%' . $name . '%'],['user_id','=',$user_id]])->get();
                $model['tags_for_searching'] = DB::table('tags')->where('user_id','=',$user_id)->get();
                return view('users.videos.index', $model);
            }
            else if($tags != null && $name == null)
            {
                if($type == "any")
                {
                    $videos_array = array();
                    $cleaned_videos = array();
                    for ($i=0; $i < count($tags); $i++)
                    {
                        $videos_array[] = DB::table('videos')->where([['tag', 'LIKE', '%' . $tags[$i] . '%'],['user_id','=',$user_id]])->get();
                    }
                    for($i = 0; $i < count($videos_array); $i++)
                    {
                        for($j = 0; $j < count($videos_array[$i]); $j++)
                        {
                            $is_same_row = 0;
                            if($cleaned_videos == null)
                            {
                                $cleaned_videos[] = $videos_array[$i][$j];
                            }
                            else
                            {
                                for($k = 0; $k < count($cleaned_videos); $k++)
                                {
                                    if($cleaned_videos[$k]->id == $videos_array[$i][$j]->id)
                                    {
                                        $is_same_row = 1;
                                    }
                                }
                                if($is_same_row == 0)
                                {
                                    $cleaned_videos[] = $videos_array[$i][$j];
                                }

                            }
                        }
                    }
                    $model['videos'] = $cleaned_videos;
                    $model['tags_for_searching'] = DB::table('tags')->where('user_id','=',$user_id)->get();
                    return view('users.videos.index', $model);
                }
                else if($type == "all")
                {
                    // $Tags_formate = '[';
                    // for($i = 0; $i < count($tags); $i++)
                    // {
                    //     $Tags_formate .= '"';
                    //     $Tags_formate .= $tags[$i];
                    //     $Tags_formate .= '"';
                    //     $comma_count = count($tags) - 1;
                    //     if($i != $comma_count)
                    //     {
                    //         $Tags_formate .= ',';
                    //     }
                    // }
                    // $model['videos'] = DB::table('videos')->where([['tag', 'LIKE', $Tags_formate.'%'],['user_id','=',$user_id]])->get();
                    $model['videos'] = DB::table('videos')->where('user_id','=',$user_id)->where(function($query) use ($tags){
                        foreach($tags as $key => $value){
                            $query->where('tag','LIKE','%'.$value.'%');
                        }
                    })->get();
                    $model['tags_for_searching'] = DB::table('tags')->where('user_id','=',$user_id)->get();
                    return view('users.videos.index', $model);
                }
            }
            else if($tags != null && $name != null)
            {
                if($type == "any")
                {
                    $videos_array = array();
                    $cleaned_videos = array();
                    for ($i=0; $i < count($tags); $i++)
                    {
                        $videos_array[] = DB::table('videos')->where([['name', 'LIKE', '%' . $name . '%'],['tag', 'LIKE', '%' . $tags[$i] . '%'],['user_id','=',$user_id]])->get();
                    }
                    for($i = 0; $i < count($videos_array); $i++)
                    {
                        for($j = 0; $j < count($videos_array[$i]); $j++)
                        {
                            $is_same_row = 0;
                            if($cleaned_videos == null)
                            {
                                $cleaned_videos[] = $videos_array[$i][$j];
                            }
                            else
                            {
                                for($k = 0; $k < count($cleaned_videos); $k++)
                                {
                                    if($cleaned_videos[$k]->id == $videos_array[$i][$j]->id)
                                    {
                                        $is_same_row = 1;
                                    }
                                }
                                if($is_same_row == 0)
                                {
                                    $cleaned_videos[] = $videos_array[$i][$j];
                                }

                            }
                        }
                    }
                    $model['videos'] = $cleaned_videos;
                    $model['tags_for_searching'] = DB::table('tags')->where('user_id','=',$user_id)->get();
                    return view('users.videos.index', $model);
                }
                else if($type == "all")
                {
                    // $Tags_formate = '[';
                    // for($i = 0; $i < count($tags); $i++)
                    // {
                    //     $Tags_formate .= '"';
                    //     $Tags_formate .= $tags[$i];
                    //     $Tags_formate .= '"';
                    //     $comma_count = count($tags) - 1;
                    //     if($i != $comma_count)
                    //     {
                    //         $Tags_formate .= ',';
                    //     }
                    // }
                    // $model['videos'] = DB::table('videos')->where([['name', 'LIKE', '%' . $name . '%'],['tag', 'LIKE', $Tags_formate.'%'],['user_id','=',$user_id]])->get();
                    $model['videos'] = DB::table('videos')->where([['name', 'LIKE', '%' . $name . '%'],['user_id','=',$user_id]])->where(function($query) use ($tags){
                        foreach($tags as $key => $value){
                            $query->where('tag','LIKE','%'.$value.'%');
                        }
                    })->get();
                    $model['tags_for_searching'] = DB::table('tags')->where('user_id','=',$user_id)->get();
                    return view('users.videos.index', $model);
                }
            }
            else if($tags == null && $name == null)
            {
                return redirect('/manage/videos/');
            }
        }
        else
        {
            $videosTypeVal = 0;
            if($videoType == "external")
            {
                $videosTypeVal = 1;
            }
            // dd($request->all());
            if($request->post('searching_tag'))
            {
                $tags = $request->post('searching_tag');
            }
            else
            {
                $tags = null;
            }
            if($tags == null && $name != null)
            {
                $model['videos'] = DB::table('videos')->where([['name', 'LIKE', '%' . $name . '%'],['user_id','=',$user_id],['is_mtu8','=',$videosTypeVal]])->get();
                $model['tags_for_searching'] = DB::table('tags')->where('user_id','=',$user_id)->get();
                return view('users.videos.index', $model);
            }
            else if($tags != null && $name == null)
            {
                if($type == "any")
                {
                    $videos_array = array();
                    $cleaned_videos = array();
                    for ($i=0; $i < count($tags); $i++)
                    {
                        $videos_array[] = DB::table('videos')->where([['tag', 'LIKE', '%' . $tags[$i] . '%'],['user_id','=',$user_id],['is_mtu8','=',$videosTypeVal]])->get();
                    }
                    for($i = 0; $i < count($videos_array); $i++)
                    {
                        for($j = 0; $j < count($videos_array[$i]); $j++)
                        {
                            $is_same_row = 0;
                            if($cleaned_videos == null)
                            {
                                $cleaned_videos[] = $videos_array[$i][$j];
                            }
                            else
                            {
                                for($k = 0; $k < count($cleaned_videos); $k++)
                                {
                                    if($cleaned_videos[$k]->id == $videos_array[$i][$j]->id)
                                    {
                                        $is_same_row = 1;
                                    }
                                }
                                if($is_same_row == 0)
                                {
                                    $cleaned_videos[] = $videos_array[$i][$j];
                                }

                            }
                        }
                    }
                    $model['videos'] = $cleaned_videos;
                    $model['tags_for_searching'] = DB::table('tags')->where('user_id','=',$user_id)->get();
                    return view('users.videos.index', $model);
                }
                else if($type == "all")
                {
                    // $Tags_formate = '[';
                    // for($i = 0; $i < count($tags); $i++)
                    // {
                    //     $Tags_formate .= '"';
                    //     $Tags_formate .= $tags[$i];
                    //     $Tags_formate .= '"';
                    //     $comma_count = count($tags) - 1;
                    //     if($i != $comma_count)
                    //     {
                    //         $Tags_formate .= ',';
                    //     }
                    // }
                    // $model['videos'] = DB::table('videos')->where([['tag', 'LIKE', $Tags_formate.'%'],['user_id','=',$user_id]])->get();
                    $model['videos'] = DB::table('videos')->where([['user_id','=',$user_id],['is_mtu8','=',$videosTypeVal]])->where(function($query) use ($tags){
                        foreach($tags as $key => $value){
                            $query->where('tag','LIKE','%'.$value.'%');
                        }
                    })->get();
                    $model['tags_for_searching'] = DB::table('tags')->where('user_id','=',$user_id)->get();
                    return view('users.videos.index', $model);
                }
            }
            else if($tags != null && $name != null)
            {
                if($type == "any")
                {
                    $videos_array = array();
                    $cleaned_videos = array();
                    for ($i=0; $i < count($tags); $i++)
                    {
                        $videos_array[] = DB::table('videos')->where([['name', 'LIKE', '%' . $name . '%'],['tag', 'LIKE', '%' . $tags[$i] . '%'],['user_id','=',$user_id],['is_mtu8','=',$videosTypeVal]])->get();
                    }
                    for($i = 0; $i < count($videos_array); $i++)
                    {
                        for($j = 0; $j < count($videos_array[$i]); $j++)
                        {
                            $is_same_row = 0;
                            if($cleaned_videos == null)
                            {
                                $cleaned_videos[] = $videos_array[$i][$j];
                            }
                            else
                            {
                                for($k = 0; $k < count($cleaned_videos); $k++)
                                {
                                    if($cleaned_videos[$k]->id == $videos_array[$i][$j]->id)
                                    {
                                        $is_same_row = 1;
                                    }
                                }
                                if($is_same_row == 0)
                                {
                                    $cleaned_videos[] = $videos_array[$i][$j];
                                }

                            }
                        }
                    }
                    $model['videos'] = $cleaned_videos;
                    $model['tags_for_searching'] = DB::table('tags')->where('user_id','=',$user_id)->get();
                    return view('users.videos.index', $model);
                }
                else if($type == "all")
                {
                    // $Tags_formate = '[';
                    // for($i = 0; $i < count($tags); $i++)
                    // {
                    //     $Tags_formate .= '"';
                    //     $Tags_formate .= $tags[$i];
                    //     $Tags_formate .= '"';
                    //     $comma_count = count($tags) - 1;
                    //     if($i != $comma_count)
                    //     {
                    //         $Tags_formate .= ',';
                    //     }
                    // }
                    // $model['videos'] = DB::table('videos')->where([['name', 'LIKE', '%' . $name . '%'],['tag', 'LIKE', $Tags_formate.'%'],['user_id','=',$user_id]])->get();
                    $model['videos'] = DB::table('videos')->where([['name', 'LIKE', '%' . $name . '%'],['user_id','=',$user_id],['is_mtu8','=',$videosTypeVal]])->where(function($query) use ($tags){
                        foreach($tags as $key => $value){
                            $query->where('tag','LIKE','%'.$value.'%');
                        }
                    })->get();
                    $model['tags_for_searching'] = DB::table('tags')->where('user_id','=',$user_id)->get();
                    return view('users.videos.index', $model);
                }
            }
            else if($tags == null && $name == null)
            {
                $model['videos'] = DB::table('videos')->where([['user_id','=',$user_id],['is_mtu8','=',$videosTypeVal]])->get();
                $model['tags_for_searching'] = DB::table('tags')->where('user_id','=',$user_id)->get();
                return view('users.videos.index', $model);
            }
        }


    }

    public function show_single_video(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $model['videos'] = DB::table('videos')->where('id', '=', $id)->get();
        $model['tags_for_searching'] = DB::table('tags')->where('user_id', '=', $user_id)->get();
        return view('users.videos.index', $model);
    }

    public function addM3u8Link(Request $request)
    {
        $m3u8Link = $request->post("m3u8Link");
        $userId = Auth::user()->id;
        $model = new video;
        $model->image_url = $m3u8Link;
        $model->user_id = $userId;
        $model->name = "stream.m3u8";
        $model->is_mtu8 = 1;
        $model->save();
        return redirect('/manage/videos');
    }

    public function embed(Request $request, $id = null)
    {
        if($id != null)
        {
            $channelId = $id;
            $model = Channel::find($channelId);
            if($model != null)
            {
                $model['channelInfo'] = Channel::find($channelId);
                return view("embed.index",$model);
            }
            else
            {
                return view("embed.index");
            }
        }
        else
        {
            return view("embed.index");
        }
    }


    public function getCurrentVideoAndTime(Request $request)
    {
        $videoArray = array();
        $channelId = $request->post('channelId');
        $model = DB::table('channels')->where('id','=',$channelId)->get();
        $currentVideoIndex = $model[0]->currentVideo;
        $videosArray = explode(",",$model[0]->videos);
        $timeZone = $model[0]->timeZone;
        date_default_timezone_set($timeZone);
        if(isset($videosArray[$currentVideoIndex]))
        {
            $currentVideoID = $videosArray[$currentVideoIndex];
        }
        else
        {
            $currentVideoID = $videosArray[0];
        }

        $currentVideoTime = $model[0]->currentVideoTime;
        $lastUpdatedTime = $model[0]->lastVideoUpdatedTime;
        $currentVideoDateAndTime = date('Y-m-d H:i:s');
        $timeDifference = strtotime($currentVideoDateAndTime) - strtotime($lastUpdatedTime);
        for($i = 1; $i <= $timeDifference; $i++)
        {
            $this->setVideoTiming($channelId);
        }
        $videoArray = array();
        $channelId = $request->post('channelId');
        $model = DB::table('channels')->where('id','=',$channelId)->get();
        $currentVideoIndex = $model[0]->currentVideo;
        $videosArray = explode(",",$model[0]->videos);
        $timeZone = $model[0]->timeZone;
        date_default_timezone_set($timeZone);
        if(isset($videosArray[$currentVideoIndex]))
        {
            $currentVideoID = $videosArray[$currentVideoIndex];
        }
        else
        {
            $currentVideoID = $videosArray[0];
        }

        $currentVideoTime = $model[0]->currentVideoTime;
        $lastUpdatedTime = $model[0]->lastVideoUpdatedTime;
        $videoRecord = DB::table('videos')->where('id','=',$currentVideoID)->get();
        if(count($videoRecord) > 0)
        {
            if($videoRecord[0]->is_mtu8 == 1)
            {
                $videoUrl = $videoRecord[0]->image_url;
            }
            else
            {
                $videoUrl = url('/uploads') . '/' . $videoRecord[0]->image_url;
            }
            $videoArray['name'] = $videoRecord[0]->name;
            $videoArray['url'] =  $videoUrl;
            $videoArray['is_m3u8'] = $videoRecord[0]->is_mtu8;
            $videoArray['currentTime'] = $currentVideoTime;
            $videoArray['videoIndex'] = $currentVideoIndex;
        }
        else
        {
            $videoArray['name'] = "";
            $videoArray['url'] =  "";
            $videoArray['is_m3u8'] = "";
            $videoArray['currentTime'] = "";
            $videoArray['videoIndex'] = "";
        }
        return $videoArray;
    }

    public function setVideoTiming($channelId)
    {
        $model = DB::table('channels')->where('id','=',$channelId)->get();
        $timeZone = $model[0]->timeZone;
        date_default_timezone_set($timeZone);
        $videos = $model[0]->videos;
        $channelId = $model[0]->id;
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

    public function loopChannelDynamicPlaylist(Request $request)
    {
        $channelId = $request->post('channelId');
        $model = DB::table('channels')->where("id","=",$channelId)->get();
        $loopChannelPlaylistHTML = "";
        $previouseVideoDuration = 0;
        $previouseVideoStartingTime = 0;
        if($model != null)
        {
            $videos = $model[0]->videos;
            $timeZone = $model[0]->timeZone;
            date_default_timezone_set($timeZone);
            if(($videos != null) && ($videos != ""))
            {
                $videosArray = explode(",",$videos);
                $currentVideoIndex = $model[0]->currentVideo;
                for($i = 1; $i <= 20; $i++)
                {
                    if($i == 1)
                    {
                        $videoId = $videosArray[$currentVideoIndex];
                    }
                    else
                    {
                        $currentVideoIndex = $currentVideoIndex + 1;
                        $lastVideoIndex = count($videosArray) - 1;
                        if($currentVideoIndex > $lastVideoIndex)
                        {
                            $currentVideoIndex = 0;
                        }
                        $videoId = $videosArray[$currentVideoIndex];
                    }
                    $videoInfo = DB::table('videos')->where("id","=",$videoId)->get();
                    $videoName = $videoInfo[0]->name;
                    $videoDuration = $videoInfo[0]->duration;
                    $videoElapsedTime = $model[0]->currentVideoTime;
                    $videoCurrentDateAndTime = date('Y-m-d H:i:s');
                    $videoStartingTime = strtotime($videoCurrentDateAndTime) - $videoElapsedTime;
                    if($i > 1)
                    {
                        $videoStartingTime = $previouseVideoStartingTime + $previouseVideoDuration + 1;
                        $previouseVideoStartingTime = $videoStartingTime;
                        $previouseVideoDuration = $videoDuration;
                        $videoStartingTime = date('h:i:s A',$videoStartingTime);
                    }
                    else
                    {
                        $previouseVideoStartingTime = $videoStartingTime;
                        $previouseVideoDuration = $videoDuration;
                        $videoStartingTime = date('h:i:s A',$videoStartingTime);
                    }
                    date_default_timezone_set($timeZone);
                    $videoDuration = (int)$videoDuration;
                    $loopChannelPlaylistHTML .= '<div class="row container" style="background: rgba(0,0,50,0.5);width: 103%;height: 15%;margin-left:0;padding: 0;margin-top: 1%;">
                        <div style="width: 30%;height: 100%;justify-content: center;align-items: center;display: flex;">
                            <img src="'.asset("admin_assets/assets/img/video-preview-icon.png").'" style="height: 80%" alt="">
                        </div>
                        <div style="width: 70%;height: 100%;justify-content: center;align-items:center;display: flex;">
                            <a href="javascript:void(0)"  style="width: 100%; white-space: nowrap; display: inherit;color: white;pointer-events:none;">
                                <span style="overflow: hidden !important; text-overflow: ellipsis;">
                                    '.$videoName.'
                                    <br>
                                    <span>';
                                    if($i == 1)
                                    {
                                        $loopChannelPlaylistHTML .= "NOW PLAYING";
                                    }
                                    else
                                    {
                                        $loopChannelPlaylistHTML .= $videoStartingTime;
                                    }
                                    $loopChannelPlaylistHTML .= '</span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <br>';
                }
            }
        }
        return $loopChannelPlaylistHTML;
    }

    public function setNextVideoAndTimeOnVideoEnded(Request $request)
    {
        $channelId = $request->post("channelId");
        $model = DB::table('channels')->where('id','=',$channelId)->get();
        $videoIndex = $model[0]->currentVideo;
        $videos = $model[0]->videos;
        $timeZone = $model[0]->timeZone;
        $videosArray = explode(",",$videos);
        $lastVideoIndex = count($videosArray) - 1;
        $newVideoIndex = $videoIndex + 1;
        if($newVideoIndex > $lastVideoIndex)
        {
            $newVideoIndex = 0;
        }
        date_default_timezone_set($timeZone);
        $lastUpdatedTime = date("Y-m-d H:i:s");
        $channelObj = Channel::find($channelId);
        $channelObj->lastVideoUpdatedTime = $lastUpdatedTime;
        $channelObj->currentVideo = $newVideoIndex;
        $channelObj->currentVideoTime = 1;
        $channelObj->save();
    }

    function scheduleVideo(Request $request, $id = null)
    {
        if($id != null)
        {
            $model["data"] = Channel::find($id);
            $model["video"] = video::where([["is_mtu8","=","0"],["user_id","=",Auth::user()->id]])->get();
            if($model["data"] != null)
            {
                return view("users.channel.schedule.schedule",$model);
            }
        }
        return view("users.channel.schedule.schedule");
    }
    function ajaxScheduleVideo(Request $request)
    {
        $channelId = $request->post('channelId');
        $scheduleTime = $request->post('scheduleTime');
        $selectedTab = $request->post("selectedTab");
        $day = "all";
        if($selectedTab != '' && $selectedTab != null)
        {
            $day = $selectedTab;
        }
        if($request->post("selectedSchedulerId"))
        {
            $selectedSchedulerId = $request->post("selectedSchedulerId");
            $videoId = DB::table('schedule_videos')->select(
                'video_id'
            )->where(
                'id','=',$selectedSchedulerId
            )->first()->video_id;
            // $videoId = $videoId->video_id;
            $duration = video::select(
                'duration'
            )->where(
                'id','=',$videoId
            )->first();
            $endTime = strtotime($scheduleTime) + (int)$duration->duration;
            $endTime = date('H:i:s',$endTime);
            $response = DB::table('schedule_videos')->where(
                'id','=',$selectedSchedulerId,
            )->update([
                'schedule_time' => $scheduleTime,
                'end_time' => $endTime,
            ]);
            return $response;
        }
        else
        {
            $videoId = $request->post('videoId');
            $duration = video::select(
                'duration'
            )->where(
                'id','=',$videoId
            )->first();
            $endTime = strtotime($scheduleTime) + (int)$duration->duration;
            $endTime = date('H:i:s',$endTime);
            $insertedId = DB::table('schedule_videos')->insertGetId([
                'schedule_time' => $scheduleTime,
                'end_time' => $endTime,
                'video_id' => $videoId,
                'channel_id' => $channelId,
                'schedule_day' => $day,
                'user_id' => Auth::user()->id
            ]);
            return $insertedId;
        }
    }


    function previewCustomSchedule(Request $request)
    {
        $selectedSchedulerId = $request->post("selectedSchedulerId");
        $scheduleTime = $request->post('scheduleTime');
        $videoId = DB::table('schedule_videos')->select(
            'video_id'
        )->where(
            'id','=',$selectedSchedulerId
        )->first()->video_id;
        // $videoId = $videoId->video_id;
        $duration = video::select(
            'duration'
        )->where(
            'id','=',$videoId
        )->first();
        $endTime = strtotime($scheduleTime) + (int)$duration->duration;
        $endTime = date('H:i:s',$endTime);
        return $endTime;
    }

    function setScheduleRow(Request $request)
    {
        $channelId = $request->post('channelId');
        $scheduleRowHTML = $request->post('scheduleRowHTML');
        $videoCount = $request->post('videoCount');
        $model = DB::table('schedule_record')->where([
            ['scheduledChannelId','=',$channelId],
            ['userId','=',Auth::user()->id]
        ])->get();
        if(count($model) > 0)
        {
            $newModel = DB::table('schedule_record')->where(
                'id' ,'=', $model[0]->id
            )->update([
                'scheduledChannelId' => $channelId,
                'scheduleContainerHTML' => $scheduleRowHTML,
                'newVideosStartingCount' => $videoCount
            ]);
        }
        else
        {
            $newModel = DB::table('schedule_record')->insert([
                'scheduledChannelId' => $channelId,
                'scheduleContainerHTML' => $scheduleRowHTML,
                'newVideosStartingCount' => $videoCount,
                'userId' => Auth::user()->id
            ]);
        }
        return 1;
    }

    function getScheduleRow(Request $request)
    {
        $channelId = $request->post('channelId');
        $scheduleHTML = '';
        $data = array();
        $data["scheduleHTML"] = '';
        $data["videoCount"] = 0;

        $model = DB::table('schedule_record')->where([
            ['scheduledChannelId','=',$channelId],
            ['userId','=',Auth::user()->id]
        ])->get();
        if(count($model) > 0)
        {
            $scheduleHTML = $model[0]->scheduleContainerHTML;
            $updatedVideoCount = $model[0]->newVideosStartingCount;
            $data["scheduleHTML"] = $scheduleHTML;
            $data["videoCount"] = $updatedVideoCount;
        }
        return $data;
    }

    function getSpecificVideoScheduleTime(Request $request)
    {
        $selectedSchedulerId = $request->post("selectedSchedulerId");
        $model = DB::table('schedule_videos')->where(
            'id','=',$selectedSchedulerId
        )->get();
        return $model;
    }

    function removeSpecificVideoScheduleTime(Request $request)
    {
        $selectedSchedulerId = $request->post('selectedSchedulerId');
        $response = DB::table('schedule_videos')->where(
            'id','=',$selectedSchedulerId
        )->delete();
        return $response;
    }
}


