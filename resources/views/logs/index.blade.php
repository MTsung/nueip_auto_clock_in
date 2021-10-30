@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('紀錄') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('類型') }}</th>
                                <th scope="col">{{ __('狀態') }}</th>
                                <th scope="col">{{ __('訊息') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <th scope="row">{{ $log->id }}</th>
                                    <td>{{ __('log.type.' . $log->type) }}</td>
                                    <td>{{ $log->status }}</td>
                                    <td>{{ $log->message }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
