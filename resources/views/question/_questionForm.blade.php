<div class="form-group">
    <label for="title ">Question</label>

    @if(Route::current()->getName()==='question.edit')
        {{--Edit Form--}}
        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
               placeholder="title" value="{{$title?old('title')??$title:''}}">
    @else
    {{--Create Form--}}
        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
               placeholder="title" value="{{old('title')??''}}">
    @endif

    @error('title')
    <div class=" text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group ">
    <label for="body">Explain your question</label>

    @if(Route::current()->getName()==='question.edit')
        {{--Edit Form--}}
        <textarea type="text" class="form-control @error('body') is-invalid @enderror" placeholder="explain" name="body"
                  id="body">{{$body?old('body')?old('body'):$body:''}}</textarea>
    @else
        {{--Create Form--}}
        <textarea type="text" class="form-control @error('body') is-invalid @enderror" placeholder="explain" name="body"
                  id="body">{{old('body')??''}}</textarea>
    @endif


    @error('body')
    <div class=" text-danger">{{ $message }}</div>
    @enderror
</div>
<button class="btn btn-outline-info btn-block">{{$buttonText}}</button>
