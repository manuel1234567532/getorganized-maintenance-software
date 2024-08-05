<?php

use App\Http\Controllers\Backend as Backend;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\FileManagerController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\TaskController;
use App\Http\Controllers\Backend\SparePartController;
use App\Http\Controllers\Backend\WorkOrderController;
use App\Http\Controllers\Backend\MachineController;
use App\Http\Controllers\Backend\MachineTypeController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\LocationController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\FileController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Models\WebsiteSettings;
use App\Models\RoleAndAccess;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

require __DIR__ . '/auth.php';

// Backend Routes
Route::middleware('auth')->group(function () {
        Route::get('newuser/Updatepassword', [Backend\UserController::class, 'ShowPasswordForm'])->name('users-password-update');
        Route::put('update/user/{id}/password', [Backend\UserController::class, 'Updateuserpassword'])->name('update-user-password');
        Route::get('two-factor-login', [TwoFactorController::class, 'show2faform'])->name('two-factor.login');
        Route::post('two-factor-login', [TwoFactorController::class, 'verify2faLogin']);
        Route::middleware(['auth', 'password.updated', '2fa'])->group(function () {
        // Users Routes
        Route::get('users-dt', [Backend\UserController::class, 'dataTable'])->name('users-datatable');
        //Machine Types
        Route::get('machine-types-dt', [Backend\MachineTypeController::class, 'dataTable'])->name('machine-types-datatable');
        //Machine
        Route::get('machines-dt', [Backend\MachineController::class, 'dataTable'])->name('machines-datatable');
        //Roles
        Route::get('roles-dt', [Backend\RoleController::class, 'dataTable'])->name('roles-datatable');
        //TEST
        Route::get('/mark-notification-as-read/{id}', [App\Http\Controllers\Backend\NotificationController::class, 'markAsRead']);
        //Demofile
        Route::resource('demo-file', Backend\DemoFileController::class);
        //Filemanager
        Route::get('/filemanager/create', [Backend\FileManagerController::class, 'create'])->name('filemanager.create');
        Route::get('/filemanager/edit/{id}', [Backend\FileManagerController::class, 'edit'])->name('filemanager.edit');
        Route::post('/filemanager/store', [Backend\FileManagerController::class, 'store'])->name('filemanager.store');
        Route::put('/filemanager/update/{id}', [Backend\FileManagerController::class, 'update'])->name('filemanager.update');
        Route::post('/filemanager/upload', [Backend\FileManagerController::class, 'upload'])->name('filemanager.upload');
        Route::get('/file/{fileName}', [Backend\FileManagerController::class, 'viewFolder'])->name('file');
        Route::get('/folder/{folderName}', [Backend\FileManagerController::class, 'viewFolder'])->name('folder.view');
        Route::get('/file/redirect/{fileName}', [Backend\FileManagerController::class, 'redirectToFilePath'])->name('file.redirect');
        Route::delete('/file/delete/{fileName}', [Backend\FileManagerController::class, 'delete'])->name('file.delete');
        Route::delete('/folder/delete-by-name/{folderName}', [Backend\FileManagerController::class, 'deleteByName'])->name('folder.deleteByName');
        Route::get('/filemanager/folder/{folderName}/{fileName}', [Backend\FileManagerController::class, 'viewFileDetails'])->name('file.view');
        Route::get('/all-files', [Backend\FileManagerController::class, 'viewAllFiles'])->name('allfiles.view');
		Route::post('/move-file-to-folder', [Backend\FileManagerController::class, 'moveFileToFolder']);
		//Admin Files
		Route::get('files-dt', [Backend\FileController::class, 'dataTable'])->name('files-datatable');
		Route::get('/files/create', [Backend\FileController::class, 'create'])->name('files.create');
        Route::delete('/files/destroy/{id}', [Backend\FileController::class, 'destroy'])->name('files.destroy');
        Route::put('/files/update/{id}', [Backend\FileController::class, 'update'])->name('files.update');
        Route::post('/files/store', [Backend\FileController::class, 'store'])->name('files.store');
        Route::get('/files/edit/{id}', [Backend\FileController::class, 'edit'])->name('files.edit');
        // Abteilungen
        Route::get('departement-dt', [Backend\DepartementController::class, 'dataTable'])->name('departement-datatable');
        Route::get('/departement/create', [Backend\DepartementController::class, 'create'])->name('departement.create');
        Route::get('/departement/edit/{id}', [Backend\DepartementController::class, 'edit'])->name('departement.edit');
        Route::delete('/departement/destroy/{id}', [Backend\DepartementController::class, 'destroy'])->name('departement.destroy');
        Route::put('/departement/update/{id}', [Backend\DepartementController::class, 'update'])->name('departement.update');
        Route::post('/departement/store', [Backend\DepartementController::class, 'store'])->name('departement.store');
        
        
        //User
        Route::get('/users/create', [Backend\UserController::class, 'create'])->name('users.create');
        Route::get('/users/edit/{id}', [Backend\UserController::class, 'edit'])->name('users.edit');
        Route::delete('/users/destroy/{id}', [Backend\UserController::class, 'destroy'])->name('users.destroy');
        Route::put('/users/update/{id}', [Backend\UserController::class, 'update'])->name('users.update');
        Route::post('/users/store', [Backend\UserController::class, 'store'])->name('users.store');
		//Profile
		Route::get('/profile/edit/{id}', [Backend\ProfileController::class, 'edit'])->name('profile.edit');
		Route::put('/profile/update/{id}', [Backend\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/change-password/{id}', [Backend\ProfileController::class, 'changePassword'])->name('change-password');
        //Machines
        Route::get('/machines/create', [Backend\MachineController::class, 'create'])->name('machines.create');
        Route::get('/machines/edit/{id}', [Backend\MachineController::class, 'edit'])->name('machines.edit');
        Route::delete('/machines/destroy/{id}', [Backend\MachineController::class, 'destroy'])->name('machines.destroy');
        Route::put('/machines/update/{id}', [Backend\MachineController::class, 'update'])->name('machines.update');
        Route::post('/machines/store', [Backend\MachineController::class, 'store'])->name('machines.store');
        //Roles
        Route::get('/roles/create', [Backend\RoleController::class, 'create'])->name('roles.create');
        Route::get('/roles/edit/{id}', [Backend\RoleController::class, 'edit'])->name('roles.edit');
        Route::delete('/roles/destroy/{id}', [Backend\RoleController::class, 'destroy'])->name('roles.destroy');
        Route::put('/roles/update/{id}', [Backend\RoleController::class, 'update'])->name('roles.update');
        Route::post('/roles/store', [Backend\RoleController::class, 'store'])->name('roles.store');
        //Location
        Route::get('/location/create', [Backend\LocationController::class, 'create'])->name('location.create');
        Route::get('/location/edit/{id}', [Backend\LocationController::class, 'edit'])->name('location.edit');
        Route::delete('/location/destroy/{id}', [Backend\LocationController::class, 'destroy'])->name('location.destroy');
        Route::put('/location/update/{id}', [Backend\LocationController::class, 'update'])->name('location.update');
        Route::post('/location/store', [Backend\LocationController::class, 'store'])->name('location.store');
        //MachineTypes
        Route::get('/machine-types/create', [Backend\MachineTypeController::class, 'create'])->name('machine-types.create');
        Route::get('/machine-types/edit/{id}', [Backend\MachineTypeController::class, 'edit'])->name('machine-types.edit');
        Route::post('/machine-types/store', [Backend\MachineTypeController::class, 'store'])->name('machine-types.store');
        Route::put('/machine-types/update/{id}', [Backend\MachineTypeController::class, 'update'])->name('machine-types.update');
        Route::delete('/machine-types/destroy/{id}', [Backend\MachineTypeController::class, 'destroy'])->name('machine-types.destroy');
        //Task
        Route::get('tasks-dt', [Backend\TaskController::class, 'dataTable'])->name('tasks-datatable');
        Route::get('task/show/{id}', [Backend\TaskController::class, 'show'])->name('tasks.show');
        Route::get('/tasks/create', [Backend\TaskController::class, 'create'])->name('tasks.create');
        Route::post('/tasks/store', [Backend\TaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/edit/{id}', [Backend\TaskController::class, 'edit'])->name('tasks.edit');
        Route::delete('/tasks/destroy/{id}', [Backend\TaskController::class, 'destroy'])->name('tasks.destroy');
        Route::put('/tasks/update/{id}', [Backend\TaskController::class, 'update'])->name('tasks.update');
        //Spareparts
        Route::get('spareparts-dt', [Backend\SparePartController::class, 'dataTable'])->name('spareparts-datatable');
        Route::get('/spareparts/{id}/download', [Backend\SparePartController::class, 'downloadQR'])->name('spareparts.download');
        Route::get('/spareparts/create', [Backend\SparePartController::class, 'create'])->name('spareparts.create');
        Route::post('/spareparts/store', [Backend\SparePartController::class, 'store'])->name('spareparts.store');
        Route::get('/spareparts/edit/{id}', [Backend\SparePartController::class, 'edit'])->name('spareparts.edit');
        Route::delete('/spareparts/destroy/{id}', [Backend\SparePartController::class, 'destroy'])->name('spareparts.destroy');
        Route::put('/spareparts/update/{id}', [Backend\SparePartController::class, 'update'])->name('spareparts.update');
        //UserColor
        Route::get('/get-user-role-color', 'Backend\GetUserRoleColorController@getUserRoleColor');
        //Location
        Route::get('location-dt', [Backend\LocationController::class, 'dataTable'])->name('location-datatable');
        //Work Order
        Route::get('/work-order-details/{id}', [Backend\WorkOrderController::class, 'show'])->name('work-order.details');
        Route::post('/update-work-order/{id}', [Backend\WorkOrderController::class, 'updateStatus'])->name('work-order.update.status');
        Route::get('/calendar', [Backend\WorkOrderController::class, 'calendar']);
        Route::post('/celender-detail', [Backend\WorkOrderController::class, 'getWorkOrderDetails']);
        Route::get('/work-order/create', [Backend\WorkOrderController::class, 'create'])->name('work-order.create');
        Route::post('/work-order/store', [Backend\WorkOrderController::class, 'store'])->name('work-order.store');
        Route::get('/work-order/edit/{id}', [Backend\WorkOrderController::class, 'edit'])->name('work-order.edit');
        Route::delete('/work-order/destroy/{id}', [Backend\WorkOrderController::class, 'destroy'])->name('work-order.destroy');
        Route::put('/work-order/update/{id}', [Backend\WorkOrderController::class, 'update'])->name('work-order.update');
        Route::get('/settings', [Backend\SettingsController::class, 'index'])->name('settings.index'); 
        Route::post('/settings/general-settings', [Backend\SettingsController::class, 'updateSettings'])->name('general-settings.update');
        Route::post('/settings/upload-logo', [Backend\SettingsController::class, 'uploadLogo'])->name('upload-logo');
		Route::post('/settings/upload-icon', [Backend\SettingsController::class, 'uploadIcon'])->name('upload-icon');
		Route::post('/settings/upload-logo-sidebaropenwhite', [Backend\SettingsController::class, 'uploadlogosidebaropenwhite'])->name('upload-logosidebaropenwhite');
		Route::post('/settings/upload-logo-sidebaropendark', [Backend\SettingsController::class, 'uploadlogosidebaropendark'])->name('upload-logosidebaropendark');
		Route::post('/settings/upload-logo-sidebarclosedwhite', [Backend\SettingsController::class, 'uploadlogosidebarclosedwhite'])->name('upload-logosidebarclosedwhite');
		Route::post('/settings/upload-logo-sidebarcloseddark', [Backend\SettingsController::class, 'uploadlogosidebarcloseddark'])->name('upload-logosidebarcloseddark');
        Route::post('/settings/restore-backup', [Backend\SettingsController::class, 'restore'])->name('restore.backup');
        Route::get('/settings/notifications', [Backend\SettingsController::class, 'notification'])->name('general-notifications.index');
        Route::post('/settings/update-maintenance-mode', [Backend\SettingsController::class, 'updateMaintenanceMode'])->name('update-maintenance-mode');
		Route::post('/settings/update-notifications', [Backend\SettingsController::class, 'updateNotifications'])->name('update-notifications');
		Route::post('/settings/smtp/updatesmtp', [Backend\SettingsController::class, 'updatesmtpsettings'])->name('update-smtpsettings');
		Route::get('/settings/smtp', [Backend\SettingsController::class, 'smtpsettings'])->name('smtp.index');
		Route::post('/settings/smtp/send-test-email', [Backend\SettingsController::class, 'sendTestEmail'])->name('smtp.send-test-email');
		Route::get('/maintenance', function () {
    		$maintenanceMode = WebsiteSettings::first()->maintenance_mode;

    			// Überprüfen, ob der Benutzer eingeloggt ist
    		if (auth()->check()) {
        $userType = auth()->user()->user_type;

        // Überprüfen, ob der Benutzer entsprechend seinem user_type in der roles_and_access Tabelle den Wartungsmodus ansehen darf
        $canViewInMaintenance = RoleAndAccess::where('role_name', $userType)
            ->where('can_view_website_in_maintenance_mode', 'yes')
            ->exists();

        if ($maintenanceMode === 'yes' && !$canViewInMaintenance) {
            // Wartungsseite anzeigen, wenn der Wartungsmodus aktiv ist und der Benutzer keine Berechtigung hat
            return view('backend.maintenancemode.maintenance');
        }
    } else {
        if ($maintenanceMode === 'yes') {
            // Wartungsseite anzeigen, wenn der Wartungsmodus aktiv ist und der Benutzer nicht eingeloggt ist
            return view('backend.maintenancemode.maintenance');
        }
    }

    // Umleitung zum Dashboard, wenn der Wartungsmodus nicht aktiv ist oder der Benutzer die erforderlichen Berechtigungen hat
    return redirect()->route('dashboard');
})->name('maintenance');

        Route::group(['middleware' => ['auth', 'role.access', 'password.updated', '2fa', 'maintenance']], function () {
        Route::get('/dashboard', [Backend\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/tasks', [Backend\TaskController::class, 'index'])->name('tasks.index');
        Route::get('/spareparts', [Backend\SparePartController::class, 'index'])->name('spareparts.index');
        Route::get('/work-order', [Backend\WorkOrderController::class, 'index'])->name('work-order.index');
        Route::get('/filemanager', [Backend\FileManagerController::class, 'index'])->name('filemanager.index');
        Route::get('settings/edit-files', [Backend\FileController::class, 'index'])->name('files.index');
        Route::get('settings/users', [Backend\UserController::class, 'index'])->name('users.index');
        Route::get('settings/roles', [Backend\RoleController::class, 'index'])->name('roles.index');
        Route::get('settings/machine-types', [Backend\MachineTypeController::class, 'index'])->name('machine-types.index');
        Route::get('settings/machines', [Backend\MachineController::class, 'index'])->name('machines.index');
        Route::get('settings/location', [Backend\LocationController::class, 'index'])->name('location.index');
        Route::get('settings/abteilungen', [Backend\DepartementController::class, 'index'])->name('departement.index');
		Route::get('/settings/general-settings', [Backend\SettingsController::class, 'settings'])->name('general-settings.index');
        });
    });
});
        // Frontend Routes
        Route::redirect('/', '/login');

        Route::get('/clear-cache', function () {
        Artisan::call('optimize:clear');
        return 'Cache cleared successfully.';
        });

        Route::get('/create-storage-link', function () {
        Artisan::call('storage:link');
        return 'Storage link created successfully.';
    });

        Route::get('/fresh-migrate-and-seed', function () {
        Artisan::call('migrate:fresh', ['--seed' => true]);
        return 'Fresh migration and seeding completed successfully.';
    });
