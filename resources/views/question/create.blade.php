@extends('master')
@section('content')
    <div class="py-5">
        <div class="text-center h2 font-weight-bolder"> Create Question</div>
        <form action="{{route('question.store')}}" class="form-group" method="post">
            @csrf
            <div class="form-group">
                <label for="title ">Question</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                       placeholder="title" value="{{old('title')}}">
                @error('title')
                <div class=" text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group ">
                <label for="body">Explain your question</label>
                <textarea type="text" class="form-control @error('body') is-invalid @enderror" placeholder="explain" name="body" id="body">{{old('body')}}</textarea>
                @error('body')
                <div class=" text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-outline-info btn-block">Post</button>
        </form>
    </div>
@endsection
