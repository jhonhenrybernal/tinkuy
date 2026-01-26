<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;

class AuthController extends Controller
{
    protected $vendorService;

    public function showLoginForm()
    {
        return view('vendor.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('vendor')->attempt($request->only('email', 'password'))) {

            $vendorId = Auth::guard('vendor')->id();

            $completedOrders = Order::where('vendor_id', $vendorId)
                ->where('status', 'completed')
                ->count();

            $totalSales = Order::where('vendor_id', $vendorId)
                ->where('status', 'completed')
                ->sum('total_amount');

            // Variables desde config (que vienen de .env)
            $minOrders = (int) config('vendor.min_completed_orders');
            $minWage   = (float) config('vendor.min_wage_current');

            // ✅ bandera final
            $meetsRequirements = ($completedOrders > $minOrders) && ($totalSales > $minWage);

            // Opción A: guardar en sesión para usar en el dashboard
            session([
                'meets_requirements' => $meetsRequirements,
                'completed_orders'   => $completedOrders,
                'total_sales'        => $totalSales,
            ]);

            return redirect()->route('vendor.dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        Auth::guard('vendor')->logout();

        return redirect()->route('vendor.login');
    }

    public function dashboard()
    {
        return view('vendor.dashboard');
    }
}
