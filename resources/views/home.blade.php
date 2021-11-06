@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header" style="min-height: 53px">
                    @if (isset($dateStatus->date))
                        {{ $dateStatus->date }} ({{ $dateStatus->is_work_day ? __('工作日') : __('休假') }})
                        @if ($dateStatus->is_work_day)
                            <button class="btn btn-sm btn-success"
                                onclick="event.preventDefault();document.getElementById('save-form').submit();">
                                {{ __('設定排除打卡日') }}
                            </button>
                            <form id="save-form" action="{{ route('setting.off-day.save') }}" method="POST"
                                class="d-none">
                                <input type="hidden" name="date" value="{{ $dateStatus->date }}">
                                @csrf
                            </form>
                        @elseif ($dateStatus->is_by_user ?? 0)
                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom"
                                title="{{ __('若是已在 NUEiP 系統請假，就算移除，排程也會定期寫入回。') }}"
                                onclick="event.preventDefault();document.getElementById('del-form').submit();">
                                {{ __('移除排除打卡日') }}
                            </button>

                            <form id="del-form" action="{{ route('setting.off-day.delete') }}" method="POST"
                                class="d-none">
                                {{ method_field('DELETE') }}
                                <input type="hidden" name="date" value="{{ $dateStatus->date }}">
                                @csrf
                            </form>
                        @endif
                    @else
                        {{ request('date') ?? Carbon\Carbon::today()->toDateString() }}
                    @endif
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <input data-type='flatpickr' class="d-none"
                                value="{{ request('date') ?? Carbon\Carbon::today()->toDateString() }}">
                        </div>
                        <div class="col-lg-8">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('類型') }}</th>
                                        <th scope="col">{{ __('狀態') }}</th>
                                        <th scope="col">{{ __('訊息') }}</th>
                                        <th scope="col">{{ __('時間') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        <tr>
                                            <th scope="row">{{ $log->id }}</th>
                                            <td>{{ __('log.type.' . $log->type) }}</td>
                                            <td>{{ $log->status }}</td>
                                            <td>{{ $log->message }}</td>
                                            <td>{{ $log->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        var offDays = {!! json_encode($offDays) !!};

        flatpickr("input[data-type='flatpickr']", {
            dateFormat: "Y-m-d",
            enableTime: false,
            inline: true,
            minDate: '2021-01-01',
            maxDate: '{{ Carbon\Carbon::today()->addYear()->lastOfYear()->toDateString() }}',
            onChange: function(selectedDates, dateStr, instance) {
                location.href = '{{ route('home') }}?date=' + formatDate(selectedDates[0]);
            },
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                if (offDays.indexOf(formatDate(dayElem.dateObj)) !== -1) {
                    if (dayElem.classList.contains('nextMonthDay') || dayElem.classList.contains(
                            'prevMonthDay')) {
                        dayElem.innerHTML = "<span style='color: #ffc7c7'>" + dayElem.innerHTML + "</span>";
                    } else {
                        dayElem.innerHTML = "<span style='color: #f64747'>" + dayElem.innerHTML + "</span>";
                    }
                }
            }
        });

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
@endsection
