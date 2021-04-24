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
                            @if( $user->is_mentor && $unreadApplicationCount)
                                <span class="badge badge-notify rounded-circle bg-primary text-white">
                                    {{ $unreadApplicationCount }}
                                </span>
                            @endif
                        </a>
                        <a class="nav-item nav-link" href="{{ route('profile.index') }}">
                            プロフィール
                            @if( !$user->is_mentor && $unreadApprovalCount)
                                <span class="badge badge-notify rounded-circle bg-primary text-white">
                                    {{ $unreadApprovalCount }}
                                </span>
                            @endif
                        </a>
                        <div class="dropdown nav-item nav-link">
                            <a role="button" class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer">
                                1on1予約
                            </a>
                            <div class="dropdown-menu">
                                @if ($user->is_mentor)
                                    <a class="dropdown-item" href="{{ route('reservation.check') }}">申請承認</a>
                                    <a class="dropdown-item" href="{{ route('reservation.index') }}">設定</a>                                                                  
                                @else
                                    <a class="dropdown-item" href="{{ route('reservation.index') }}">予約申請</a>
                                    <a class="dropdown-item" href="{{ route('reservation.index') }}">申請確認</a>                                                                  
                                @endif
                                </a>
                            </div>
                        </div>
                        <a class="nav-item nav-link" href="{{ route('logout') }}">ログアウト</a>
                    @else
                        <a class="nav-item nav-link" href="{{ route('login') }}">ログイン</a>
                    @endauth
            </div>
            @endif
        </div>
    </nav>
</header>
