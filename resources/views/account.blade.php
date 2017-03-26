@extends('layouts.app')

@section('content')
<div class="page__wrapper">
    <header>
        <h1 class="page__title">Hash of selected word</h1>
        <p class="page__desc" id="qwe">You can store results for later use.</p>
    </header>
    <table class="table">
        <thead class="table__head">
            <tr class="table__tr">
                <th class="table__td">#</th>
                <th class="table__td">Word</th>
                <th class="table__td">Algorithm</th>
                <th class="table__td">Hash</th>
                <th class="table__td">Operation</th>
            </tr>
        </thead>
        <tbody class="table__body results__block">
            @if(is_array($result))
                @foreach($result as $key => $item)
                    <tr class="table__tr">
                        <td class="table__td">{{ $key }}</td>
                        <td class="table__td">{{ $item['word']['word'] }}</td>
                        <td class="table__td">{{ $item['algorithm']['name'] }}</td>
                        <td class="table__td">{{ $item['hash'] }}</td>
                        <td class="table__td" id="answer{{ $item['word']['id'] }}">
                            <button onclick="saveWord({{ $item['word']['id'] }}, {{ $item['algorithm']['id'] }}, '{{ $item['hash'] }}')">
                                Save
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="table__tr">
                    <td class="table__td" colspan="5">{{ $result }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
