    <div class="row">
        <div class="col mb-3">
            <label for="ConditionName" class="form-label">Condition Name</label> <span style="color: red">*</span>
            <input type="text" name="ConditionName" id="ConditionName" class="form-control" placeholder="Enter condition" required value="{{ isset($condition) ? $condition->ConditionName : '' }}">
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save changes</button>
