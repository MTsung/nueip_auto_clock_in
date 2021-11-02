@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('打卡設定') }}</div>

                <div class="card-body">
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
