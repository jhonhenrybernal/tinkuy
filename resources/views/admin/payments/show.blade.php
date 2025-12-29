@extends('admin.layouts.admin')

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="mb-0">{{ __('cms.payments.details_title') }}</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>{{ __('cms.payments.id') }}</th>
                <td>{{ $payment->id }}</td>
            </tr>
            <tr>
                <th>{{ __('cms.payments.user') }}</th>
                <td>{{ $payment->user->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>{{ __('cms.payments.order') }}</th>
                <td>#{{ $payment->order->id ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>{{ __('cms.payments.gateway') }}</th>
                <td>{{ $payment->gateway->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>{{ __('cms.payments.amount') }}</th>
                <td>{{ number_format($payment->amount, 2) }}</td>
            </tr>
            <tr>
                <th>{{ __('cms.payments.status') }}</th>
                <td>
                    <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : 'warning' }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>{{ __('cms.payments.transaction_id') }}</th>
                <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>{{ __('cms.payments.created_at') }}</th>
                <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
            </tr>
        </table>

        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> {{ __('cms.payments.back') }}
        </a>
    </div>
</div>
@endsection
