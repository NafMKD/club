<form method="POST" enctype="multipart/form-data"> 
    <div class="card-body">
        <div>
            <h3>Add Feed</h3>
        </div>
        <hr/>
        <div class="form-group">
            <label>Event:</label>
            <select name="event_id" class="form-control select2" style="width: 100%;">
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
        <div class="form-group">
            <label>Pictures: </label>
            <input name="image[]" multiple type="file" class="ml-4"/>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Post</button>
    </div>
</form>