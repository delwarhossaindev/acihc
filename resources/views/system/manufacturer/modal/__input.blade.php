   <div class="row">
        <div class="col mb-3">
        <label for="nameBasic" class="form-label">Manufacturer Name</label><span style="color: red">*</span>
        <input type="text" name="ManufacturerName" id="nameBasic" class="form-control" placeholder="Manufacturer Name" required value="{{ isset($manufacturer) ? $manufacturer->ManufacturerName : '' }}">
        </div>
   </div>
   <div class="row g-2">
    <div class="col mb-2">
        <label for="language" class="form-label">Address Type</label><span style="color: red">*</span>
        <select id="language" class="custom-select form-control" name="address_type" required>
            <option value="" selected disabled>Select Type</option>
            <option value="Office" 
            @if(isset($manufacturer->address))
            {{ $manufacturer->address->address_type == 'Office' ? 'selected' : '' }}
            @endif
            >Office Address</option>
            <option value="Factory"
            @if(isset($manufacturer->address))
            {{ $manufacturer->address->address_type == 'Factory' ? 'selected' : '' }}
            @endif
            >Factory Address</option>
        </select>
    </div>
    <div class="col mb-2">
        <label class="form-label" for="phoneNumber">Phone Number</label>
        <input type="text" id="phoneNumber" name="phone" class="form-control" placeholder="202 555 0111" value="{{ isset($manufacturer->address) ? $manufacturer->address->phone : '' }}">
        <div class="invalid-tooltip">This field is required</div>
    </div>
  </div>

   <div class="row g-2">
        <div class="col mb-2">
            <label for="address" class="form-label">Address</label><span style="color: red">*</span>
            <input type="text" class="form-control" id="address" name="address_line_1" placeholder="Address Line One" required value="{{ isset($manufacturer->address) ? $manufacturer->address->address_line_1 : '' }}">
        </div>
        <div class="col mb-2">
            <label for="address" class="form-label">Country</label><span style="color: red">*</span>
            <input type="text" class="form-control" id="address" name="address_line_2" placeholder="Country" required value="{{ isset($manufacturer->address) ? $manufacturer->address->address_line_2 : '' }}">
        </div>
   </div>

   <div class="row g-2">
        <div class="col mb-2">
            <label for="address" class="form-label">City</label><span style="color: red">*</span>
            <input type="text" class="form-control" id="address" name="city" placeholder="Dhaka" required value="{{ isset($manufacturer->address) ? $manufacturer->address->city : '' }}">
        </div>
        <div class="col mb-2">
            <label for="address" class="form-label">Zip Code</label><span style="color: red">*</span>
            <input type="number" class="form-control" id="address" name="zip_code" placeholder="1440" required value="{{ isset($manufacturer->address) ? $manufacturer->address->zip_code : '' }}">
        </div>
    </div>

    <div class="row g-2">
        <div class="col mb-2">
            <label for="email" class="form-label">Email</label><span style="color: red">*</span>
            <input type="email" class="form-control" id="email" name="email" placeholder="example@aci.bd.com" required value="{{ isset($manufacturer->address) ? $manufacturer->address->email : '' }}">
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-block mt-2">Save changes</button>
