


<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb rgba-blue-grey-light py-3 ">
			<li class="breadcrumb-item"><a href="<?php echo base_url() ?>/Dashboard"><i
						class="fas fa-tachometer-alt"></i> Dashboard</a></li>
			<li class="breadcrumb-item active" aria-current="page">Audit Trail</li>
		
		</ol>
	</nav>
</div>


<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                  
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-top:10px;">
                                        <select name="user" id="user" class = "form-control sort">
                                            <option value="">Select a user</option>
                                        </select>
                                    </div>   
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-top:10px;">
                                        <select name="action" id="action" class = "form-control sort">
                                            <option value="">Select a action</option>
                                        </select>
                                    </div>   
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-top:10px;">
                                        <select name="module" id="module" class = "form-control sort">
                                            <option value="">Select a module</option>
                                        </select>
                                    </div>   
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-top:10px;">
                                        <input type="date" class = "form-control sort" name = "date" id = "date">
                                    </div>   
                                </div>
                            </div>

                        
                        <div class="row">
                          <div class = "col-md-12 col-xs-12">
                            <table id="posts" class="table table-bordered" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width = "20%">User</th>
                                        <th width = "20%">Action</th>
                                        <th width = "20%">What</th>
                                        <th width = "20%">Module</th>
                                        <th class="disabled-sorting text-left" width = "20%">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                               
                                
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


 




