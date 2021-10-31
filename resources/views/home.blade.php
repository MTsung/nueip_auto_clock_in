@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        /**
                    * 開關
                    */
        .onoffswitch {
            position: relative;
            width: 50px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .onoffswitch-checkbox {
            display: none;
        }

        .onoffswitch-label {
            display: block;
            overflow: hidden;
            cursor: pointer;
            height: 19px;
            padding: 0;
            line-height: 19px;
            border: 2px solid #E3E3E3;
            border-radius: 19px;
            background-color: #FFFFFF;
            transition: background-color 0.2s ease-in;
        }

        .onoffswitch-label:before {
            font-family: 'Glyphicons Halflings';
            content: "";
            display: block;
            width: 21px;
            margin: 0px;
            background: #FFFFFF;
            position: absolute;
            top: 0;
            bottom: 0;
            right: 29px;
            border: 2px solid #E3E3E3;
            border-radius: 19px;
            transition: all 0.2s ease-in 0s;
        }

        .onoffswitch-checkbox:checked+.onoffswitch-label {
            background-color: #49E845;
        }

        .onoffswitch-checkbox:checked+.onoffswitch-label,
        .onoffswitch-checkbox:checked+.onoffswitch-label:before {
            border-color: #49E845;
        }

        .onoffswitch-checkbox:checked+.onoffswitch-label:before {
            right: 0px;
        }

    </style>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ Carbon\Carbon::today()->toDateString() }}</div>

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
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <form method="POST">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label>上班自動打卡</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="hidden" name="auto_clock_in" value="0">
                                                    <input type="checkbox" name="auto_clock_in" value="1" @if ($setting->auto_clock_in ?? '0') checked @endif>
                                                </div>
                                            </div>
                                            <input data-type="flatpickrTime" class="form-control" name="clock_in_time" placeholder="click" value="{{ $setting->clock_in_time ?? '09:20' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label>下班自動打卡</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="hidden" name="auto_clock_out" value="0">
                                                    <input type="checkbox" name="auto_clock_out" value="1" @if ($setting->auto_clock_out ?? '0') checked @endif>
                                                </div>
                                            </div>
                                            <input data-type="flatpickrTime" class="form-control" name="clock_out_time" placeholder="click" value="{{ $setting->clock_out_time ?? '18:25' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label>打卡位置</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <input class="form-control" id="lat" name="lat" value="{{ $setting->lat ?: '25.0776031' }}" readonly>
                                                <input class="form-control" id="lng" name="lng" value="{{ $setting->lng ?: '121.5751335' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @csrf
                                <button type="submit" class="btn btn-primary">{{ __('送出') }}</button>
                            </form>
                        </div>
                        <div class="col-lg-8 mb-3">
                            <div id="map" class="w-100" style="height: 350px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        flatpickr("input[data-type='flatpickrTime']", {
            dateFormat: "H:i",
            enableTime: true,
            noCalendar: true,
            time_24hr: false,
        });

        flatpickr("input[data-type='flatpickr']", {
            dateFormat: "Y-m-d",
            enableTime: false,
            inline: true,
            onChange: function(selectedDates, dateStr, instance) {
                location.href = '{{ route('home') }}?date=' + formatDate(selectedDates[0]);
            },
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
    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async></script>
    <script>
        function initMap() {
            const myLatlng = {
                lat: {{ $setting->lat ?: 25.0776031 }},
                lng: {{ $setting->lng ?: 121.5751335 }}
            };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 19,
                center: myLatlng,
            });
            // Create the initial InfoWindow.
            let infoWindow = new google.maps.InfoWindow({
                content: "{{ $setting->lat ?: 25.0776031 }},{{ $setting->lng ?: 121.5751335 }}",
                position: myLatlng,
            });

            infoWindow.open(map);
            // Configure the click listener.
            map.addListener("click", (mapsMouseEvent) => {
                // Close the current InfoWindow.
                infoWindow.close();
                // Create a new InfoWindow.
                infoWindow = new google.maps.InfoWindow({
                    position: mapsMouseEvent.latLng,
                });
                let lat = round5(mapsMouseEvent.latLng.toJSON().lat)
                let lng = round5(mapsMouseEvent.latLng.toJSON().lng)
                infoWindow.setContent(lat + ',' + lng);
                $('#lat').val(lat);
                $('#lng').val(lng);
                infoWindow.open(map);
            });
            setTimeout(() => {
                $('span:contains("這個網頁無法正確載入 Google 地圖。")').parent('div').parent('div').remove();
            }, 250);
        }

        function round5(num) {
            return Math.round(num * 100000) / 100000;
        }
    </script>
@endsection
