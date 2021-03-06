@extends('layouts.base')

@section('content')
    <div class="container mt-5">
        <div class="main-body">
            @if (session('success'))
                <div class="alert alert-success text-center">
                    <ul class="list-unstyled">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            @endif
            @if (session('alert'))
                <div class="alert alert-danger text-center">
                    <ul class="list-unstyled">
                        <li>{{ session('alert') }}</li>
                    </ul>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger text-center">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($justApproved)
                <div class="alert alert-success text-center">
                    <ul class="list-unstyled">
                        <li>メンティー申請が承認されています！</li>
                    </ul>
                </div>
            @endif

            @include('includes.application_modal')

            <div class="row gutters-sm">

                <div class="col-md-4 mb-3">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ $user->picture }}" alt="Admin" class="rounded-circle" width="150">
                                <div class="mt-3">
                                    <h4>{{ $user->name }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!$user->is_mentor)
                        <div class="row justify-content-center px-3 my-3">
                            <button type="button" class="btn btn-primary col-md-10" data-toggle="modal"
                                    data-target="#applicationModal"
                                    @if($application && $application->status !== config('application.status.rejected'))
                                    disabled
                                @endif
                            >
                                メンティー申請
                            </button>
                        </div>
                    @endif

                    <div class="card">

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-github mr-2 icon-inline">
                                        <path
                                            d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                                    </svg>
                                    Github
                                </h6>
                                <span class="text-secondary">{{ $urls['github']->url ?? '未登録' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="feather feather-twitter mr-2 icon-inline text-info">
                                        <path
                                            d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                    </svg>
                                    Twitter
                                </h6>
                                <span class="text-secondary">{{ $urls['twitter']->url ?? '未登録' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-monitor mr-2 icon-inline">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="2" y1="12" x2="22" y2="12"></line>
                                        <path
                                            d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                    </svg>
                                    Website
                                </h6>
                                <span class="text-secondary">{{ $urls['website']->url ?? '未登録' }}</span>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">名前</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->name }}
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">エンジニア歴</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $userCareer->year ?? '未登録' }}
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">利用目的</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $profile->goal ?? '未登録' }}
                                </div>
                            </div>
                            @if(!$user->is_mentor)
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">希望</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @if($userPurposes->isEmpty())
                                            未登録
                                        @else
                                            @foreach($userPurposes as $userPurpose)
                                                <ul class="text-secondary list-unstyled">
                                                    <li> {{ $userPurpose->purpose_name}} </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">スキル</h6>
                                </div>
                                <div class="col-sm-9 text-secondary flex">
                                    @if($userSkills->isEmpty())
                                        未登録
                                    @else
                                        @foreach($userSkills as $userSkill)
                                            @if ($userSkill['skill_type']  === 1)
                                                <span class="badge badge-warning">{{ $userSkill['skill_name'] }}</span>
                                            @elseif($userSkill['skill_type']  === 2)
                                                <span class="badge badge-success">{{ $userSkill['skill_name'] }}</span>
                                            @elseif($userSkill['skill_type']  === 3)
                                                <span class="badge badge-info">{{ $userSkill['skill_name'] }}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">その他URL</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $urls['other']->url ?? '未登録' }}
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">ユーザー種別</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->is_mentor ? "メンター" : "メンティー" }}
                                </div>
                            </div>
                            @if(!$user->is_mentor)
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">ステータス</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @if($application)
                                            @if($application->status === config('application.status.applied'))
                                                申請中（{{ $application->created_at->format("Y/m/d") }}に申請）
                                            @elseif($application->status === config('application.status.approved'))
                                                {{ "$application->approved_at より開始" }}
                                            @else
                                                未申請
                                            @endif
                                        @else
                                            未申請
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">メンター</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @if($appliedMentor)
                                            {{ $appliedMentor->name }}
                                        @else
                                            未申請
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">1on1スケジュール</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    @if($upcomingReservations->isNotEmpty())
                                        <ul class="list-unstyled">
                                            @foreach($upcomingReservations as $upcomingReservation)
                                                <li class="d-flex">
                                                    <a href="{{ route('profile.show', $upcomingReservation->user_id) }}"
                                                       target="_blank"
                                                       rel="noopener nofollow">{{ $upcomingReservation->name }}さん</a>
                                                    <div class="ml-3">{{ \Carbon\Carbon::parse($upcomingReservation->date)->format('Y/m/d') }} {{ \Carbon\Carbon::parse($upcomingReservation->time)->format('H:i') }}</div>
                                                    {{-- 前日リマインド --}}
                                                    @if(\Carbon\Carbon::parse($upcomingReservation->date)->eq(\Carbon\Carbon::today()->addDay(1)))
                                                        <span class="ml-2 badge badge-info">明日</span>
                                                    @endif
                                                    {{-- 当日リマインド --}}
                                                    @if(\Carbon\Carbon::parse($upcomingReservation->date)->eq(\Carbon\Carbon::today()))
                                                        <span class="ml-2 badge badge-danger">今日</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        該当予約なし
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row justify-content-center px-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary col-md-4"> 編集 </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
