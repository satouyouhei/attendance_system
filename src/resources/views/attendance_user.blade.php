@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <link rel="stylesheet" href="{{ asset('css/attendance_search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection
@section('content')
    <form class="header__wrap" action="{{ route('per/user') }}" method="post">
        @csrf
            <p class="header__text">{{ $displayUser }} さんの勤怠表</p>
        <div class="search__item">
            <input class="search__input" type="text" name="search_name" placeholder="名前検索" value="{{ $searchParams['name'] ?? '' }}" list="user_list">
            <datalist id="user_list">
                @if($userList)
                    @foreach( $userList as $user)
                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                    @endforeach
                @endif
            </datalist>
            <button class="search__button">検索</button>
        </div>
    </form>

    <div class="table__wrap">
        <table class="attendance__table">
            <tr class="table__row">
                <th class="table__header">日付</th>
                <th class="table__header">勤務開始</th>
                <th class="table__header">勤務終了</th>
                <th class="table__header">休憩時間</th>
                <th class="table__header">勤務時間</th>
            </tr>
            @foreach ($timestamps as $timestamp)
                <tr class="table__row">
                    <td class="table__item">{{ $timestamp->date_work }}</td>
                    <td class="table__item">{{ $timestamp->punchIn }}</td>
                    <td class="table__item">{{ $timestamp->punchOut }}</td>
                    <td class="table__item">{{ $timestamp->rest_total }}</td>
                    <td class="table__item">{{ $timestamp->work_total }}</td>
                </tr>
            @endforeach
        </table>
        {{ $timestamps->
            links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection