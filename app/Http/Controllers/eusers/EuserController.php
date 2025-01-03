<?php

namespace App\Http\Controllers\eusers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EuserController extends Controller
{
    public function postsignin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('euser')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('euser.dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['Invalid credentials'])->withInput();
    }

    public function logout()
    {
        Auth::guard('euser')->logout();
        return redirect()->route('eusers.login')->with('message', 'Logged out successfully!');
    }

    public function dashboard()
    {
        $user = Auth::guard('euser')->user();
        $orderCount = Order::where('userId', $user->id)->count();
        return view('eusers.dashboard', compact('user', 'orderCount'));
    }

    public function myorderlist()
    {
        $user = Auth::guard('euser')->user();
        // $orders = Order::where('userId', $user->id)->get();
        $orders = Order::where('userId', $user->id)->get();
        // dd($orders);

        return view('eusers.myorders.list', compact('orders'));
    }

    public function ordersview($id)
    {
        $order = Order::with(['items.productDetails'])->find($id);
        if ($order->userId !== Auth::guard('euser')->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('eusers.myorders.view', compact('order'));
    }

    public function wishlist()
    {
        return view('eusers.wishlist');
    }
}
