<form method="POST" enctype="multipart/form-data"> 
    <div class="card-body">
        <div>
            <h3>Add Event</h3>
        </div>
        <hr/>
        <div class="form-group">
            <label>Division:</label>
            <select name="division_id" class="form-control select2" style="width: 100%;">
                <option></option>
            </select>
        </div>
        <div class="form-group">
            <label>Title:</label>
            <input name="title" type="text" class="form-control" placeholder="Enter title">
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Start Date:</label>
                    <div class="input-group date" id="startdate" data-target-input="nearest">
                        <input name="start_date" type="text" class="form-control datetimepicker-input" data-target="#startdate" />
                        <div class="input-group-append" data-target="#startdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>End Date:</label>
                    <div class="input-group date" id="enddate" data-target-input="nearest">
                        <input name="end_date" type="text" class="form-control datetimepicker-input" data-target="#enddate" />
                        <div class="input-group-append" data-target="#enddate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
                <label class="mr-4">
                    Public:
                </label>
                <input name="is_public" type="checkbox" id="checkboxPrimary2">
            </div>
        </div>
        <div class="form-group">
            <label>Picture: </label>
            <input name="image" type="file" class="ml-4"/>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Post</button>
    </div>
</form>