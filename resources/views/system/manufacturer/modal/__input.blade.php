@php $a = $manufacturer->address ?? null; @endphp

<div class="row g-3">
    <div class="col-12">
        <label class="form-label" for="ManufacturerName">Manufacturer Name <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-industry"></i></span>
            <input type="text" name="ManufacturerName" id="ManufacturerName" class="form-control" placeholder="e.g. ACI HealthCare Limited" required value="{{ $manufacturer->ManufacturerName ?? '' }}">
            <div class="invalid-feedback">Required.</div>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label" for="address_type">Address Type <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-building"></i></span>
            <select id="address_type" class="form-select" name="address_type" required>
                <option value="" disabled @selected(! $a)>Select Type</option>
                <option value="Office"  @selected(($a?->address_type ?? null) === 'Office')>Office Address</option>
                <option value="Factory" @selected(($a?->address_type ?? null) === 'Factory')>Factory Address</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="phone">Phone Number</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-phone"></i></span>
            <input type="text" id="phone" name="phone" class="form-control" placeholder="+880 96 0666 6711" value="{{ $a?->phone ?? '' }}">
        </div>
    </div>

    <div class="col-md-8">
        <label class="form-label" for="address_line_1">Address <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-location-dot"></i></span>
            <input type="text" class="form-control" id="address_line_1" name="address_line_1" placeholder="Street, area" required value="{{ $a?->address_line_1 ?? '' }}">
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="address_line_2">Country <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-flag"></i></span>
            <input type="text" class="form-control" id="address_line_2" name="address_line_2" placeholder="Country" required value="{{ $a?->address_line_2 ?? '' }}">
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label" for="city">City <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-city"></i></span>
            <input type="text" class="form-control" id="city" name="city" placeholder="Dhaka" required value="{{ $a?->city ?? '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="zip_code">Zip Code <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-hashtag"></i></span>
            <input type="number" class="form-control" id="zip_code" name="zip_code" placeholder="1440" required value="{{ $a?->zip_code ?? '' }}">
        </div>
    </div>

    <div class="col-12">
        <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email" placeholder="info@example.com" required value="{{ $a?->email ?? '' }}">
        </div>
    </div>
</div>
