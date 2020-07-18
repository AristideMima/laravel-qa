<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>Your answer</h2>
                    <hr>
                    <form action="{{ route('questions.answers.store', $question->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control {{ $errors->has('body') ? 'alert alert-danger':'' }}" rows="7" name="body"></textarea>
                            @if($errors->has('body'))
                                <div class="alert alert-danger">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-outline-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>