@extends('layouts.master')
@section('content')
    <div class="py-5">
        <div class="text-center h2 font-weight-bolder"> Edit Question</div>
        <form action="{{route('question.update',$question->slug)}}" class="form-group" method="post">
            @method('PUT')
            @csrf
            @include('question._questionForm',['buttonText'=>'Update','title'=>$question->title,'body'=>$question->body])
        </form>
    </div>
@endsection
