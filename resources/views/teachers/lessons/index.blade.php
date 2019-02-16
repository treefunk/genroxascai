@extends('layouts.app')

@section('content')

    <table class="table">
        @foreach ($lessons as $lesson)
            <tr>
                <td> {{ $lesson->name }}</td>
            </tr>
        @endforeach
    </table>
@endsection
