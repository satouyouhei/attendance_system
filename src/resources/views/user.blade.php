@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/attendance_search.css') }}">
@endsection

@section('content')
    <form class="header__wrap" action="{{ route('per/scene') }}" method="post">
        @csrf
        <p class="header__text">ユーザー一覧</p>
        <p class="header__text-right">{{ $displayDate->format('Y-m-d') }} 現在</p>
        <div class="search__item">
            <input class="search__input" type="text" name="scene" placeholder="勤務状態" value="{{ $searchParams['scene'] ?? '' }}" list="scene_list">
                <datalist id="scene_list">
                    <option value="3" checked>全て</option>
                    <option value="1">勤務中</option>
                    <option value="2">休憩中</option>
                    <option value="0">勤務外</option>
                </datalist>
            <button class="search__button">検索</button>
        </div>
    </form>
    <div class="table__wrap">
        <table class="attendance__table">
            <tr class="table__row">
                <th class="table__header">No.</th>
                <th class="table__header">ID</th>
                <th class="table__header">名前</th>
                <th class="table__header">Email</th>
                <th class="table__header">勤務状態</th>
            </tr>
            @php
                $pageNumber = ($users->currentPage() - 1) * $users->perPage() + 1;
            @endphp
            @foreach ($users as $user)
                <tr class="table__row">
                    <td class="table__item">{{ $pageNumber }}</td>
                    <td class="table__item">{{ $user->id }}</td>
                    <td class="table__item">{{ $user->name }}</td>
                    <td class="table__item">{{ $user->email }}</td>
                    @if ($user->scene == 1)
                        <td class="table__item">勤務中</td>
                    @elseif($user->scene == 2)
                        <td class="table__item">休憩中</td>
                    @elseif($user->scene == 0)
                        <td class="table__item">勤務外</td>
                    @endif
                </tr>
                @php
                    $pageNumber++;
                @endphp
            @endforeach
        </table>
        {{ $users->appends(request()->input())->links() }}
    </div>
@endsection