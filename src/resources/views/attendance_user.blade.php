@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <link rel="stylesheet" href="{{ asset('css/attendance_search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection
@section('content')
    <form class="header__wrap" action="{{ route('attendance/user') }}" method="post">
        @csrf

        @if($displayUser != null)
            <p class="header__text">{{ $displayUser }} さんの勤怠表</p>
            <input type="hidden" name="search_name" value="{{$displayUser}}">
        @else
            <p class="header__text">ユーザーを選択してください</p>
        @endif

        <div class="search__item">
            <input class="search__input" type="text" name="search_name" value="{{ $searchParams['name'] ?? '' }}"placeholder="名前検索"  list="user_list" >
            <datalist id="user_list">
                @if($userList)
                    @foreach($userList as $user)
                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                    @endforeach
                @endif
            </datalist>
            <button class="search__button">検索</button>
        </div>
    </form>

    <div class="table__wrap">
        <table class="timestamps__table">
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
         {{ $timestamps->appends(request()->query())->links('vendor.pagination.custom') }}

@endsection