<form method="POST" enctype="multipart/form-data"> 
    <div class="card-body">
        <div >
            <h3>Add user</h3>
        </div>
        <hr/>
        <div class="form-group">
            <label>Username:</label>
            <input name="username" type="text" class="form-control" placeholder="Enter username">
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input name="password" type="text" class="form-control" placeholder="Enter password">
        </div>
        <div class="form-group">
            <label>Password (again):</label>
            <input name="password_confirmation" type="text" class="form-control" placeholder="Enter password">
        </div>
        <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
                <label class="mr-4">
                    Superuser:
                </label>
                <input name="is_superuser" type="checkbox" id="checkboxPrimary2">
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
                <label class="mr-4">
                    President:
                </label>
                <input name="is_president" type="checkbox" id="checkboxPrimary2">
            </div>
        </div>
        <div class="form-group">
            <label>Profile Picture: </label>
            <input name="profile_picture" type="file" class="ml-4"/>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>