<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        // Anzahl der Benutzer abrufen
        $usersCount = User::whereIn('user_type', ['admin', 'pt', 'ih', 'op'])->count();

        // Anzahl der offenen und in Bearbeitung befindlichen Tasks abrufen
        $openTasksCount = Task::whereIn('status', ['offen', 'in bearbeitung'])->count();

        // Anzahl der Tasks in Bearbeitung abrufen
        $inProgressTasksCount = Task::where('status', 'in bearbeitung')->count();

        // Anzahl der abgeschlossenen Tasks abrufen
        $completedTasksCount = Task::where('status', 'Abgeschlossen')->count();

        // Die Werte an die Ansicht übergeben
        return view('backend.dashboard', compact('usersCount', 'openTasksCount', 'inProgressTasksCount', 'completedTasksCount'));
    }
}