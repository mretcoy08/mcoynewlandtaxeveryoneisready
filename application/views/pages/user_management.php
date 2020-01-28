<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                  
                        <h4 class="card-title "></h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                            <div class="col-md-3">
                                <div class="form-group" style="margin-top:10px;">
                                    <button type="button" class="btn btn-fill btn-primary "data-toggle="modal" data-target="#addUser" id = "add">
                                        <i class="fa fa-plus"></i>&nbsp;Add User</button>
                                </div>   
                            </div>

                        
                        <div class="row">
                          <div class = "col-md-12 col-xs-12">
                            <table id="posts" class="table table-bordered" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width = "20%">Username</th>
                                        <th width = "30%">Name</th>
                                        <th width = "20%">Contact Number</th>
                                        <th class="disabled-sorting text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width = "">Username</th>
                                        <th width = "">Name</th>
                                        <th width = "">Contact Number</th>
                                        <th class="disabled-sorting text-left">Actions</th>
                                    </tr>
                                </tfoot>
                                
                            </table>
                          </div>

                        </div>

                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
        </div>

    </div>
</div>


 <!-- The Modal -->      
<div class="modal fade" id="addUser">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      
      <div class="modal-header">
       
        <h4 class="modal-title text-primary" id= "h4user">Add User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      
      <div class="modal-body">
        <!-- Modal body -->
        <form id = "add_user">
      <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label class = "bmd-label-floating">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" required>
                </div>  
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class = "bmd-label-floating">Middle Name</label>
                    <input type="text" class="form-control" name="middle_name" id="middle_name" required>
                </div>  
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class = "bmd-label-floating">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" required>
                </div>  
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class = "bmd-label-floating">Suffix Name</label>
                    <input type="text" class="form-control" name="suffix_name" id="suffix_name">
                </div>  
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class = "bmd-label-floating">Contact Number</label>
                    <input type="text" class="form-control" name="contact_number" id="contact_number" required>
                </div>  
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class = "bmd-label-floating">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>  
            </div>

             <div class="col-md-6">
                <div class="form-group">
                    <label class = "bmd-label-floating">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>  
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class = "bmd-label-floating hide">Role</label>
                    <select id = "role" name = "role" class = "form-control" required>
                        <option value="">Please Select Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Employee">Employee</option>
                    </select>
                </div>  
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class = "bmd-label-floating"></label>
                     <input type="hidden" id = "ddd" name = "userid">
                </div>  
            </div>
           

        </div>
          
      </div>
        
         <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id = "addbtn">Add</button>
      </div>
        </form>
    </div>
  </div>
</div>





