@extends('layouts.admin')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Crons</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a href="{{ route('admin.cron.create') }}"><i class="fa fa-plus"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Expression</th>
                                    <th>Command</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($cron->count())
                                    @foreach ($cron as $item)
                                        <tr>
                                            <th scope="row">{{  $item->id }}</th>
                                            <td>{{ $item->expression }}</td>
                                            <td>{{ $item->shell_command }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>
                                                <button class="btn btn-xs btn-danger confirm-delete"
                                                        data-id="{{ $item->id }}"
                                                        type="button">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center bold">No results found.</td>
                                    </tr>
                                @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        {{ $cron->render() }}
                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.admin._confirm')
@endsection

@push('page-styles')
    {!! Html::style(asset('vendors/pnotify/dist/pnotify.css')) !!}
    {!! Html::style(asset('vendors/pnotify/dist/pnotify.nonblock.css')) !!}
@endpush

@push('page-scripts')
    {!! Html::script(asset('vendors/pnotify/dist/pnotify.js')) !!}
    {!! Html::script(asset('vendors/pnotify/dist/pnotify.nonblock.js')) !!}

    @if(session('success'))
        <script>
            $(function () {
                new PNotify({
                    title: "Success!",
                    type: "success",
                    text: "Operation successfully performed.",
                    nonblock: {nonblock: true},
                    styling: 'bootstrap3',
                    hide: true,
                    delay: 5000,
                    overlayClose: true
                });
            });
        </script>
    @endif

    <script>
        $(function () {
            $('.confirm-delete').on('click', event => {
                let modal = $('.confirm-modal'),
                    id = $(event.currentTarget).attr('data-id');

                modal.find('.modal-body').html('Are you sure do you want to delete the entry?');
                modal.find('button.confirm').attr('data-id', id);
                modal.modal('show');

                // location.href = laroute.route('admin.cron.destroy', {'cron': id});
            });

            $('body').on('click', '.confirm-modal button.confirm', event => {
                let id = $(event.currentTarget).attr('data-id');

                $.post(laroute.route('admin.cron.destroy', {'cron': id}), {}, response => {
                    $('.confirm-modal').modal('hide');

                    if (response.success) {
                        location.href = laroute.route('admin.cron.index');
                    } else {
                        new PNotify({
                            title: "Error!",
                            type: "error",
                            text: response.message,
                            nonblock: {nonblock: true},
                            styling: 'bootstrap3',
                            hide: true,
                            delay: 5000,
                            overlayClose: true
                        });
                    }
                }).fail(error => {
                    new PNotify({
                        title: "Error!",
                        type: "error",
                        text: error.message,
                        nonblock: {nonblock: true},
                        styling: 'bootstrap3',
                        hide: true,
                        delay: 5000,
                        overlayClose: true
                    });
                });
                console.log(id);
            });
        });
    </script>
@endpush
