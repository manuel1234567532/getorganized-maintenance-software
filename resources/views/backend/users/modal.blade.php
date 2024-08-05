@php
    $isEdit = isset($user) ? true : false;
    $url = $isEdit ? route('users.update', $user->id) : route('users.store');
    $roles = \App\Models\RoleAndAccess::pluck('role_name'); // Holen Sie sich die Rollen aus der roles_and_access-Tabelle
@endphp

<form action="{{$url}}" method="post" data-form="ajax-form" data-modal="#ajax-modal" data-datatable="#users_datatable">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="username">Benutzername <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="username" id="username" value="{{$isEdit ? $user->username : ''}}">
        </div>
        <div class="form-group col-lg-6">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" id="email" value="{{$isEdit ? $user->email : ''}}">
        </div>
        <div class="form-group col-lg-6">
            <label for="phone">{{ __('messages.phone') }} <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="phone" id="phone" value="{{$isEdit ? $user->phone : ''}}">
        </div>
        <div class="form-group col-lg-6">
            <label for="first_name">Vorname <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="first_name" id="first_name" value="{{$isEdit ? $user->first_name : ''}}">
        </div>
       <div class="form-group col-lg-6">
            <label for="last_name">Nachname <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="last_name" id="last_name" value="{{$isEdit ? $user->last_name : ''}}">
        </div>
       <div class="form-group col-lg-6">
    <label class="form-label" for="birthday">Geburtstag <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="birthday" name="birthday" placeholder="TT.MM.JJJJ" required value="{{ auth()->user()->birthday ? \Carbon\Carbon::parse(auth()->user()->birthday)->format('d.m.Y') : '' }}">
</div>

 <div class="form-group col-lg-6">
    <label for="password">{{ __('messages.password') }}<span class="text-danger">* = "12Magna34"</span></label>
    <input type="password" class="form-control" name="password" id="password" value="12Magna34">
</div>
        <div class="form-group col-lg-6">
            <label for="password_confirmation">{{ __('messages.confirm_password') }}</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="12Magna34">
        </div>
       <div class="form-group col-lg-6">
    <label for="department">Abteilung <span class="text-danger">*</span></label>
    <select class="form-control select2 form-select" name="department" id="department">
        @foreach($departments as $department)
            <option value="{{ $department->departement_name }}" @if ($isEdit && $user->department == $department->departement_name) selected @endif>
                {{ $department->departement_name }}
            </option>
        @endforeach
    </select>
</div>

    <div class="form-group col-lg-6">
            <label for="role">Rolle <span class="text-danger">*</span></label>
            <select class="form-control select2 form-select" name="role" id="role">
                @foreach($roles as $role)
                    <option value="{{ $role }}" @if ($isEdit && $user->user_type == $role) selected @endif>
                        {{ $role }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control select2 form-select" name="status" id="status">
                <option value="active" @if ($isEdit && $user->status == 'active') selected @endif>Active</option>
                <option value="inactive" @if ($isEdit && $user->status == 'inactive') selected @endif>Inactive</option>
            </select>
        </div>
    </div>
    <div class="col-lg-12">
    @if ($isEdit)
        <button type="submit" class="btn btn-primary" data-button="submit">Aktualisieren</button>
    @else
        <button type="submit" class="btn btn-primary" data-button="submit">Hinzufügen</button>
    @endif
</div>
</form>
<script>
  // Setze den Wert des Passwortfelds
    var passwordField = document.getElementById("password");
    passwordField.value = "12Magna34";
    
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#birthday", {
            dateFormat: "d.m.Y",
            allowInput: true, // Allow manual input
        });
    });
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
