@extends('layouts.admin')

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Crons</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            {!! Form::open(['route' => 'admin.cron.store', 'class' => 'form-horizontal form-label-left', 'data-parsley-validate', 'id' => 'demo-form2']) !!}
                            @include('admin.cron._form')

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="{{ route('admin.cron.index') }}" class="btn btn-primary">Cancel</a>
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        $(function () {
            $('select[name="minutes[]"], select[name="hours[]"], select[name="days[]"], select[name="months[]"], select[name="weekdays[]"]').on('click', function(){
                $(this).parent().parent().find('input:radio').prop('checked', true);
            });
        });
    </script>
@endpush