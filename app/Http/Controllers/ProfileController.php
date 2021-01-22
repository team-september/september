<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Career;
use App\Models\Skill;
use App\Models\Purpose;
use App\Models\Url;
use App\Models\Profile_url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function show()
    {
        $login = \Auth::user();
        $sub = $login->sub;

        $user = User::where('sub',$sub)->first();

        //データがない場合
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

            //url tableにデータを作る
            for($i =1;$i<5;$i++){
                $url = new Url;
                $url ->url_type = $i;
                $url->save();

                $url_id =$url->id;
                //profile_urlへデータを入れる
                $prof_url = new Profile_url;
                $prof_url ->profile_id = $profile->id;
                $prof_url ->url_id= $i;
                $prof_url->save();
            }
        }

        //入力されていた値の取得
        $profile = Profile::find($user->id); 
        list($twitter,$github,$website,$others) = $this->urlSearch($profile);
        $career = Career::find($profile->career_id);

        $purposes = array(); 
        foreach ($profile->purposes as $purpose){
            $purposes[] = $purpose->purpose;
        }

        $skills = array();
        foreach ($profile->skills as $skill){
            $skills[] = ['skill_type'=>$skill->skill_type, 'skill_name'=>$skill->skill_name]; 
        }

        return view('profile.index', compact('user','profile','career','skills','purposes','twitter','github','website','others'));
    }

    public function edit($id)
    {
        $old_profile  = Profile::find($id);
        $old_user = User::find($id);
        list($twitter,$github,$website,$other) = $this->urlSearch($old_profile);

        $careers = Career::all();
        $skills =Skill::all();
        $purposes = Purpose::all();

        //入力されていた値の取得
        $old_careers = Career::find($old_profile->career_id);
        $old_purposes =  array();
        foreach ($old_profile->purposes as $purpose){
            $old_purposes[] = $purpose->id;
        }
        $old_skills = array();
        foreach ($old_profile->skills as $skill){
            $old_skills[] = $skill->id; 
        }
        
        return view('profile.edit',compact('old_profile','old_user','old_careers','old_purposes','old_skills','careers','skills','purposes','twitter','github','website','other'));
    }

    public function update(Request $request,$id)
    {
        $user =[
            'name' =>$request->name,
        ];
        User::find($id)->update($user);

        $profiles=[
            'goal' =>$request->goal,
            'career_id'=>$request->career,           
        ];
        Profile::where('user_id',$id)->update($profiles);

        //purpose更新
        $profile = Profile::where('user_id',$id)->firstOrFail();
        $pid = $profile->id;
        $profile ->purposes()->sync($request->get('purpose',[]));

        //skill更新
        $profile ->skills()->sync($request->get('skill',[]));

        //urls更新
        $profile_urls = Profile_url::where('profile_id',$pid)->get();
        foreach ($profile_urls as $profile ){
           $url_id = $profile->url_id;
           $urls = Url::where('id',$url_id)->first();

            //URL種別; //1.twitter, 2,github, 3,website, 4.others
           if($urls->url_type === 1){
            $urls->url = $request->twitter;
            $urls->save();
          }
           
           if($urls->url_type === 2){
             $urls->url = $request->github;
             $urls->save();
           }

           if($urls->url_type === 3){
            $urls->url = $request->website;
            $urls->save();
          }

          if($urls->url_type === 4){
            $urls->url = $request->other;
            $urls->save();
          }
        }
        return redirect()->route('profile')->with('success','登録出来ました');
    }

    //urlの取得
    public function urlSearch($profile){
        $profile_urls = Profile_url::where('profile_id',$profile->id)->get();
        foreach ($profile_urls as $profile_url ){
            $url_id = $profile_url->url_id;
            $urls = Url::where('id',$url_id)->first();

            //URL種別; //1.twitter, 2,github, 3,website, 4.others
            if($urls->url_type === 1){
                $twitter = $urls->url;
            }
            if($urls->url_type === 2){
                $github = $urls->url;
            }
            if($urls->url_type === 3){
                $website = $urls->url;
            }
            if($urls->url_type === 4){
                $other = $urls->url;
            }
        }
        return array($twitter,$github,$website,$other);
    }
}
