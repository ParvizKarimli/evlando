<div id="reportModal-{{$post->id}}" class="modal fade text-left" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Report Post</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['action' => 'ReportsController@store', 'method' => 'POST']) !!}
                    <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                        <label for="category">Category (required)</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="category" value="1" required> Spam
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="category" value="2" required> Nudity
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="category" value="3" required> Hate speech
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="category" value="4" required> Other
                            </label>
                        </div>
                        @if($errors->has('category'))
                            <span class="help-block">
                                <strong>{{ $errors->first('category') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                        {{Form::label('message', 'Message (optional)')}}
                        {{Form::textarea('message', '', ['rows' => 4, 'class' => 'form-control', 'placeholder' => 'Message'])}}
                        @if($errors->has('message'))
                            <span class="help-block">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                        @endif
                    </div>
                    {!! Form::hidden('reported_type', 'post') !!}
                    {!! Form::hidden('post_id', $post->id) !!}
                    {!! Form::hidden('post_owner_id', $post->user_id) !!}
                    <div class="form-group">
                        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
