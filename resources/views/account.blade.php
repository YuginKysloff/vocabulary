@extends('layouts.app')

@section('content')
<div class="page__wrapper">
    <header>
        <h1 class="page__title">Account of {{ ucfirst(auth()->user()->name) }}</h1>
        <p class="page__desc" id="qwe">Here you can see your favorite words in JSON format</p>
    </header>
    <div class="page__content">
        @if(is_object($result))
            {{ $result->content() }}
        @else
            <div class="page__message">{{ $result }}</div>
        @endif
    </div>
</div>
@endsection
