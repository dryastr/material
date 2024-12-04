<?php

namespace App\Http\Controllers\Area;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['page'] = 'dashboard';

        $total = Pesanan::select('*');
        $pending = Pesanan::select('*');
        $reject = Pesanan::select('*');
        $done = Pesanan::select('*');

        if (Auth::user()->role == 'Supervisor') {
            $total = $total->where('id_pemesan', Auth::user()->id);
            $pending = $pending->where('status_spv', 'Pending');
            $reject = $reject->where('status_spv', 'Reject');
            $done = $done->where('status_spv', 'Done');
        }
        if (Auth::user()->role == 'Staff') {
            $total = $total->where('id_pemesan', Auth::user()->id);
            $pending = $total->where('status_spv', 'Pending')->orWhere('status_admin', 'Pending');
            $reject = $total->where('status_spv', 'Reject')->orWhere('status_admin', 'Reject');
            $reject = $total->where('status_spv', 'Reject')->orWhere('status_admin', 'Reject');
        }
        if (Auth::user()->role == 'Admin') {
            $total = $total->where('status_spv', 'Done');
            $pending = $pending->where('status_spv', 'Done')->where('status_admin', 'Pending');
            $reject = $reject->where('status_spv', 'Done')->where('status_admin', 'Reject');
            $reject = $reject->where('status_Admin', 'Done');
        }
        $data['total'] = $total->count();
        $data['pending'] = $pending->count();
        $data['reject'] = $reject->count();
        $data['done'] = $done->count();

        return view('area.dashboard', $data);
    }
}
