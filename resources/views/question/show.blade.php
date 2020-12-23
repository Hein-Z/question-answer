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
                        <favourite :question="{{$question}}">
                        </favourite>

                        <a title="Click to vote up question "
                           class=" mt-2 btn {{$question->up_vote_status}} flex flex-column"
                           onclick="event.preventDefault();document.getElementById('up-vote').submit()"
                        >
                            <i class="fas fa-chevron-up fa-2x"></i>
                        </a>
                        <form action="{{route('question.vote',$question->slug)}}" id="up-vote" method="post"
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
                           onclick="event.preventDefault();document.getElementById('down-vote').submit()"
                        >
                            <i class="fas fa-chevron-down fa-2x"></i>
                        </a>
                        <form action="{{route('question.vote',$question->slug)}}" id="down-vote" method="post"
                              style="display:none">
                            @csrf
                            <input type="hidden" value="-1" name="vote">
                        </form>
                        <h5 class="font-weight-bolder">{{$question->views}}</h5>
                        <div>{{ngettext('View','Views',$question->views)}}</div>
                    </div>
                </div>
                <div class="py-5 col-md-11 col-10">
                    <div class="flex flex-column ml-4">
                        <div class="flex items-center d-flex flex-column align-items-start ">
                            <div
                                class="text-lg leading-7 font-semibold flex-row align-self-stretch d-flex justify-content-between">
                                <div class="h1">{{$question->title}}</div>
                                <div class="flex-row flex">
                                    @can('question',$question)
                                        <a class="btn btn-outline-success btn-sm align-self-center"
                                           href="{{route('question.edit',$question->slug)}}">Edit</a>
                                        <form action="{{route('question.destroy',$question->slug)}}" method="post"
                                              style="display:contents">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="if(!confirm('Do you want to delete this question??'))return false"
                                                    class="btn btn-outline-danger btn-sm align-self-center">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan
                                </div>

                            </div>
                        </div>
                        <user-info label="Asked" :model="{{$question}}"></user-info>

                    </div>
                    <div class="ml-4 mt-2  text-gray-600 text-dark " style=" flex-wrap: wrap">
                        <p>{!! $question->body_html!!}</p>
                    </div>
                </div>

            </div>
        </div>

    </div>

    @include('_alert')
    <answers  :question="{{$question}}"></answers>

@endsection
