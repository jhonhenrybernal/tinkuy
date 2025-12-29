@extends('admin.layouts.admin')

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="mb-0">{{ __('cms.refunds.details_title') }}</h6>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>{{ __('cms.refunds.id') }}</th>
                <td>{{ $refund->id }}</td>
            </tr>
            <tr>
                <th>{{ __('cms.refunds.payment') }}</th>
                <td>
                    @if($refund->payment)
                        {{ __('cms.refunds.payment') }} #{{ $refund->payment->id }} 
                        ({{ __('cms.refunds.amount') }}: {{ $refund->payment->amount }} – {{ __('cms.refunds.status') }}: {{ $refund->payment->status }})
                    @else
                        {{ __('cms.refunds.not_available') }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>{{ __('cms.refunds.amount') }}</th>
                <td>{{ $refund->amount }}</td>
            </tr>
            <tr>
                <th>{{ __('cms.refunds.status') }}</th>
                <td>{{ $refund->status }}</td>
            </tr>
            <tr>
                <th>{{ __('cms.refunds.reason') }}</th>
                <td>{{ $refund->reason ?? __('cms.refunds.not_available') }}</td>
            </tr>
            <tr>
                <th>{{ __('cms.refunds.created_at') }}</th>
                <td>{{ $refund->created_at }}</td>
            </tr>
            <tr>
                <th>{{ __('cms.refunds.updated_at') }}</th>
                <td>{{ $refund->updated_at }}</td>
            </tr>
        </table>

        <a href="{{ route('admin.refunds.index') }}" class="btn btn-secondary mt-3">
            {{ __('cms.refunds.back') }}
        </a>
    </div>
</div>
@endsection
