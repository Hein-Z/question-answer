@extends('layouts.master')
@section('content')
    <div class="row ">
        <div class="col-12">
            <div
                class=" d-flex justify-content-between h1 font-weight-bolder p-3 bg-gray-100 border-bottom border-dark mx-0">
                <div> Question Detail</div>
                <div>
                    <a class="btn btn-warning" href="{{route('question.index')}}">Go Back</a>
                </div>
            </div>
        </div>
        <div class="col-12 border-dark border-bottom">
            <div class="row">
                <div class="col-md-1 col-2 py-5 px-0">
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <h5 class="font-weight-bolder">{{$question->answers_count}}</h5>
                        <div>{{ngettext('Answer','Answers',$question->answers_count)}}</div>

                        <i class="fas fa-chevron-up fa-2x"></i>
                        <div
                            class="h3 font-weight-bolder d-flex justify-content-center align-items-center mb-0 bg-success"
                            style="width: 40px; height: 40px">
                            <div class="text-center">{{$question->votes_count}}</div>
                        </div>
                        <i class="fas fa-chevron-down fa-2x"></i>

                        <h5 class="font-weight-bolder">{{$question->views}}</h5>
                        <div>{{ngettext('View','Views',$question->views)}}</div>
                    </div>

                </div>
                <div class="py-5 col-md-11 col-10">
                    <div class="flex items-center d-flex flex-column align-items-start ">
                        <div
                            class="ml-4 text-lg leading-7 font-semibold align-self-stretch d-flex justify-content-between">
                            <div class="h1">{{$question->title}}</div>
                            <div>
                                @can('question',$question)
                                    <a class="btn btn-outline-success btn-sm align-self-center"
                                       href="{{route('question.edit',$question->slug)}}">Edit</a>
                                    <form action="{{route('question.destroy',$question->slug)}}" method="post"
                                          style="display:contents">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="confirm('Do you want to delete this question??')"
                                                class="btn btn-outline-danger btn-sm align-self-center">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="flex ml-4">
                        <img src="{{$question->gravator}}" alt="avator" class="img-thumbnail" width="50px"
                             height="50px">
                        <div>
                            <div class="ml-2 h5 text-info d-flex">Asked By - <span
                                    class="text-black-50">{{$question->user->name}}</span></div>
                            <small class="ml-2  text-info d-flex">Date - <span
                                    class="text-black-50">{{$question->created_date}}</span></small>
                        </div>
                    </div>
                    <div class="ml-4 mt-2 text-gray-600 text-dark" style="  word-wrap: break-word;">
                        {{$question->body}}
                    </div>
                </div>

            </div>
        </div>

    </div>

    @include('_alert')
    <div class="row">
        <div class="text-center col-12 h1 font-weight-bolder bg-gray-100">Answers</div>
        @if(count($question->answers)===0)
            <div class="text-center col-12 h3 font-weight-bolder bg-gray-100">There is no answers yet</div>
        @endif

        <div class="col-12">
            <form action="{{route('question.answer.store',$question->slug)}}" method="post">
                @csrf
                <label for="answer">Enter Your Answer</label>
                <textarea name="body" class="form-control @error('body') is-invalid @enderror" placeholder="Your Answer"
                          id="answer" cols="30" rows="6"
                          style="resize: none"></textarea>
                <button type="submit" class="btn-block btn btn-primary my-1">Post</button>
            </form>
        </div>
    </div>


    @foreach($question->answers as $answer)

        <div class="col-12 border-dark border-bottom mt-1">
            <div class="row pb-3 pt-1">
                <div class="col-md-1 col-2  px-0">
                    <div class="d-flex flex-column align-items-center justify-content-center">

                        <a title="This question is useful" class="vote-up">
                            <i class="fas fa-caret-up fa-3x"></i>
                        </a>
                        <span class="votes-count">1230</span>
                        <a title="This question is not useful" class="vote-down off">
                            <i class="fas fa-caret-down fa-3x"></i>
                        </a>
                        <a title="Click to mark as favorite question (Click again to undo)"
                           class="favorite mt-2 favorited flex flex-column">
                            <i class="fas fa-star fa-2x"></i>
                            <span class="favorites-count text-center">123</span>
                        </a>

                    </div>
                </div>
                <div class=" col-md-11 col-10">
                    <div class="flex items-center d-flex flex-column align-items-start ">
                        <div
                            class="ml-4 text-lg leading-7 font-semibold align-self-stretch d-flex justify-content-between">
                            <div class=" d-flex justify-content-between align-self-start" style="width: 110px">
                                {{--                            @can('update',$question)--}}
                                {{--                                <a class="btn btn-outline-success btn-sm "--}}
                                {{--                                   href="{{route('question.edit',$question->slug)}}">Edit</a>--}}
                                {{--                            @endcan--}}
                            </div>
                        </div>
                    </div>
                    <div class="ml-4 mt-2 text-gray-600 text-dark" style=" word-wrap: break-word;">
                        {{$answer->body}}
                    </div>
                    <div class="flex flex-column ml-4 mt-4">
                        <div class="flex ">
                            <img src="{{$answer->gravator}}" alt="avator" class="img-thumbnail" width="50px"
                                 height="50px">
                            <div>
                                <div class="ml-2 h5 text-info d-flex">Answered By - <span
                                        class="text-black-50">{{$answer->user->name}}</span></div>
                                <small class="ml-2  text-info d-flex">Date - <span
                                        class="text-black-50">{{$answer->created_date}}</span></small>
                            </div>
                        </div>
                        @can('answer',$answer)
                            <div class="flex mt-3">
                                <a class="btn btn-primary btn-sm"
                                   href="{{route('question.answer.edit',[$question->slug,$answer])}}">Edit</a>
                                <form action="{{route('question.answer.destroy',[$question->slug,$answer])}}"
                                      style="display: contents" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm ml-1" onclick="confirm('Are You Sure')"
                                            type="submit">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    @endforeach



@endsection
