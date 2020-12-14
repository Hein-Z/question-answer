@extends('master')
@section('content')
    <div class="row ">
        <div class="col-12">
            <div
                class=" d-flex justify-content-between h1 font-weight-bolder p-3 bg-gray-100 border-bottom border-dark mx-0">
                <div>All Question</div>
                <div>
                    <a class="btn btn-outline-info" href="{{route('question.create')}}">Ask Question</a>
                </div>
            </div>
        </div>
        <div class="col-12 border-dark border-bottom">
            <div class="row">
                <div class="col-md-1 col-2 py-5 px-0">
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <h5 class="font-weight-bolder">{{$question->votes}}</h5>
                        <div>{{ngettext('Vote','Votes',$question->votes)}}</div>
                        <h5 class="font-weight-bolder">{{$question->answers}}</h5>
                        <div>{{ngettext('Answer','Answers',$question->answers)}}</div>
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
                            <div>
                                <a class="btn btn-outline-success btn-sm align-self-center"
                                   href="{{route('question.edit',$question->id)}}">Edit</a>
                                <form action="{{route('question.destroy',$question->id)}}" method="post"
                                      style="display:contents">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm align-self-center">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="ml-4 h5 text-info d-flex">Asked By - <span
                                class="text-black-50">{{$question->user->name}}</span></div>
                        <small class="ml-4  text-info d-flex">Date - <span
                                class="text-black-50">{{$question->created_date}}</span></small>

                    </div>
                    <div class="flex items-center">
                        <div class="ml-4 mt-2 text-gray-600 text-dark">
                            {{$question->body}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
