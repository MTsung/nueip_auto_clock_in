@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('NUEiP 設定') }}</div>

                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="company">{{ __('公司代碼') }}</label>
                            <input type="text" class="form-control" id="company" name="company" value="{{ $user->company }}">
                        </div>
                        <div class="form-group">
                            <label for="account">{{ __('員工編號') }}</label>
                            <input type="text" class="form-control" id="account" name="account" value="{{ $user->account }}">
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('密碼') }}</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ __('送出') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
