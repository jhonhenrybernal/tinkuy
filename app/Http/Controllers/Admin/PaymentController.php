<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index()
    {
        return view('admin.payments.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $payments = Payment::with(['user', 'order', 'gateway'])->select('payments.*');

            return DataTables::of($payments)
                ->addColumn('user', fn ($row) => $row->user?->name ?? '—')
                ->addColumn('order', fn ($row) => $row->order ? 'Order #'.$row->order->id : '—')
                ->addColumn('gateway', fn ($row) => $row->gateway?->name ?? '—')
                ->addColumn('action', function ($row) {
                    $showBtn = '<span class="border border-primary dt-show rounded-3 d-inline-block me-1 px-2 py-1">
                                <a href="'.route('admin.payments.show', $row->id).'">
                                    <i class="bi bi-eye-fill text-primary"></i>
                                </a>
                            </span>';

                    $deleteBtn = '<span class="border border-danger dt-trash rounded-3 d-inline-block" 
                                onclick="deletePayment('.$row->id.')"> 
                                <i class="bi bi-trash-fill text-danger"></i>
                            </span>';

                    return $showBtn.' '.$deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $payment = Payment::with(['user', 'order', 'gateway'])->findOrFail($id);

        return view('admin.payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json(['success' => true, 'message' => 'Payment deleted successfully.']);
    }
}
