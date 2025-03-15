<div class="row g-3" data-select2-id="8">
    <div class="col-sm-6 fv-plugins-icon-container">
        <label class="form-label" for="Title">Title</label> <span style="color: red">*</span>
        <input type="text" id="Title" name="Title" class="form-control" placeholder="Title" required value="{{ isset($protocol) ? $protocol->Title : ''}}">
    </div>
    <div class="col-sm-6 fv-plugins-icon-container">
        <label class="form-label" for="Purpose">Purpose</label> <span style="color: red">*</span>
        <input type="text" id="Purpose" name="Purpose" class="form-control" placeholder="Purpose" required value="{{ isset($protocol) ? $protocol->Purpose : ''}}">
    </div>
    <div class="col-sm-6 fv-plugins-icon-container">
        <label class="form-label" for="Purpose">Reference</label> <span style="color: red">*</span>
        <input type="text" id="Reference" name="Reference" class="form-control" placeholder="Reference" required value="{{ isset($protocol) ? $protocol->Reference : ''}}">
    </div>
    <div class="col-sm-6 fv-plugins-icon-container">
        <label class="form-label" for="FooterSectionNo">Footer Section No</label> <span style="color: red">*</span>
        <input type="text" id="FooterSectionNo" name="FooterSectionNo" class="form-control" placeholder="Footer Section No" required value="{{ isset($protocol) ? $protocol->FooterSectionNo : ''}}">
    </div>
    <div class="col-lg-12">
        <label class="form-label" for="Purpose">Scope</label> <span style="color: red">*</span>
        <textarea id="Scope" name="Scope" class="form-control" rows="2" placeholder="Scope" required>{{ isset($protocol) ? $protocol->Scope : ''}}</textarea>
    </div>
    <div class="col-lg-12">
        <label class="form-label" for="Responsibilities">Responsibilities</label><span style="color: red">*</span>
        <textarea id="Responsibilities" name="Responsibilities" class="form-control" rows="2" placeholder="Responsibilities" required>{{ isset($protocol) ? $protocol->Responsibilities : ''}}</textarea>
    </div>
    <div class="col-sm-12">
        <label for="MarketID" class="form-label">Product</label> <span style="color: red">*</span>
        <select class="select2 form-select form-select-lg select2-hidden-accessible" name="ProductID" required>
            <option value="" disabled selected>Select Product</option>
            @foreach (\App\Models\Product::all() as $item)
            <option value="{{ $item->ProductID }}" {{ isset($protocol) ? $item->ProductID == $protocol->ProductID ? 'Selected' : '' : '' }} {{ isset($protocol) ? $item->ProductID != $protocol->ProductID ? 'Disabled' : '' : '' }}>{{ $item->ProductName }} @foreach ($item->details as $strength)({{ $strength->ProductStrength }})@endforeach | Packs: @foreach ($item->packs as $pack) ({{ $pack->PackValue }}) @endforeach</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-6">
        <label for="MarketID" class="form-label">Market</label> <span style="color: red">*</span>
        <select class="form-control custom-select" name="MarketID" required>
            <option value="" disabled selected>Select Market</option>
            @foreach (\App\Models\Market::all() as $item)
            <option value="{{ $item->MarketID }}" {{ isset($protocol) ? $item->MarketID == $protocol->MarketID ? 'Selected' : '' : '' }} >{{ $item->MarketName }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-6">
        <label for="ManufacturerID" class="form-label">Manufacturer</label> <span style="color: red">*</span>
        <select class="form-control custom-select" name="ManufacturerID" required>
            <option value="" disabled selected>Select Manufacturer</option>
            @foreach (\App\Models\Manufacturer::all() as $item)
            <option value="{{ $item->ManufacturerID }}"  {{ isset($protocol) ? $item->ManufacturerID == $protocol->ManufacturerID ? 'Selected' : '' : '' }} >{{ $item->ManufacturerName }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-12">
        <label class="form-label" for="AnalysisReport">Stability Specifications And Analysis Report</label> <span style="color: red">*</span>
        <textarea rows="10" id="AnalysisReport" name="AnalysisReport" class="form-control" placeholder="AnalysisReport" required>{{ isset($protocol) ? $protocol->AnalysisReport : ''}}</textarea>
    </div>
    <div class="col-lg-12">
        <label class="form-label" for="Reporting">Reporting</label> <span style="color: red">*</span>
        <textarea id="Reporting" name="Reporting" class="form-control" rows="3" placeholder="Reporting" required>{{ isset($protocol) ? $protocol->Reporting : ''}}</textarea>
    </div>
    <div class="col-lg-12">
        <label class="form-label" for="Conclusion">Conclusion</label> <span style="color: red">*</span>
        <textarea id="Conclusion" name="Conclusion" class="form-control" rows="3" placeholder="Conclusion" required>{{ isset($protocol) ? $protocol->Conclusion : ''}}</textarea>
    </div>
    <div class="col-lg-12">
        <label class="form-label" for="RevisionHistory">Revision History</label> <span style="color: red">*</span>
        <textarea id="Revision History" name="RevisionHistory" class="form-control" rows="3" placeholder="Revision History" required>{{ isset($protocol) ? $protocol->RevisionHistory : ''}}</textarea>
    </div>
    <div class="col-lg-12">
        <label class="form-label" for="summernote">Note</label>
        <textarea id="note" name="Note" class="form-control" rows="3" placeholder="Note" required>{{ isset($protocol) ? $protocol->Note : ''}}</textarea>
    </div>
    <!-- <div class="col-4"> 
    <label class="form-label" >Review By (One)</label>
    <select class="form-control custom-select" name="ReviewByOne" required>
            <option value="" disabled selected>Select Review By</option>
            @foreach (\App\Models\User::all() as $item)
            <option value="{{ $item->id }}" >{{ $item->name }}</option>
            @endforeach
        </select>
    </div>  -->
    <!-- <div class="col-4"> 
        <label class="form-label" >Review By (Two)</label>
        <select class="form-control custom-select" name="ReviewByTwo" required>
            <option value="" disabled selected>Select Review By</option>
            @foreach (\App\Models\User::all() as $item)
            <option value="{{ $item->id }}" >{{ $item->name }}</option>
            @endforeach
        </select>
        </div> -->
    <!-- <div class="col-4">
    <label class="form-label" >Approval By</label>
     <select class="form-control custom-select" name="ApprovalBy" required>
            <option value="" disabled selected>Select Approval By</option>
            @foreach (\App\Models\User::all() as $item)
            <option value="{{ $item->id }}" >{{ $item->name }}</option>
            @endforeach
        </select>
        </div> -->
    <div class="modal-footer">
        
        @if(isset($protocol->ProtocolStatusID) && $protocol->ProtocolStatusID == 4)
        <button data-toggle='modal' data-target='#dynamicApprovalModal'  class='btn btn-primary  dynamic-approval-modal-btn ajax-approval-modal-btn'>Save changes</button>
        @else
        <button type="submit" class="btn btn-primary">Save changes</button>
        @endif

       
    </div>
</div>

