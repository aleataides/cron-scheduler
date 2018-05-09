@extends('layouts.admin')

@section('content')

<div class="right_col" role="main">
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-clock-o"></i></div>
                <div class="count">{{ $totalCron }}</div>
                <h3>Crons</h3>
                <p>Running crons.</p>
            </div>
        </div>
    </div>
</div>
@endsection