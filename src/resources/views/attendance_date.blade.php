@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection

@section('content')
    <form class="header__wrap" action="{{ route('attendance/date') }}" method="post">
        @csrf
        <button class="date__change-button" name="prevDate"><</button>
        <input type="hidden" name="displayDate" value="{{$append_param['displayDate'] }}">
        <p class="header__text">{{ $append_param['displayDate']}}</p>
        <button class="date__change-button" name="nextDate">></button>
    </form>

    <div class="table__wrap">
        <table class="timestamps__table">
            <tr class="table__row">
                <th class="table__header">名前</th>
                <th class="table__header">勤務開始</th>
                <th class="table__header">勤務終了</th>
                <th class="table__header">休憩時間</th>
                <th class="table__header">勤務時間</th>
            </tr>
            @foreach ($timestamps_list as $timestamp)
                <tr class="table__row">
                    <td class="table__item">{{ $timestamp->name }}</td>
                    <td class="table__item">{{ $timestamp->punchIn }}</td>
                    <td class="table__item">{{ $timestamp->punchOut }}</td>
                    <td class="table__item">{{ $timestamp->rest_total }}</td>
                    <td class="table__item">{{ $timestamp->work_total }}</td>
                </tr>
            @endforeach
        </table>
        {{ $timestamps_list->links('vendor.pagination.custom') }}
    </div>
@endsection