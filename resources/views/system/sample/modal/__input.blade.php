  <div class="row g-2">
        <div class="col mb-2">
        <label for="ProductID" class="form-label">Product</label><span style="color: red">*</span>
        <select id="ProductID" class="select2 form-select custom-select" name="ProductID" required>
            <option value="" selected disabled>Select Product</option>
            @foreach (@App\Models\Product::all() as $product)
            <option value="{{ $product->ProductID }}" {{ isset($sample) ? $sample->ProductID == $product->ProductID  ? 'selected' : '' : ''}}>
                {{ $product->ProductName }}
                @foreach ($product->details as $strength)({{ $strength->ProductStrength }})@endforeach
                | Packs:
                @foreach ($product->packs as $pack) ({{ $pack->PackValue }}) @endforeach
            </option>
            @endforeach
        </select>
        </div>
   </div>

   <div class="row g-2">
        <!-- <div class="col mb-1">
            <label for="Headline" class="form-label">Headline</label><span style="color: red">*</span>
            <input type="text" class="form-control" id="Headline" name="Headline" placeholder="Headline" required value="{{ isset($sample) ? $sample->Headline : '' }}">
        </div> -->
        <div class="col mb-2">
        <label for="SpecificationNo<" class="form-label">Specification No</label><span style="color: red">*</span>
        <input type="text" class="form-control" id="SpecificationNo" name="SpecificationNo" placeholder="SpecificationNo" required value="{{ isset($sample) ? $sample->SpecificationNo : '' }}">
        </div>
    </div>

   <div class="row g-2">
    <div class="col mb-2">
        <label for="ManufacturerID" class="form-label">Manufacturer</label><span style="color: red">*</span>
        <select id="ManufacturerID" class="select2 form-select custom-select" name="ManufacturerID" required>
            <option value="" selected disabled>Select Manufacturer</option>
            @foreach (@App\Models\Manufacturer::all() as $manufacturer)
            <option value="{{ $manufacturer->ManufacturerID }}" {{ isset($sample) ? $sample->ManufacturerID == $manufacturer->ManufacturerID  ? 'selected' : '' : ''}}>
                {{ $manufacturer->ManufacturerName }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="col mb-2">
        <label class="form-label" for="ProtocolID">Protocol</label><span style="color: red">*</span>
        <select id="ProtocolID" class="select2 form-select custom-select" name="ProtocolID" required>
            <option value="" selected disabled>Select Protocol</option>
            @foreach (@App\Models\Protocol::all() as $protocol)
            <option value="{{ $protocol->ProtocolID }}" {{ isset($sample) ? $sample->ProtocolID == $protocol->ProtocolID  ? 'selected' : '' : ''}}>
                {{ $protocol->Title }}
            </option>
            @endforeach
        </select>
    </div>
  </div>

   <div class="row g-2">
        <div class="col mb-2">
            <label for="GRN_NUMBER" class="form-label">GRN Number</label><span style="color: red">*</span>
            <input type="text" class="form-control" id="GRN_NUMBER" name="GRN_NUMBER" placeholder="GRN Number" required value="{{ isset($sample) ? $sample->GRN_NUMBER : '' }}">
        </div>
        <div class="col mb-2">
            <label for="ReceivingDate" class="form-label">Receiving Date</label><span style="color: red">*</span>
            <input type="date" class="form-control" id="ReceivingDate" name="ReceivingDate" placeholder="Receiving Date" required value="{{ isset($sample) ? $sample->ReceivingDate : '' }}">
        </div>
   </div>

    <div class="row g-2">
        <div class="col mb-2">
            <label for="Remark" class="form-label">Remark</label>
            <input type="text" class="form-control" id="Remark" name="Remark" placeholder="Remark" required value="{{ isset($sample) ? $sample->Remark : '' }}">
        </div>
        <div class="col mb-2">
            <label for="Remark" class="form-label">Packaging Date</label>
            <input type="date" class="form-control" id="PackagingDate" name="PackagingDate" required value="{{ isset($sample) ? $sample->PackagingDate : '' }}">
        </div>
    </div>

  

    <div class="row g-2">
        <div class="col mb-2">
        <label for="FooterSection" class="form-label">Footer Section</label><span style="color: red">*</span>
        <input type="text" class="form-control" id="FooterSection" name="FooterSection" placeholder="Footer Section" required value="{{ isset($sample) ? $sample->FooterSection : '' }}">
        </div>
        <div class="col mb-2">
        <label for="STPNo<" class="form-label">STP No</label><span style="color: red">*</span>
        <input type="text" class="form-control" id="STPNo" name="STPNo" placeholder="STP No" required value="{{ isset($sample) ? $sample->STPNo : '' }}">
        </div>
    </div>

    <!-- <div class="row g-2">
        <div class="col mb-4">
            <label class="form-label" for="note">Note</label><span style="color: red">*</span>
            <textarea id="note" name="Note" class="form-control" rows="5" placeholder="Note" required>{{ isset($sample) ? $sample->Note : '' }}</textarea>
        </div>
    </div> -->

    <button type="submit" class="btn btn-primary mt-2">Save changes</button>

