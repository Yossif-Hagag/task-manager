<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->limit(5)->get(); // جلب آخر 5 مهام
        $users = User::count(); // عدد المستخدمين

        return view('dashboard.index', compact('tasks', 'users'));
    }
}