@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('LINE Notify 綁定') }}</div>

                <div class="card-body">
                    @if (!isset(Auth::user()->setting->line_notify_token))
                        <a class="btn btn-primary" href="{{ route('setting.line-notify.bind') }}">{{ __('綁定') }}</a>
                    @else
                        <a class="btn btn-danger" href="javascript:;"
                            onclick="event.preventDefault();document.getElementById('del-form').submit();">{{ __('解除綁定') }}</a>

                        <form id="del-form" action="{{ route('setting.line-notify.del') }}" method="POST"
                            class="d-none">
                            {{ method_field('DELETE') }}
                            @csrf
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
