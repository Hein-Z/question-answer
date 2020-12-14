@extends('master')
@section('content')
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block ">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1">
                        @foreach($questions as $question)

                        <div class="p-6 border-bottom border-dark">
                            <div class="flex items-center d-flex flex-column align-items-start ">
                                <div class="ml-4 text-lg leading-7 font-semibold"><a class="text-gray-900 dark:text-white h2" href="{{$question->url}}">{{$question->title}}</a></div>
                                <div class="ml-4 h5 text-info d-flex">Asked By - <span class="text-black-50">{{$question->user->name}}</span></div>
                                <small class="ml-4  text-info d-flex">Date - <span class="text-black-50">{{$question->created_date}}</span></small>
                            </div>
                            <div class="flex items-center">
                                <div class="ml-4 mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    {{$question->body}}
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                {{$questions->onEachSide(5)->links()}}

            </div>
@endsection
