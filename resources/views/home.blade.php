@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">
                    @if (isset($dateStatus->date))
                        {{ $dateStatus->date }} ({{ $dateStatus->is_work_day ? '工作日' : '休假' }})
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
            onChange: function (selectedDates, dateStr, instance) {
                location.href = '{{ route('home') }}?date=' + formatDate(selectedDates[0]);
            },
            onDayCreate: function (dObj, dStr, fp, dayElem) {
                console.log(offDays.indexOf(formatDate(dayElem.dateObj)));
                if (offDays.indexOf(formatDate(dayElem.dateObj)) !== -1) {
                    dayElem.innerHTML = "<span style='color: #f64747'>"+dayElem.innerHTML+"</span>";
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
    </script>
@endsection
