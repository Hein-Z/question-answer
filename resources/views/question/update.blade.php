@extends('master')
@section('content')
    <div class="py-5">
        <div class="text-center h2 font-weight-bolder"> Create Question</div>
        <form action="{{route('question.update',$question->id)}}" class="form-group" method="post">
            @method('PUT')
            @csrf
            @include('question._questionForm',['buttonText'=>'Update','title'=>$question->title,'body'=>$question->body])
        </form>
    </div>
@endsection
