@extends('layouts.master')

@section('content')

    <div class="row  ">

        <div class="col-12">
            <div
                class=" d-flex justify-content-between h1 font-weight-bolder p-3 bg-gray-100 border-bottom border-dark mx-0">
                <div>All Question <i class=" fas fa-question"></i></div>
                <div>
                    <a class="btn btn-outline-info" href="{{route('question.create')}}">Ask Question</a>
                </div>
            </div>
            @include('_alert')
        </div>
        @foreach($questions as $question)
            <div class="col-12 border-dark border-bottom">
                <div class="row py-3 ">
                    <div class="col-md-1 col-2 px-0">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <h5 class="font-weight-bolder">{{$question->answers_count}}</h5>
                            <div>{{ngettext('Answer','Answers',$question->answers_count)}}</div>

                            <a title="Click to vote up question "
                               class=" mt-2 btn {{$question->up_vote_status}} flex flex-column"
                               onclick="event.preventDefault();document.getElementById('{{$question->id}}-up-vote').submit()"
                            >
                                <i class="fas fa-chevron-up fa-2x"></i>
                            </a>
                            <form action="{{route('question.vote',$question->slug)}}" id="{{$question->id}}-up-vote"
                                  method="post"
                                  style="display:none">
                                @csrf
                                <input type="hidden" value="1" name="vote">
                            </form>
                            <div
                                class="h3 font-weight-bolder d-flex justify-content-center align-items-center mb-0 bg-success"
                                style="width: 40px; height: 40px">
                                <div class="text-center">{{$question->votes_count}}</div>
                            </div>
                            <a title="Click to vote down question "
                               class=" mt-2 btn {{$question->down_vote_status}}  flex flex-column"
                               onclick="event.preventDefault();document.getElementById('{{$question->id}}-down-vote').submit()"
                            >
                                <i class="fas fa-chevron-down fa-2x"></i>
                            </a>
                            <form action="{{route('question.vote',$question->slug)}}" id="{{$question->id}}-down-vote"
                                  method="post"
                                  style="display:none">
                                @csrf
                                <input type="hidden" value="-1" name="vote">
                            </form>

                            <h5 class="font-weight-bolder">{{$question->views}}</h5>
                            <div>{{ngettext('View','Views',$question->views)}}</div>
                        </div>
                    </div>
                    <div class=" col-md-11 col-10">
                        <div class="flex items-center d-flex flex-column align-items-start ">
                            <div
                                class="ml-4 text-lg leading-7 font-semibold align-self-stretch d-flex justify-content-between">
                                <a
                                    class="text-gray-900 dark:text-white h2"
                                    href="{{$question->url}}">{{$question->title}}</a>
                                <div class=" d-flex justify-content-end align-self-start" style="width: 110px">
                                    @can('question',$question)
                                        <a class="btn btn-outline-success btn-sm mr-1"
                                           href="{{route('question.edit',$question->slug)}}">Edit</a>
                                    @endcan
                                    <a class="btn btn-outline-info btn-sm"
                                       href="{{route('question.show',$question->slug)}}">Detail</a>
                                </div>
                            </div>
                            <div class="flex ml-4">
                                {{--@include('share._author',['model'=>$question])--}}
                                <user-info label="Asked" :model="{{$question}}"></user-info>
                            </div>
                        </div>
                        <div class="ml-4 mt-2 text-gray-600 text-dark" style=" word-wrap: break-word;">
                            {{--                            {{substr(e($question->body),0,500)}}{{strlen(e($question->body))>500?'...':''}}--}}
                            {{$question->excrept}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    {{$questions->onEachSide(5)->links()}}

@endsection
