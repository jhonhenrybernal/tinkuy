<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        return view('admin.payment_gateways.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $gateways = PaymentGateway::select('payment_gateways.*');

            return DataTables::of($gateways)
                ->addColumn('status', fn ($row) => $row->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>')
                ->addColumn('action', function ($row) {
                    return '
                        <a href="'.route('admin.payment-gateways.edit', $row->id).'" class="btn btn-sm btn-primary me-1">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <span class="border border-danger dt-trash rounded-3 d-inline-block" onclick="deleteGateway('.$row->id.')">
                            <i class="bi bi-trash-fill text-danger"></i>
                        </span>
                    ';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $paymentGateway = PaymentGateway::with('configs')->findOrFail($id);

        return view('admin.payment_gateways.edit', compact('paymentGateway'));
    }

    public function update(Request $request, $id)
    {

        $gateway = PaymentGateway::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:payment_gateways,code,'.$gateway->id,
            'description' => 'nullable|string',
            'configs.*.key_name' => 'sometimes|required|string|max:100',
            'configs.*.key_value' => 'sometimes|required|string',
            'configs.*.environment' => 'sometimes|required|string',
        ]);

        $data = $request->only(['name', 'code', 'description']);
        $data['is_active'] = $request->has('is_active');
        $gateway->update($data);

        if ($request->has('configs')) {
            foreach ($request->configs as $configId => $configData) {
                $config = $gateway->configs()->find($configId);

                if ($config) {
                    $config->update([
                        'key_name' => $configData['key_name'],
                        'key_value' => $configData['key_value'],
                        'is_encrypted' => isset($configData['is_encrypted']),
                        'environment' => $configData['environment'],
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.payment-gateways.index')
            ->with('success', 'Payment Gateway updated successfully.');
    }

    public function destroy(PaymentGateway $paymentGateway)
    {
        $paymentGateway->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment Gateway deleted successfully.',
        ]);
    }
}
