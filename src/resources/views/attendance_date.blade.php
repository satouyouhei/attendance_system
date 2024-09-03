@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <!-- <link rel="stylesheet" href="/css/app.css"> -->
@endsection

@section('content')
    <form class="header__wrap" action="{{ route('per/date') }}" method="post">
        @csrf
        <button class="date__change-button" name="prevDate"><</button>
        <input type="hidden" name="displayDate" value="{{ $displayDate }}">
        <p class="header__text">{{ $displayDate->format('Y-m-d') }}</p>
        <button class="date__change-button" name="nextDate">></button>
    </form>

    <div class="table__wrap">
        <table class="attendance__table">
            <tr class="table__row">
                <th class="table__header">名前</th>
                <th class="table__header">勤務開始</th>
                <th class="table__header">勤務終了</th>
                <th class="table__header">休憩時間</th>
                <th class="table__header">勤務時間</th>
            </tr>
            @foreach ($timestamps as $timestamp)
                <tr class="table__row">
                    <td class="table__item">{{ $timestamp->user->name }}</td>
                    <td class="table__item">{{ $timestamp->punchIn }}</td>
                    <td class="table__item">{{ $timestamp->punchOut }}</td>
                    <td class="table__item">{{ $timestamp->rest_total }}</td>
                    <td class="table__item">{{ $timestamp->work_total }}</td>
                </tr>
            @endforeach
        </table>
        {{ $timestamps->appends(['displayDate' => $displayDate])->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection