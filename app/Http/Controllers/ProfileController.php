<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Career;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $login = \Auth::user();
        $sub = $login->sub;


        $user = User::where('sub',$sub)->first();
        
        if($user){
            return view('profile.index', compact('user'));
        }
        //todo 登録されてない場合userTableに登録
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

        return view('profile.index', compact('user'));
    }

    public function edit($id)
    {
        $old_profile  = Profile::find($id);
        $old_user = User::find($id);
        $careers = Career::all();

        //profileが存在する場合
        if($old_profile){
            return view('profile.edit',compact('old_profile','old_user','careers'));
        }

        //登録されていない場合
        $old_profile =new Profile;
        $old_profile ->user_id = $id;
        $old_profile->save();
        return view('profile.edit',compact('old_profile','old_user','careers'));
    }

    public function update(Request $request,$id)
    {
        
    }

}
