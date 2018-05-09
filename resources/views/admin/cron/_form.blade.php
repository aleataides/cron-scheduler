<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="description" name="description" required="required" class="form-control col-md-7 col-xs-12">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="minutes">
        Minutes <span class="required">*</span>
    </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <div class="col-md-6">
            @foreach($humanizedMinutes as $value => $humanizedMinute)
                <label for="minutes-{{ $value }}" class="show">
                    <input type="radio" name="minutes-select" id="minutes-{{ $value }}" value="{{ $value }}">
                    {{ $humanizedMinute }}
                </label>
            @endforeach
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-2">
                    <input type="radio" name="minutes-select">
                </div>
                <div class="col-md-10">
                    <select class="select2 form-control" name="minutes[]" multiple id="minutes-select" style="height: 164px;">
                        @foreach ($minutes as $minute)
                            <option value="{{ $minute }}">{{ $minute }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="hours" class="control-label col-md-3 col-sm-3 col-xs-12">Hours
        <span class="required">*</span>
    </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <div class="col-md-6">
            @foreach($humanizedHours as $value => $humanizedHour)
                <label for="hours-{{ $value }}" class="show">
                    <input type="radio" name="hours-select" id="hours-{{ $value }}" value="{{ $value }}">
                    {{ $humanizedHour }}
                </label>
            @endforeach
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-2">
                    <input type="radio" name="hours-select">
                </div>
                <div class="col-md-10">
                    <select class="select2 form-control" name="hours[]" multiple id="hours-select" style="height: 164px;">
                        @foreach ($hours as $hour)
                            <option value="{{ $hour }}">{{ $hour }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="days" class="control-label col-md-3 col-sm-3 col-xs-12">Days
        <span class="required">*</span>
    </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <div class="col-md-6">
            @foreach($humanizedDays as $value => $humanizedDay)
                <label for="days-{{ $value }}" class="show">
                    <input type="radio" name="days-select" id="days-{{ $value }}" value="{{ $value }}">
                    {{ $humanizedDay }}
                </label>
            @endforeach
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-2">
                    <input type="radio" name="days-select">
                </div>
                <div class="col-md-10">
                    <select class="select2 form-control" name="days[]" multiple id="days-select" style="height: 164px;">
                        @foreach ($days as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="months" class="control-label col-md-3 col-sm-3 col-xs-12">Months
        <span class="required">*</span>
    </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <div class="col-md-6">
            @foreach($humanizedMonths as $value => $humanizedMonth)
                <label for="months-{{ $value }}" class="show">
                    <input type="radio" name="months-select" id="months-{{ $value }}" value="{{ $value }}">
                    {{ $humanizedMonth }}
                </label>
            @endforeach
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-2">
                    <input type="radio" name="months-select">
                </div>
                <div class="col-md-10">
                    <select class="select2 form-control" name="months[]" multiple id="months-select" style="height: 164px;">
                        @foreach ($months as $key => $month)
                            <option value="{{ $key }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="weekdays" class="control-label col-md-3 col-sm-3 col-xs-12">Weekdays
        <span class="required">*</span>
    </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <div class="col-md-6">
            @foreach($humanizedWeekdays as $value => $humanizedWeekday)
                <label for="weekdays-{{ $value }}" class="show">
                    <input type="radio" name="weekdays-select" id="weekdays-{{ $value }}" value="{{ $value }}">
                    {{ $humanizedWeekday }}
                </label>
            @endforeach
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-2">
                    <input type="radio" name="weekdays-select">
                </div>
                <div class="col-md-10">
                    <select class="select2 form-control" name="weekdays[]" multiple id="weekdays-select" style="height: 135px;">
                        @foreach ($weekdays as $key => $weekday)
                            <option value="{{ $key }}">{{ $weekday }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="command" class="control-label col-md-3 col-sm-3 col-xs-12">Command <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="command" name="command" class="form-control col-md-7 col-xs-12" required="required" type="text">
    </div>
</div>
<div class="ln_solid"></div>