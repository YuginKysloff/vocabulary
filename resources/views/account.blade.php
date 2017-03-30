@extends('layouts.app')

@section('content')
<div class="page__wrapper">
    <header>
        <h1 class="page__title">Account</h1>
        <table class="table">
            <tbody class="table__body">
                <tr class="table__td">
                    <td class="table__td">Login</td>
                    <td class="table__td">{{ ucfirst(auth()->user()->name) }}</td>
                </tr>
                <tr class="table__td">
                    <td class="table__td">IP</td>
                    <td class="table__td">{{ $result['ip'] }}</td>
                </tr>
                <tr class="table__td">
                    <td class="table__td">User Agent</td>
                    <td class="table__td">{{ $result['userAgent'] }}</td>
                </tr>
                <tr class="table__td">
                    <td class="table__td">Country</td>
                    <td class="table__td">{{ $result['country']->country }}</td>
                </tr>
            </tbody>
        </table>
        <p class="page__desc" id="qwe">Your favorite words in JSON format</p>
    </header>
    <div class="page__content">
        @if(is_object($result['hashes']))
            {{ $result['hashes']->content() }}
        @else
            <div class="page__message">{{ $result['hashes'] }}</div>
        @endif
    </div>
</div>
@endsection
