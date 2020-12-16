@extends('layouts.master')
@section('content')
    <div class="py-5">
        <div class="text-center h2 font-weight-bolder"> Edit Answer</div>
        <form action="{{route('question.answer.update',[$question->slug,$answer])}}" class="form-group" method="post">
            @method('PUT')
            @csrf
            <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="answer"
                      placeholder="answer">{{$answer->body?old('body')??$answer->body:''}}</textarea>
            <button class="btn btn-block btn-primary my-2"> Edit Answer </button>
        </form>
    </div>
@endsection
