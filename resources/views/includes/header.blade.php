<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('home') }}">September</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="{{ route('home') }}">ホーム <span
                        class="sr-only">(current)</span></a>
                @if (Route::has('login'))
                    @auth
                        <a class="nav-item nav-link" href="{{ route('application.index') }}">
                            応募一覧
                            @if( (new \App\Repositories\User\UserEQRepository())->getUserBySub(\Illuminate\Support\Facades\Auth::id())->is_mentor && $unreadApplicationCount = (new \App\Repositories\Application\ApplicationEQRepository())->countUnreadApplications())
                                <span class="badge badge-notify rounded-circle bg-primary text-white">
                                    {{ $unreadApplicationCount }}
                                </span>
                            @endif
                        </a>
                        <a class="nav-item nav-link" href="{{ route('profile.index') }}">
                            プロフィール
                            @if( (! (new \App\Repositories\User\UserEQRepository())->getUserBySub(\Illuminate\Support\Facades\Auth::id())->is_mentor) && $unreadApprovalCount = (new \App\Repositories\Application\ApplicationEQRepository())->countUnreadApproval())
                                <span class="badge badge-notify rounded-circle bg-primary text-white">
                                    {{ $unreadApprovalCount }}
                                </span>
                            @endif
                        </a>
                        <a class="nav-item nav-link" href="{{ route('logout') }}">ログアウト</a>
                    @else
                        <a class="nav-item nav-link" href="{{ route('login') }}">ログイン</a>
                    @endauth
            </div>
            @endif
        </div>
    </nav>
</header>
