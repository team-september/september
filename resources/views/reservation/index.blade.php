@extends('layouts.base')

@section('content')
<style>
    .past {
        background:silver;
    }
    .today {
        background:gold;
    }
    .sat {
        color:blue;
    }
    .sun {
        color:red;
    }
</style>
<form action="{{ route('reservation.update') }}" method="POST">
    @csrf
    @method('POST')
    <section id="calendar" class="flex-center position-ref full-height">
        <div class="container">
            <div class="text-center">
                <a href="?ym={{ $prev }}">&lt;&lt;</a>
                <span class="month">{{ $current }}</span>
                <a href="?ym={{ $next }}">&gt;&gt;</a>
            </div>
            {!! $calendar !!}
        </div>
        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-primary col-md-4"> 更新</button>
        </div>
    </section>
</form>
@endsection