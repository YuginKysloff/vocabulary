@extends('layouts.app')

@section('content')
<div class="page__wrapper">
    <header>
        <h1 class="page__title">Vocabulary list</h1>
        <p class="page__desc">To start encoding select algorithm in line of desired word and press encode button.</p>
        <p class="page__desc">To see your favorite words click on your name in upper menu.</p>
    </header>
    <form action="{{ route('hash') }}" method="post">
        {{ csrf_field() }}
        <table class="table">
            <thead class="table__head">
                <tr class="table__tr">
                    <th class="table__td">#</th>
                    <th class="table__td">Word</th>
                    <th class="table__td">Select words</th>
                </tr>
            </thead>
            <tbody class="table__body">
                @foreach($vocabulary as $word)
                    <tr class="table__tr">
                        <td class="table__td">{{ $word->id }}</td>
                        <td class="table__td">{{ $word->word }}</td>
                        <td class="table__td">
                            <input type="checkbox" name="selection[{{ $word->id }}]" value="{{ $word->word }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="submit__wrapper">
            <select name="algorithm" class="select">
                <option value="0" selected disabled>none</option>
                @foreach($algorithms as $algorithm)
                    <option value="{{ $algorithm->id }}">{{ $algorithm->name }}</option>
                @endforeach
            </select>
            <input class="input__submit" type="submit" name="submit" value="ENCODE">
        </div>
    </form>
    {{ $vocabulary->links() }}
</div>
@endsection
