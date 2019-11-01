

<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Userweb Power</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Userweb Power</li>
            </ol>
        </div>
        
    </div>
    
    <!-- End Bread crumb and right sidebar toggle -->
    

    
    <!-- Start Page Content -->

    <div class="row">

        <div class="col-md-12">
            <?php $msg = $this->session->flashdata('msg'); ?>
            <?php if (isset($msg)): ?>
                <div class="alert alert-success delete_msg pull" style="width: 100%"> <i class="fa fa-check-circle"></i> <?php echo $msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">x</span> </button>
                </div>
            <?php endif ?>

            <?php $error_msg = $this->session->flashdata('error_msg'); ?>
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger delete_msg pull" style="width: 100%"> <i class="fa fa-times"></i> <?php echo $error_msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">x</span> </button>
                </div>
            <?php endif ?>
        </div>

        <div class="col-lg-5">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"> Add New Power
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/userweb/add_power') ?>" class="form-horizontal" novalidate>
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-5">Power Name <span class="text-danger">*</span></label>
                                        <div class="col-md-7 controls">
                                            <input type="text" name="name" class="form-control" required data-validation-required-message="Power Name is required">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-5">Power Id <span class="text-danger">*</span></label>
                                        <div class="col-md-7 controls">
                                           <div class="form-group">
                                                <input  class="vertical-spin" type="text" name="power_id" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" value="" name="vertical-spin" required data-validation-required-message="Power Id is required"> </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            

                            <!-- CSRF token -->
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />

                            
                            <hr>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-5"></label>
                                        <div class="controls">
                                            <button type="submit" class="btn btn-success">Add Power</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>


        <div class="col-lg-7">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"> All Power List</h4>
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive m-t-40">
                        <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Power Id</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($powers as $row): ?>
                                
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['power_id']; ?></td>
                                    
                                    <td class="text-nowrap">
                                    
                                        <a data-toggle="modal" data-target="#editModal_<?php echo $row['id'];?>" href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-success m-r-10"></i> </a>

                                        <a id="delete" href="<?php echo base_url('admin/userweb/delete_power/'.$row['id']) ?>"  data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash text-danger m-r-10"></i> </a>
                                        
                                    </td>
                                </tr>

                            <?php endforeach ?>

                            </tbody>


                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- End Page Content -->

</div>



<!-- Start Edit User Power Modal  -->
<?php foreach ($powers as $row): ?>  

<div class="modal fade" id="editModal_<?php echo $row['id'];?>">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update User Power</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        
        <form method="post" action="<?php echo base_url('admin/userweb/update_power') ?>" class="form-horizontal" novalidate>
            <div class="form-body">
                <br>
                
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label class="control-label text-right col-md-5">Power Name <span class="text-danger"></span></label>
                            <div class="col-md-7 controls">
                                <input type="text" name="name" value="<?php echo $row['name']; ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                </div>

                <!-- CSRF token -->
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label class="control-label text-right col-md-5"></label>
                            <div class="controls">
                                <button type="submit" class="btn btn-success">Update Power</button>
                            </div>
                        </div>
                    </div>
                </div>

               
            </div>
            
        </form>
                

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<?php endforeach ?>

<!-- End Edit User Power Modal  -->
