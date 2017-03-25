@extends('layouts.app')

@section('content')
<div class="page__wrapper">
    <header>
        <h1 class="page__title">Vocabulary list</h1>
        <p class="page__desc">You should just select type of algorithm in line of desired word and press encode button.</p>
    </header>
    <form action="{{ route('vocabulary') }}" method="post">
        {{ csrf_field() }}
        <table class="table">
            <thead class="table__head">
                <tr class="table__tr">
                    <th class="table__td">#</th>
                    <th class="table__td">Word</th>
                    <th class="table__td">Select algorithm</th>
                    <th class="table__td">Operation</th>
                </tr>
            </thead>
            <tbody class="table__body">
                @foreach($vocabulary as $word)
                    <tr class="table__tr">
                        <td class="table__td">{{ $word->id }}</td>
                        <td class="table__td">{{ $word->word }}</td>
                        <td class="table__td">
                            <select name="select{{ $word->id }}" class="select">
                                <option value="0" selected disabled>none</option>
                                @foreach($algorithms as $algorithm)
                                    <option value="{{ $algorithm->id }}">{{ $algorithm->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="table__td"><input class="input__submit" type="submit" name="submit{{ $word->id }}" value="Encode"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    {{ $vocabulary->links() }}
</div>
@endsection
