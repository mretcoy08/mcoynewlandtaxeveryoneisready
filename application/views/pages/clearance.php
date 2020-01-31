
<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb rgba-blue-grey-light py-3 ">
			<li class="breadcrumb-item"><a href="<?php echo base_url() ?>/Dashboard"><i
						class="fas fa-tachometer-alt"></i> Dashboard</a></li>
			<li class="breadcrumb-item active" aria-current="page">Clearance</li>
		
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
                                <!-- <label class = "form-label"for="">Year</label>
                                   <select class = "form-control" id = "year">
                                       <option value = "">Please Select</option>
                                   </select> -->
                                </div>   
                            </div>
                            </div>
                        
                        <div class="row">
                          <div class = "col-md-12 col-xs-12">
                            <table id="posts" class="table table-bordered" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width = "25%">Owner's name</th>
                                        <th width = "25%">Pin</th>
                                        <th width = "25%">ARP</th>
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

<!-- <button id = "test" class = "btn btn-danger">TEST BUTTON</button> -->


<div class="modal fade" id="printclearance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header h-10 bg-info">
                            <h5 class="modal-title text-white" id="exampleModalLabel"></h5>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                           
                            
                            <iframe id="myframe" width='100%' height="450"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button onclick="printmodalshow()" type="button" class="btn btn-sm btn-primary">Print</button>
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

 <!-- The Modal -->      
<div class="modal fade" id="printData">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      
      <div class="modal-header bg-primary">
       
        <h4 class="modal-title text-white" id= "h4user">Print</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      
      <div class="modal-body">
        <!-- Modal body -->
        <form id = "print_data">
            <div class="container">
                <div class="row">
                    <div col-md-6>
                        <div class ="form-group">
                            <label for="purpose">Purpose:</label>
                            <select name="purpose" id="purpose" class = "form-control" required>
                                <option value="1">Cancellation/Registration of Mortgage Contract</option>
                                <option value="2">Transfer of Ownership</option>
                                <option value="3">Bank loan</option>
                                <option value="4">Business Permit</option>
                                <option value="5">Others: For whatever legal purpose</option>
                            </select>
                        </div>

                        <div col-md-12>
                        <div class ="form-group">
                            <label for="request">Request of:</label>
                            <input class = "form-control" type="text" id = "request" name = "request" required > 
                        </div>
                        </div>

                    <div col-md-12>
                        <div class ="form-group">
                            <label for="or_num">OR number:</label>
                            <input class = "form-control type="number" id = "or_num" name = "or_num" required > 
                        </div>
                    </div>

                    <input type="hidden" id ="tax_idd" name = "tax_idd">

                    </div>

                    

                    <input type="hidden" id = "pin" name = "pin">

                </div>

                </div>
                    

                <!-- </div>
        </div> -->
        <!-- Modal Body End -->
        
         <!-- Modal footer -->
      <div class="modal-footer">
      <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary" id = "printbtn"><i class = "fa fa-print"></i> Print</button>
  
      </div>
          </div>
        </form>
    </div>
  </div>
</div>










