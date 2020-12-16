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
            @if(session()->has('msg'))
                <div
                    class='alert-success alert alert-dismissible fade show d-flex justify-content-between align-items-center pr-0'
                    role="alert">
                    <div class="h3">
                        {{ session()->get('msg') }}
                    </div>
                    <button type="button" class="close position-relative" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        @foreach($questions as $question)
            <div class="col-12 border-dark border-bottom">
                <div class="row">
                    <div class="col-md-1 col-2 py-5 px-0">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <h5 class="font-weight-bolder">{{$question->answers}}</h5>
                            <div>{{ngettext('Answer','Answers',$question->answers)}}</div>

                            <i class="fas fa-chevron-up fa-2x"></i>
                            <div
                                class="h3 font-weight-bolder d-flex justify-content-center align-items-center mb-0 bg-success"
                                style="width: 40px; height: 40px">
                                <div class="text-center">{{$question->votes}}</div>
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
                                <a
                                    class="text-gray-900 dark:text-white h2"
                                    href="{{$question->url}}">{{$question->title}}</a>
                                <div class=" d-flex justify-content-between align-self-start" style="width: 110px">
                                    @can('update',$question)
                                        <a class="btn btn-outline-success btn-sm "
                                           href="{{route('question.edit',$question->slug)}}">Edit</a>
                                    @endcan
                                    <a class="btn btn-outline-info btn-sm "
                                       href="{{route('question.show',$question->slug)}}">Detail</a>
                                </div>
                            </div>
                            <div class="ml-4 h5 text-info d-flex">Asked By - <span
                                    class="text-black-50">{{$question->user->name}}</span></div>
                            <small class="ml-4  text-info d-flex">Date - <span
                                    class="text-black-50">{{$question->created_date}}</span></small>

                        </div>
                        <div class="flex items-center">
                            <div class="ml-4 mt-2 text-gray-600 text-dark">
                                {{substr($question->body,0,300)}}{{strlen($question->body)>300?'...':''}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    {{$questions->onEachSide(5)->links()}}

@endsection
