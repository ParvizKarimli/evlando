<div id="reportModal-{{$post->id}}" class="modal fade text-left" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ __('reports.modal_header_post') }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['action' => 'ReportsController@store', 'method' => 'POST']) !!}
                    <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                        <label for="category">{{ __('reports.category_label') }}</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="category" value="1" required> {{ __('reports.spam') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="category" value="2" required> {{ __('reports.nudity') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="category" value="3" required> {{ __('reports.hate_speech') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="category" value="4" required> {{ __('reports.other') }}
                            </label>
                        </div>
                        @if($errors->has('category'))
                            <span class="help-block">
                                <strong>{{ $errors->first('category') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                        {{Form::label('message', __('reports.message_label'))}}
                        {{
                            Form::textarea('message', '', [
                                'rows' => 4,
                                'class' => 'form-control',
                                'placeholder' => __('reports.message_placeholder')
                            ])
                        }}
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
                        {{Form::submit(__('reports.report_btn'), ['class' => 'btn btn-primary'])}}
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('reports.close_btn') }}</button>
            </div>
        </div>

    </div>
</div>
