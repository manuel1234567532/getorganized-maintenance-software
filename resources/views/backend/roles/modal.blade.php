@php
    $isEdit = isset($roles) ? true : false;
    $url = $isEdit ? route('roles.update', $roles->id) : route('roles.store');
    $role = DB::table('roles')->get();
@endphp
<form action="{{$url}}" method="post" data-form="ajax-form" data-modal="#ajax-modal" data-datatable="#roles_datatable">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
<div class="row">
    <div class="form-group col-lg-6">
    <label for="role_name">Rollenname <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="role_name" id="role_name" value="{{ $isEdit ? $roles->role_name : '' }}">
</div>


        <div class="form-group col-lg-6">
            <label for="role_color">Rollenfarbe</label>
            <input type="color" class="form-control" name="role_color" id="role_color" value="{{$isEdit ? $roles->role_color : '#000000'}}">
        </div>
        <div class="form-group col-lg-6">
    <label for="is_deleteable">Rolle löschbar?</label>
    <select class="form-control" name="is_deleteable" id="is_deleteable">
        <option value="no" {{ $isEdit && $roles->is_deleteable == 'no' ? 'selected' : '' }}>Nein</option>
        <option value="yes" {{ !$isEdit || $roles->is_deleteable == 'yes' ? 'selected' : '' }}>Ja</option>
    </select>
</div>

{{-- Aufgaben Bereich --}}
        <div class="col-lg-12 mt-4">
            <h5>Aufgaben</h5>
            <div class="row">
                   {{-- Dropdown für can_view_tasks --}}
        <div class="form-group col-lg-6">
            <label for="can_view_tasks">Kann /Aufgaben aufrufen</label>
            <select class="form-control" name="can_view_tasks" id="can_view_tasks">
                <option value="no" {{ $isEdit && $roles->can_view_tasks == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_view_tasks == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
        {{-- Dropdown für can_create_task --}}
        <div class="form-group col-lg-6">
            <label for="can_create_task">Kann Aufgaben erstellen</label>
            <select class="form-control" name="can_create_task" id="can_create_task">
                <option value="no" {{ $isEdit && $roles->can_create_task == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_create_task == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
         {{-- Dropdown für can_edit_task --}}
        <div class="form-group col-lg-6">
            <label for="can_edit_task">Kann Aufgaben bearbeiten</label>
            <select class="form-control" name="can_edit_task" id="can_edit_task">
                <option value="no" {{ $isEdit && $roles->can_edit_task == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_edit_task == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
         {{-- Dropdown für can_delete_task --}}
        <div class="form-group col-lg-6">
            <label for="can_delete_task">Kann Aufgaben löschen</label>
            <select class="form-control" name="can_delete_task" id="can_delete_task">
                <option value="no" {{ $isEdit && $roles->can_delete_task == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_delete_task == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
    </div>
</div>
{{-- Ersatzteile Bereich --}}
        <div class="col-lg-12 mt-4">
            <h5>Ersatzteile</h5>
            <div class="row">
                   {{-- Dropdown für can_view_spareparts --}}
        <div class="form-group col-lg-6">
            <label for="can_view_spareparts">Kann /Ersatzteile aufrufen</label>
            <select class="form-control" name="can_view_spareparts" id="can_view_spareparts">
                <option value="no" {{ $isEdit && $roles->can_view_spareparts == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_view_spareparts == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
{{-- Dropdown für can_create_sparepart --}}
        <div class="form-group col-lg-6">
            <label for="can_create_sparepart">Kann Ersatzteile erstellen</label>
            <select class="form-control" name="can_create_sparepart" id="can_create_sparepart">
                <option value="no" {{ $isEdit && $roles->can_create_sparepart == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_create_sparepart == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
        {{-- Dropdown für can_edit_sparepart --}}
        <div class="form-group col-lg-6">
            <label for="can_edit_sparepart">Kann Ersatzteile bearbeiten</label>
            <select class="form-control" name="can_edit_sparepart" id="can_edit_sparepart">
                <option value="no" {{ $isEdit && $roles->can_edit_sparepart == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_edit_sparepart == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
          {{-- Dropdown für can_delete_sparepart --}}
        <div class="form-group col-lg-6">
            <label for="can_delete_sparepart">Kann Ersatzteile löschen</label>
            <select class="form-control" name="can_delete_sparepart" id="can_delete_sparepart">
                <option value="no" {{ $isEdit && $roles->can_delete_sparepart == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_delete_sparepart == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
    </div>
</div>
    {{-- Arbeitsaufträge Bereich --}}
        <div class="col-lg-12 mt-4">
            <h5>Arbeitsaufträge</h5>
            <div class="row">
            <div class="form-group col-lg-6">
           <label for="can_view_workorders">Kann /Arbeitsaufträge aufrufen</label>
            <select class="form-control" name="can_view_workorders" id="can_view_workorders">
                <option value="no" {{ $isEdit && $roles->can_view_workorders == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_view_workorders == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
 {{-- Dropdown für can_create_workorder --}}
        <div class="form-group col-lg-6">
            <label for="can_create_workorder">Kann Arbeitsaufträge erstellen</label>
            <select class="form-control" name="can_create_workorder" id="can_create_workorder">
                <option value="no" {{ $isEdit && $roles->can_create_workorder == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_create_workorder == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
      </div>
</div>
      {{-- Dateimanager Bereich --}}
        <div class="col-lg-12 mt-4">
            <h5>Dateimanager</h5>
            <div class="row">
                 {{-- Dropdown für can_view_filemanager --}}
                   <div class="form-group col-lg-6">
            <label for="can_view_filemanager">Kann /Dateimanager aufrufen</label>
            <select class="form-control" name="can_view_filemanager" id="can_view_filemanager">
                <option value="no" {{ $isEdit && $roles->can_view_filemanager == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_view_filemanager == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
        {{-- Dropdown für can_create_folders --}}
                   <div class="form-group col-lg-6">
            <label for="can_create_folders">Kann Ordner erstellen</label>
            <select class="form-control" name="can_create_folders" id="can_create_folders">
                <option value="no" {{ $isEdit && $roles->can_create_folders == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_create_folders == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
        {{-- Dropdown für can_edit_folders --}}
                   <div class="form-group col-lg-6">
            <label for="can_edit_folders">Kann Ordner bearbeiten</label>
            <select class="form-control" name="can_edit_folders" id="can_edit_folders">
                <option value="no" {{ $isEdit && $roles->can_edit_folders == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_edit_folders == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
        {{-- Dropdown für can_delete_folders --}}
                   <div class="form-group col-lg-6">
            <label for="can_delete_folders">Kann Ordner löschen</label>
            <select class="form-control" name="can_delete_folders" id="can_delete_folders">
                <option value="no" {{ $isEdit && $roles->can_delete_folders == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_delete_folders == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
         {{-- Dropdown für can_upload_files --}}
                   <div class="form-group col-lg-6">
            <label for="can_upload_files">Kann Dateien Hochladen</label>
            <select class="form-control" name="can_upload_files" id="can_upload_files">
                <option value="no" {{ $isEdit && $roles->can_upload_files == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_upload_files == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
         {{-- Dropdown für can_move_files --}}
                   <div class="form-group col-lg-6">
            <label for="can_move_files">Kann Dateien verschieben</label>
            <select class="form-control" name="can_move_files" id="can_move_files">
                <option value="no" {{ $isEdit && $roles->can_move_files == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_move_files == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
         {{-- Dropdown für can_delete_files --}}
                   <div class="form-group col-lg-6">
            <label for="can_delete_files">Kann Dateien löschen</label>
            <select class="form-control" name="can_delete_files" id="can_delete_files">
                <option value="no" {{ $isEdit && $roles->can_delete_files == 'no' ? 'selected' : '' }}>Nein</option>
                <option value="yes" {{ $isEdit && $roles->can_delete_files == 'yes' ? 'selected' : '' }}>Ja</option>
            </select>
        </div>
    </div>
</div>
    
       
        {{-- Admin Bereich --}}
        <div class="col-lg-12 mt-4">
            <h5>Admin Bereich</h5>
            <div class="row">
				  {{-- Dropdown für can_view_website_settings --}}
                <div class="form-group col-lg-6">
                    <label for="can_view_users">Kann /Website Settings aufrufen</label>
                    <select class="form-control" name="can_view_website_settings" id="can_view_website_settings">
                        <option value="no" {{ $isEdit && $roles->can_view_website_settings == 'no' ? 'selected' : '' }}>Nein</option>
                        <option value="yes" {{ $isEdit && $roles->can_view_website_settings == 'yes' ? 'selected' : '' }}>Ja</option>
                    </select>
                </div>
                {{-- Dropdown für can_view_users --}}
                <div class="form-group col-lg-6">
                    <label for="can_view_users">Kann /Benutzer aufrufen</label>
                    <select class="form-control" name="can_view_users" id="can_view_users">
                        <option value="no" {{ $isEdit && $roles->can_view_users == 'no' ? 'selected' : '' }}>Nein</option>
                        <option value="yes" {{ $isEdit && $roles->can_view_users == 'yes' ? 'selected' : '' }}>Ja</option>
                    </select>
                </div>
                
                  {{-- Dropdown für can_view_roles --}}
                <div class="form-group col-lg-6">
                    <label for="can_view_roles">Kann /Rollen aufrufen</label>
                    <select class="form-control" name="can_view_roles" id="can_view_roles">
                        <option value="no" {{ $isEdit && $roles->can_view_roles == 'no' ? 'selected' : '' }}>Nein</option>
                        <option value="yes" {{ $isEdit && $roles->can_view_roles == 'yes' ? 'selected' : '' }}>Ja</option>
                    </select>
                </div>
                
                {{-- Dropdown für can_view_categories --}}
                <div class="form-group col-lg-6">
                    <label for="can_view_categories">Kann /Kategorien aufrufen</label>
                    <select class="form-control" name="can_view_categories" id="can_view_categories">
                        <option value="no" {{ $isEdit && $roles->can_view_categories == 'no' ? 'selected' : '' }}>Nein</option>
                        <option value="yes" {{ $isEdit && $roles->can_view_categories == 'yes' ? 'selected' : '' }}>Ja</option>
                    </select>
                </div>
                
                {{-- Dropdown für can_view_machines --}}
                <div class="form-group col-lg-6">
                    <label for="can_view_machines">Kann /Maschinen aufrufen</label>
                    <select class="form-control" name="can_view_machines" id="can_view_machines">
                        <option value="no" {{ $isEdit && $roles->can_view_machines == 'no' ? 'selected' : '' }}>Nein</option>
                        <option value="yes" {{ $isEdit && $roles->can_view_machines == 'yes' ? 'selected' : '' }}>Ja</option>
                    </select>
                </div>
                
                {{-- Dropdown für can_view_locations --}}
                <div class="form-group col-lg-6">
                    <label for="can_view_locations">Kann /Standorte aufrufen</label>
                    <select class="form-control" name="can_view_locations" id="can_view_locations">
                        <option value="no" {{ $isEdit && $roles->can_view_locations == 'no' ? 'selected' : '' }}>Nein</option>
                        <option value="yes" {{ $isEdit && $roles->can_view_locations == 'yes' ? 'selected' : '' }}>Ja</option>
                    </select>
                </div>
            {{-- Dropdown für can_view_files --}}
                <div class="form-group col-lg-6">
                    <label for="can_view_files">Kann /Dateien aufrufen</label>
                    <select class="form-control" name="can_view_files" id="can_view_files">
                        <option value="no" {{ $isEdit && $roles->can_view_files == 'no' ? 'selected' : '' }}>Nein</option>
                        <option value="yes" {{ $isEdit && $roles->can_view_files == 'yes' ? 'selected' : '' }}>Ja</option>
                    </select>
                </div>
				 {{-- Dropdown für can_view_website_in_maintenance_mode --}}
                <div class="form-group col-lg-6">
                    <label for="can_view_website_in_maintenance_mode">Kann die Webseite im Wartungsmodus betreten?</label>
                    <select class="form-control" name="can_view_website_in_maintenance_mode" id="can_view_website_in_maintenance_mode">
                        <option value="no" {{ $isEdit && $roles->can_view_website_in_maintenance_mode == 'no' ? 'selected' : '' }}>Nein</option>
                        <option value="yes" {{ $isEdit && $roles->can_view_website_in_maintenance_mode == 'yes' ? 'selected' : '' }}>Ja</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12">
    @if ($isEdit)
        <button type="submit" class="btn btn-primary" data-button="submit">Aktualisieren</button>
    @else
        <button type="submit" class="btn btn-primary" data-button="submit">Hinzufügen</button>
    @endif
</div>
    </div>
</form>