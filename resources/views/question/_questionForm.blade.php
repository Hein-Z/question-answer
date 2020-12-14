<div class="form-group">
    <label for="title ">Question</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
           placeholder="title" value="{{old('title')?old('title'):$title}}">
    @error('title')
    <div class=" text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group ">
    <label for="body">Explain your question</label>
    <textarea type="text" class="form-control @error('body') is-invalid @enderror" placeholder="explain" name="body" id="body">{{old('body')?old('body'):$body}}</textarea>
    @error('body')
    <div class=" text-danger">{{ $message }}</div>
    @enderror
</div>
<button class="btn btn-outline-info btn-block">{{$buttonText}}</button>
