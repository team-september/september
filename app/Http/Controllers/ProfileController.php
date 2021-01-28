<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\MultipleProfileUpdateRequest;
use App\Models\User;
use App\Models\Career;
use App\Services\UrlService;
use App\Models\Purpose;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    public function index()
    {
        $auth0User = Auth::user();
        $user = User::findBySub($auth0User->sub);

        //データがない場合ユーザー関連情報を作成
        if (empty($user)) {
            $user_info = [
                'sub' => $auth0User->sub,
                'nickname' => $auth0User->nickname,
                'name' => $auth0User->name,
                'picture' => $auth0User->picture,
            ];

            $user = User::make($user_info);
            // UserObserverにて関連レコードを作成
        }

        //入力されていた値の取得
        $profile = $user->profile;
        $urls = (new UrlService($profile))->findUrls();
        $career = $profile->career;
        $purposes = $profile->purposes;
        $skills = $profile->skills;
        return view(
            'profile.index',
            compact('user', 'profile', 'urls', 'career', 'purposes', 'skills')
        );
    }

    public function edit($id)
    {
        $user = User::find($id);
        $profile = $user->profile;
        $urls = (new UrlService($profile))->findUrls();
        $user_career = $profile->career;
        $careers = Career::all();
        $purposes = Purpose::all();
        $careers = Career::all();
        $skills = Skill::all();
        $user_purposes = $profile->purposes;
        $user_skills = $profile->skills;

        return view(
            'profile.edit',
            compact('user', 'profile', 'urls', 'user_career', 'careers', 'user_purposes', 'purposes', 'user_skills', 'skills')
        );
    }

    public function update(MultipleProfileUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $profile = $user->profile;
        $urls = $profile->urls;

        DB::transaction(
            function () use ($request, $user, $profile, $urls) {
                $user->modify($request);
                $profile->modify($request);
                foreach ($urls as $index => $url) {
                    $url->modify($request, $index);
                }
            }
        );

        return redirect()->route('profile.index')->with('success', '更新しました');
    }
}
