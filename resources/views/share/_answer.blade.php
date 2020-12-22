@forelse($question->answers as $answer)
    <answer :question="{{$question}}" :answer="{{$answer}}"></answer>
@empty
    <div class="text-center">No Answer</div>
@endforelse
