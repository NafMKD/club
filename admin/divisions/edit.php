<form method="POST"> 
    <div class="card-body">
        <div>
            <h3>Edit Division</h3>
        </div>
        <hr/>
        <div class="form-group">
            <label>Head:</label>
            <select name="division_head_id" class="form-control select2" style="width: 100%;">
                <option></option>
            </select>
        </div>
        <div class="form-group">
            <label>Name:</label>
            <input name="title" type="text" class="form-control" placeholder="Enter title">
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>