@php
    $isEdit = isset($spareparts);
    $url = $isEdit ? route('spareparts.update', $spareparts->id) : route('spareparts.store');
@endphp

<form action="{{ $url }}" method="post" data-form="ajax-form" data-modal="#ajax-modal"
    data-datatable="#sparepart_datatable">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="spare_part_number">Ersatzteilnummer <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="spare_part_number" id="spare_part_number"
                    value="{{ $isEdit ? $spareparts->spare_part_number : '' }}"
                    oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')" required>
            </div>
            <div class="form-group">
                <label for="name_of_part">Bezeichnung des Teiles <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name_of_part" id="name_of_part"
                    value="{{ $isEdit ? $spareparts->name_of_part : '' }}" required>
            </div>
            <div class="form-group">
                <label for="supplier">Anbieterin <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="supplier" id="supplier"
                    value="{{ $isEdit ? $spareparts->supplier : '' }}" required>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="image">Artikel Foto</label> <br>
            @if (!$isEdit || Auth::user()->user_type !== 'ih')
                <input type="file" class="form-control" name="image" id="imageInput">
            @endif
            @if ($isEdit && $spareparts->image)
                <img id="imagePreview" src="{{ asset('storage/' . $spareparts->image) }}" alt="Image Preview"
                    class="br-5" style="width: 50%; margin-top: 20px; height: auto;">
            @else
                <img id="imagePreview" src="" alt="Image Preview" class="br-5"
                    style="width: 50%; margin-top: 20px; height: auto; display: none;">
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="stock_location">Lagerplatz</label>
                <div class="row px-2">
                    <div class="col-md-9 p-0">
                        <select class="form-control select2 form-select" name="stock_location" id="stock_location" required>
                            <option value="">Lagerplatz auswählen</option>
                            @foreach ($location as $locations)
                                <option value="{{ $locations->id }}" @if ($isEdit && $spareparts && $spareparts->location_id == $locations->id) selected @endif>
                                    {{ $locations->name }}
                                </option>
                            @endforeach
                        </select>
</div>
             <div class="col-md-3 px-lg-0">
                        <input type="number" class="form-control" name="location_number" id="location_number"
                            value="{{ $isEdit && $spareparts ? $spareparts->location_number : '' }}"
                            placeholder="Position"oninput="this.value = this.value.replace(/[^0-9]/g, '')" >   
            </div>
					 </div>
				</div>
            <div class="form-group">
                <label for="minimum_stock">Mindestbestand <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="minimum_stock" id="minimum_stock"
                    value="{{ $isEdit ? $spareparts->minimum_stock : '' }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
            </div>
            <div class="form-group">
                <label for="current_stock">Aktueller Lagerbestand <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="current_stock" id="current_stock"
                    value="{{ $isEdit ? $spareparts->current_stock : '' }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
            </div>
           <div class="form-group">
                <label for="price_per_piece">Preis pro Stück <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">€</span>
                    </div>
                  <input type="text" class="form-control" name="price_per_piece" id="price_per_piece"
                    value="{{ $isEdit ? number_format($spareparts->price_per_piece, 2, '.', '') : '' }}"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); if(this.value.split('.').length > 2) this.value = this.value.replace(/\.+$/, '');"
                    pattern="^\d+(\.\d{1,2})?$"
                    title="Please enter a valid price (up to 2 decimal places)" required>
                </div>
             </div>
        </div>
               @if ($isEdit)
            <div class="col-lg-6">
                <h5 for="qr_code">QR Code</h5>
                <div class="d-flex">
                    <div class="w-50">
                        <img id="imagePreview" src="{{ asset('storage/' . $spareparts->qr_code) }}"
                            alt="qr_code Preview" class="br-5">
                    </div>
                    <div class="ml-3 mx-3">
                        <h4>QR Code:</h4>
                        <p>{{ $spareparts->spare_part_number }}</p>
                        <h4>Bezeichnung:</h4>
                        <p>{{ $spareparts->name_of_part }}</p>
                        @if ($spareparts->location && $spareparts->location->name && $spareparts->location_number)
                            <h4>Lagerplatz:</h4>
                            <p>{{ $spareparts->location->name }}-{{ $spareparts->location_number }}</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('spareparts.download', $spareparts->id) }}" class="btn btn-primary mt-1">Drucken</a>
            </div>
        @endif
    </div>
    <div class="row">
        {{-- @if (!$isEdit)
            <div class="form-group col-lg-6">
                <label for="status">Status</label>
                <select class="form-control select2 form-select" name="status" id="status">
                    <option value="in_stock" {{ $isEdit && $spareparts->status === 'in_stock' ? 'selected' : '' }}>In
                        Stock
                    </option>
                    <option value="out_of_stock"
                        {{ $isEdit && $spareparts->status === 'out_of_stock' ? 'selected' : '' }}>
                        Out of Stock</option>
                </select>
            </div>
        @endif --}}
        <div class="col-lg-12">
    @if ($isEdit)
        <button type="submit" class="btn btn-primary" data-button="submit">Aktualisieren</button>
    @else
        <button type="submit" class="btn btn-primary" data-button="submit">Hinzufügen</button>
    @endif
</div>
    </div>

</form>