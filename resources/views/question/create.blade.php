@extends('master')
@section('content')
    <div class="py-5">
        <div class="text-center h2 font-weight-bolder"> Create Question</div>
        <form action="{{route('question.store')}}" class="form-group" method="post">
            @csrf
            @include('question._questionForm',['buttonText'=>'Post'])
        </form>
    </div>
@endsection
