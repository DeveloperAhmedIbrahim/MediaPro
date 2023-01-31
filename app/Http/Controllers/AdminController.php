<?php

namespace App\Http\Controllers;
use App\Models\Channel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            return view('admin.dashboard');
        } else if (auth()->user()->role == 'user') {
            return view('user.dashboard');
        } else {
            return redirect()->back();
        }
    }

    public function manage_users()
    {
        $user = User::orderBy('id', 'asc')->get()->all();
        return view('admin.users.index', compact('user'));
    }

    public function insert_user(Request $request)
    {

        $user_name = $request->post('user_name');
        $user_email = $request->post('user_email');
        $user_password = $request->post('user_password');
        $user_password = Hash::make($user_password);
        $user_role = $request->post('user_role');
        $user_status = $request->post('user_status');
        if($user_role == 0)
        {
            $user_role = "user";
        }
        if($user_status == 0)
        {
            $user_status = "active";
        }
        $record_found = User::where('email', $user_email)->exists();
        if($record_found)
        {
            session()->flash('message_error','Email already existed');
            return redirect('/manage_user');
        }
        else
        {
            $model = new User();
            $model->name = $user_name;
            $model->email = $user_email;
            $model->role = $user_role;
            $model->status = $user_status;
            $model->password = $user_password;
            $model->save();
            session()->flash('message_success','New user added successfully');
            return redirect('/manage_user');
        }

    }

    public function update_user(Request $request)
    {
        $user_id = $request->post('user_id');
        $user_name = $request->post('user_name');
        $user_email = $request->post('user_email');
        $user_password = $request->post('user_password');
        if($user_password != null)
        {
            $user_password = Hash::make($user_password);
        }
        $user_role = $request->post('user_role');
        $user_status = $request->post('user_status');
        $record_found = User::where([['email','=',$user_email],['id','!=',$user_id]])->exists();
        if($record_found)
        {
            session()->flash('message_error','Email already existed');
            return redirect('/manage_user');
        }
        else
        {
            $model = User::find($user_id);
            $model->name = $user_name;
            $model->email = $user_email;
            $model->role = $user_role;
            $model->status = $user_status;
            if($user_password != null)
            {
                $model->password = $user_password;
            }
            $model->save();
            session()->flash('message_success','User info updated successfully');
            return redirect('/manage_user');
        }
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success' => 'Status change successfully.']);
    }

    public function add_users()
    {
        return view('admin.users.create');
    }

    public function edit_users()
    {
        return view('admin.users.index');
    }

    public function delete_user(Request $request,$id)
    {
        DB::table('channels')->where('user_id', $id)->delete();
        DB::table('users')->where('id', $id)->delete();
        DB::table('videos')->where('user_id', $id)->delete();
        DB::table('websites')->where('user_id', $id)->delete();
        session()->flash('message_success','User info deleted successfully');
        return redirect('/manage_user');
    }

    public function manage_channel()
    {
        $channel = Channel::orderBy('id', 'asc')->get()->all();
        return view('admin.channel.index', compact('channel'));
    }
    public function delete_channel($id)
    {
        $channels = Channel::find($id);
        $channels->delete();
        return redirect()->back();
    }
    public function admin_manage_vid(){
        return view('admin.videos.index');
    }
    public function get_user_by_id(Request $request)
    {
        $user_id =  $request->post('id');
        $model = DB::table('users')->where("id",$user_id)->get();
        return response()->json([$model]);
    }
    public function analytics(Request $request){
        return view('admin.analytics.index');
    }
    public function packages(){
        return view('admin.packages.index');
    }
    public function activate_user(Request $request, $id)
    {
        $model = User::find($id);
        $model->status = "active";
        $model->save();
        session()->flash('registered_successfully',"Email verified successfully, Now you can access dashboard.");
        return redirect('/login');
    }
    public function verifyEmailForFP(Request $request)
    {
        $email = $request->post('email');
        $userInfo = DB::table('users')->where("email","=",$email)->get();
        if(count($userInfo) == 0)
        {
            session()->flash('error',"Email address not existed.");
            return redirect('/passwordForgot');
        }
        else
        {
            $googleId = $userInfo[0]->googleId;
            if($googleId == null)
            {
                $name = $userInfo[0]->name;
                $email = $userInfo[0]->email;
                $id = $userInfo[0]->id;
                $token = Hash::make($id);
                $varification_link = url('/passwordReset') .'?token='.$token.'&mail='.$email;
                $data = ["name"=>$name,"varification_link"=>$varification_link];
                $mail_data = ["to_email_address"=>$email];
                Mail::send('auth.passwords.reset_email', $data, function ($message) use ($mail_data){
                    $message->to($mail_data["to_email_address"], 'MediaPro');
                    $message->subject('Reset Password');
                });
                session()->flash('success',"Check your email to reset your password. Don't forget to check your SPAM folder.");
                return redirect('/passwordForgot');
            }else
            {
                session()->flash('googleAccount',"1");
                return redirect('/passwordForgot');
            }

        }
    }
    public function signInGoogle(Request $request)
    {
        $googleId = $request->post("id");
        $fullName = $request->post("fullName");
        $email = $request->post("email");
        $timezone = $request->post("timezone");
        $userInfo = DB::table('users')->where("email","=",$email)->get();
        $result = 0;
        $password =  Hash::make("ASDasd123456");
        if(count($userInfo) == 0)
        {
            $modelUser = new User();
            $modelUser->name = $fullName;
            $modelUser->email = $email;
            $modelUser->role = "user";
            $modelUser->status = "active";
            $modelUser->timezone = $timezone;
            $modelUser->googleId = $googleId;
            $modelUser->password = $password;
            $result = $modelUser->save();

        }
        else
        {
            $userId =  $userInfo[0]->id;
            $modelUser = User::find($userId);
            $modelUser->name = $fullName;
            $modelUser->password = $password;
            $modelUser->save();
            $result = $modelUser->save();
        }
        $userInfo = DB::table('users')->where("email","=",$email)->get();
        // Auth::login($userInfo);
        return $userInfo;
    }

    public function passwordForgot(Request $request)
    {
        return view("auth.passwords.forgot");
    }

    public function passwordReset()
    {
        return view("auth.passwords.reset");
    }

    public function passwordChange(Request $request)
    {
        $email = $request->post('email');
        $password =  $request->post('password');
        $passwordHash = Hash::make($password);
        $userInfo = DB::table('users')->where("email","=",$email)->get();
        if(count($userInfo) > 0)
        {
            $userId = $userInfo[0]->id;
            $model = User::find($userId);
            $model->password = $passwordHash;
            $model->save();
        }
        session()->flash('registered_successfully',"Password reset successfully.");
        return redirect('/login');
    }
}
