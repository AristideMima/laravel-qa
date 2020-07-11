@csrf
<div class="form-group">
    <label for="question-title">Question title</label>
    <input type="text" name="title" value="{{ old('title', $question->title) }}" id="question-title" class="form-control {{ $errors->has('title') ? 'alert alert-danger':'' }}">
    @if($errors->has('title'))
        <div class="alert alert-danger">
            <strong>{{ $errors->first('title') }}</strong>
        </div>
    @endif
</div>
<div class="form-group">
    <label for="question-body">Explain your question</label>
    <textarea name="body" id="question-body" class="form-control {{ $errors->has('body') ? 'alert alert-danger':'' }}" rows="10"> {{ old('body', $question->body) }}</textarea>
    @if($errors->has('body'))
        <div class="alert alert-danger">
            <strong>{{ $errors->first('body') }}</strong>
        </div>
    @endif
</div>
<div class="form-group">
    <button type="submit" class="btn btn-outline-primary btn-lg"> {{ $buttonText }}</button>
</div>