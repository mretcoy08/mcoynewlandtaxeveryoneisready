<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb rgba-blue-grey-light py-3 ">
			<li class="breadcrumb-item"><a href="<?php echo base_url() ?>/Dashboard"><i
						class="fas fa-tachometer-alt"></i> Dashboard</a></li>
			<li class="breadcrumb-item active" aria-current="page">Building And Owner</li>
		
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
                            <div class="col-md-3">
                                <div class="form-group" style="margin-top:10px;">
                                    <button type="button" class="btn btn-fill btn-primary" id = "add">
                                        <i class="fa fa-plus"></i>&nbsp;  Add Building and Owner</button>
                                </div>   
                            </div>
                        
                        <div class="row">
                          <div class = "col-md-12 col-xs-12">
                            <table id="posts" class="table table-bordered" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width = "20%">Pin</th>
                                        <th width = "20%">ARP No.</th>
                                        <th width = "15%">Class</th>
                                        <th width = "15%">Assessed Value</th>
                                        <th width = "15%">Land Status</th>
                                        <th class="disabled-sorting text-left">Actions</th>
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


 <!-- The Modal -->      
<div class="modal fade" id="addBuildingAndOwner">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      
      <div class="modal-header">
        
        <h4 class="modal-title text-primary text-center" id= "h4user">Building and Owner Information</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      
      <div class="modal-body">
        <!-- Modal body -->
        <form id = "add_land_and_owner">
        <hr>
        <h5 class = "text-center text-primary">Building Information</h5>
        <hr>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="bmd-label-floating">Tax Declaration No.</label>
                    <input type="text" class ="form-control new_input"  name = "tax_dec_no" id = "tax_dec_no" required>
                </div>
            </div>

        <div class="col-md-4"></div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="" class="bmb-label-floating" style = "color:red;"><strong>Last Paid Year</strong></label>
                    <select name="last_year_paid" id="last_year_paid" class = "form-control" required>
                        <option  id = "lyp"value="">Please Select Year</option>
                       
                    </select>
                </div>
            </div>
        </div>

     

      <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class = "bmd-label-floating">Land Pin No.</label>
                    <input type="text" class="form-control" name="land_pin" id="land_pin">
                </div>  
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class = "bmd-label-floating">Building No.</label>
                    <input type="number" class="form-control new_input" name="building_no" id="building_no" required>
                </div>  
            </div>

        <div class="col-md-3"></div>   
        <div class="col-md-3">
                <div class="form-group">
                    <label for="" class="bmb-label-floating"  style = "color:red;">Assessed Value:</label>
                    <input type="text" class = "form-control new_input money2" name = "assessed_value" id = "assessed_value" required>
                </div>
            </div>
            
            
        </div>
        <hr>
        <h5 class = "text-center text-primary">Land Information</h5>
        <hr>
        <div class="row">
       
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Province</label>
                    <input type="text" class = "form-control" name = "province" id = "province" value = "Laguna" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">City</label>
                    <input type="text" class = "form-control" name = "city" id = "city" value = "San Pablo"readonly>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label class = bmb-label-floating>Lot No.</label>
                    <input type="text" class = "form-control new_input" name = "lot_no" id = "lot_no" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class = bmb-label-floating>Block No.</label>
                    <input type="text" class = "form-control new_input" name = "block_no" id = "block_no" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class = bmb-label-floating>Street</label>
                    <input type="text" class = "form-control new_input" name = "street" id = "street" readonly>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Barangay</label>
                    <input type="text" class = "form-control new_input" name = "barangay" id = "barangay" readonly>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Subdivision</label>
                    <input type = "text" name="subdivision" id="subdivision" class = "form-control new_input" readonly>
                   
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Class</label>
                    <input type = "text" name="class" id="class" class = "form-control new_input" readonly>
                     
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Sub class</label>
                    <input type="text" class = "form-control new_input" name = "sub_class" id = "sub_class" readonly>
                </div>
            </div>

            

            <div class="col-md-2">
                
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Land Status</label>
                    <input type = "text" name="land_status" id="land_status" class = "form-control new_input" readonly>
                      
                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Assessed Value:</label>
                    <input type="text" class = "form-control new_input money2" name = "assessed_value" id = "assessed_value" readonly>
                </div>
            </div>

            
        </div>

        <hr>
        <h5 class = "text-center text-primary">Building Owner Information</h5>
        <hr>

        <div class="row">
            <div class="col-md-3">
                    <label for="" class="bmb-label-floating"><strong>First Name:</strong></label>
                    <input type="text" class = "form-control new_input" id = "first_name" class = "first_name">
                    <label for="" class="bmb-label-floating"><strong>Middle Name:</strong></label>
                    <input type="text" class = "form-control new_input" id = "middle_name" class = "middle_name">
                    <label for="" class="bmb-label-floating"><strong>Last Name:</strong></label>
                    <input type="text" class = "form-control new_input" id = "last_name" class = "last_name">
                    <button type="button" class="btn btn-primary float-right" id = "additional_owner">Add Owner</button>
                
            </div>
            <div class="col-md-9">
                <table class = "table table-striped table-hover table-bordered" id = "tableOwner">
                    <thead>
                        <tr>
                            <td><strong>First name</strong></td>
                            <td><strong>Middle name</strong></td>
                            <td><strong>Last name</strong></td> 
                            <td><strong>Action</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

       

        


          
      </div>
        
         <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id = "addbtn">Submit</button>
      </div>
        </form>
    </div>
  </div>
</div>




<div class="modal fade" id="updateLand">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      
      <div class="modal-header bg-primary">
       
        <h4 class="modal-title text-white text-center" id= "h4user">Update Land Information</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      
      <div class="modal-body">
        <!-- Modal body -->
        <form id = "update_land">
        <hr>
        <h4 class = "text-center text-primary"><strong>Land Information</h4>
        <hr>
        <strong><label for="">Pin No.</label></strong>
      <div class="row">
            <div class="col-md-1">
                <div class="form-group">
                    <label class = "bmd-label-floating">City</label>
                    <input type="number" class="form-control" name="pin_city" id="uppin_city" value = "130" readonly>
                </div>  
            </div>

            <div class="col-md-1">
                <div class="form-group">
                    <label class = "bmd-label-floating">District</label>
                    <input type="number" class="form-control new_input" name="pin_district" id="uppin_district" readonly>
                </div>  
            </div>

            <div class="col-md-1">
                <div class="form-group">
                    <label class = "bmd-label-floating"> Barangay</label>
                    <input type="number" class="form-control new_input" name="pin_barangay" id="uppin_barangay" required>
                </div>  
            </div>

            <div class="col-md-1">
                <div class="form-group">
                    <label class = "bmd-label-floating">Section</label>
                    <input type="number" class="form-control new_input" name="pin_section" id="uppin_section" required>
                </div>  
            </div>

            <div class="col-md-1">
                <div class="form-group">
                    <label class = "bmd-label-floating">Parcel</label>
                    <input type="number" class="form-control new_input" name="pin_parcel" id="uppin_parcel" required>
                </div>  
            </div>

            <div class="col-md-3"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="bmd-label-floating">Tax Declaration No.</label>
                    <input type="text" class ="form-control new_input"  name = "tax_dec_no" id = "uptax_dec_no" required>
                </div>
            </div>
            
        </div>

        <div class="row">
       

            <div class="col-md-2">
                <div class="form-group">
                    <label class = bmb-label-floating>Lot No.</label>
                    <input type="text" class = "form-control new_input" name = "lot_no" id = "uplot_no">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class = bmb-label-floating>Block No.</label>
                    <input type="text" class = "form-control new_input" name = "block_no" id = "upblock_no">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class = bmb-label-floating>Street</label>
                    <input type="text" class = "form-control new_input" name = "street" id = "upstreet">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Barangay</label>
                    <input type="text" class = "form-control new_input" name = "barangay" id = "upbarangay" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">City</label>
                    <input type="text" class = "form-control" name = "city" id = "upcity" value = "San Pablo"readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Subdivision</label>
                    <select name="subdivision" id="upsubdivision" class = "form-control new_input">
                    <option value="">Select Subdivision</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Province</label>
                    <input type="text" class = "form-control" name = "province" id = "upprovince" value = "Laguna" readonly>
                </div>
            </div>

           

            <div class="col-md-2">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Sub class</label>
                    <input type="text" class = "form-control new_input" name = "sub_class" id = "upsub_class" readonly>
                </div>
            </div>
           

            <div class="col-md-2">
               
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Land Status</label>
                    <select name="land_status" id="upland_status" class = "form-control new_input" required>
                        <option value="">Please Select Status</option>
                        <option value="TAXABLE">TAXABLE</option>
                        <option value="EXEMPTED">EXEMPTED</option>
                    </select>
                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group">
                    <label for="" class="bmb-label-floating">Assessed Value:</label>
                    <input type="number" class = "form-control new_input money" name = "assessed_value" id = "upassessed_value" required>
                </div>
            </div>

            <input type="hidden" id = "idd" name = "idd">

            
        </div>

        <!-- <hr>
        <h5 class = "text-center text-primary">Owner Information</h5>
        <hr>

        <div class="row">
            <div class="col-md-3">
                    <label for="" class="bmb-label-floating"><strong>First Name:</strong></label>
                    <input type="text" class = "form-control new_input" id = "first_name" class = "first_name">
                    <label for="" class="bmb-label-floating"><strong>Middle Name:</strong></label>
                    <input type="text" class = "form-control new_input" id = "middle_name" class = "middle_name">
                    <label for="" class="bmb-label-floating"><strong>Last Name:</strong></label>
                    <input type="text" class = "form-control new_input" id = "last_name" class = "last_name">
                    <button type="button" class="btn btn-primary float-right" id = "additional_owner">Add Owner</button>
                
            </div>
            <div class="col-md-9">
                <table class = "table table-striped table-hover table-bordered" id = "tableOwner">
                    <thead>
                        <tr>
                            <td><strong>First name</strong></td>
                            <td><strong>Middle name</strong></td>
                            <td><strong>Last name</strong></td> 
                            <td><strong>Action</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        -->

        


          
      </div>
        
         <!-- Modal footer -->
         <div class="modal-footer">
         <div class="col-12 text-center">
 
        <button type="submit" class="btn btn-primary" id = "addbtn">Submit</button>
  
      </div>
      </div>
        </form>
    </div>
  </div>
</div>


<div class="modal fade" id="updateOwner">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      
      <div class="modal-header bg-primary">
       
        <h4 class="modal-title text-white text-center" id= "h4user">Update Owner Information</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      
      <div class="modal-body">
        <!-- Modal body -->
        <form id = "update_owner">
       
       
    <hr>
    <h4 class = "text-center text-primary"><strong>Owner Information</h4>
    <hr>
      <div class="row">
           
            <div class="col-md-3">
                    <label for="" class="bmb-label-floating"><strong>First Name:</strong></label>
                    <input type="text" class = "form-control new_input" id = "first_name" class = "first_name">
                    <label for="" class="bmb-label-floating"><strong>Middle Name:</strong></label>
                    <input type="text" class = "form-control new_input" id = "middle_name" class = "middle_name">
                    <label for="" class="bmb-label-floating"><strong>Last Name:</strong></label>
                    <input type="text" class = "form-control new_input" id = "last_name" class = "last_name">
                    <div class="col-12 text-center">
                    <button type="button" class="btn btn-primary" id = "upadditional_owner">Add Owner</button>
                    </div>
            </div>
            <div class="col-md-9">
                <table class = "table table-striped table-hover table-bordered" id = "uptableOwner">
                    <thead>
                        <tr>
                            <td><strong>First name</strong></td>
                            <td><strong>Middle name</strong></td>
                            <td><strong>Last name</strong></td> 
                            <td><strong>Action</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        

       
            
    

          
      </div>
        
         <!-- Modal footer -->
      <div class="modal-footer">
      <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary" id = "addbtn">Submit</button>
      </div>
        
      </div>
        </form>
    </div>
  </div>
</div>





