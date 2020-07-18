@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h1>Editing answer for question <em class="alert-dark">{{ $question->title }}</em></h1>
                                    <hr>
                                    <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}" method="post">
                                        @method('PATCH')
                                        @csrf
                                        <div class="form-group">
                                            <textarea class="form-control {{ $errors->has('body') ? 'alert alert-danger':'' }}" rows="7" name="body">{{ old('body', $answer->body) }}</textarea>
                                            @if($errors->has('body'))
                                                <div class="alert alert-danger">
                                                    <strong>{{ $errors->first('body') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-outline-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection