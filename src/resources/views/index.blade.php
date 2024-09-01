@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="header__wrap">
        <p class="header__text">
            {{ Auth::user()->name }}さんお疲れ様です！
        </p>
    </div>

    <form class="form__wrap" action="{{ route('punch') }}" method="post">
        @csrf
        <div class="form__item">
            @if(Auth::user()->scene == 0)
                <button class="form__item-button" type="submit" name="punchIn">勤務開始</button>
            @else
                <button class="form__item-button" type="submit" name="punchIn" disabled>勤務開始</button>
            @endif
        </div>
        <div class="form__item">
            @if(Auth::user()->scene == 1)
                <button class="form__item-button" type="submit" name="punchOut">勤務終了</button>
            @else
                <button class="form__item-button" type="submit" name="punchOut" disabled>勤務終了</button>
            @endif
        </div>
        <div class="form__item">
            @if(Auth::user()->scene == 1)
                <button class="form__item-button" type="submit" name="breakIn">休憩開始</button>
            @else
                <button class="form__item-button" type="submit" name="breakIn" disabled>休憩開始</button>
            @endif
        </div>
        <div class="form__item">
            @if(Auth::user()->scene == 2)
                <button class="form__item-button" type="submit" name="breakOut">休憩終了</button>
            @else
                <button class="form__item-button" type="submit" name="breakOut" disabled>休憩終了</button>
            @endif
        </div>
    </form>
@endsection