<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Career;
use App\Models\Skill;
use App\Models\Purpose;
use App\Models\ProfileUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $login = \Auth::user();
        $sub = $login->sub;


        $user = User::where('sub',$sub)->first();
        
        if(is_null($user)){
            $nickname = $login->nickname;
            $name =$login->name;
            $picture =$login->picture;
    
            $user = new User;
            $user ->sub = $sub;
            $user ->is_mentor = 'f';
            $user ->nickname = $nickname;
            $user ->name = $name;
            $user ->picture = $picture;
            $user->save();

            $profile =new Profile;
            $profile ->user_id = $user->id;
            $profile->save();    
        }

        $profile =Profile::findOrFail($user->id);
        $careers = Career::all();
        $skills =Skill::all();
        $purposes = Purpose::all();

        return view('profile.index', compact('user','profile','careers','skills','purposes'));
    }

    public function edit($id)
    {
        $old_profile  = Profile::find($id);
        $old_user = User::find($id);
        
        //todo:元々入力されていたurlを取る未完成
        // $url_id = $old_profile -> url_id;
        // $old_url = ProfileUrl::find($url_id);

        $careers = Career::all();
        $skills =Skill::all();
        $purposes = Purpose::all();

        return view('profile.edit',compact('old_profile','old_user','careers','skills','purposes'));
    }

    //更新
    public function update(Request $request,$id)
    {
        $user =[
            'name' =>$request->name,
        ];
        User::find($id)->update($user);

        $profile=[
            'goal' =>$request->goal,
            'career_id'=>$request->career,           
        ];
        Profile::where('user_id',$id)->update($profile);

        $profile_purposes=[
            'profile_id' =>$id,
            'purpose_id' =>$request->purpose,
        ];
//        $profile_purposes->

        return redirect()->route('profile');
    }

}
