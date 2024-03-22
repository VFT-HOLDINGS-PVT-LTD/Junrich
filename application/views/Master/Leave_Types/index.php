<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">


    <head>
        <!-- Styles -->
        <?php $this->load->view('template/css.php'); ?>

    </head>

    <body class="infobar-offcanvas">

        <!--header-->

        <?php $this->load->view('template/header.php'); ?>

        <!--end header-->

        <div id="wrapper">
            <div id="layout-static">

                <!--dashboard side-->

                <?php $this->load->view('template/dashboard_side.php'); ?>

                <!--dashboard side end-->

                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">

                                <li class=""><a href="index.html">HOME</a></li>
                                <li class="active"><a href="index.html">LEAVE TYPES</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">LEAVE TYPES</a></li>
                                    <li><a data-toggle="tab" href="#tab2">VIEW LEAVE TYPES</a></li>


                                </ul>
                            </div>
                            <div class="container-fluid">


                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">

                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading"><h2>ADD LEAVE TYPES</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_leave_type" name="frm_leave_type" action="<?php echo base_url(); ?>Master/Leave_Types/insert_Data" method="POST">

                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/leave_add.png" >
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Leave Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" name="txt_L_Name" id="txt_L_Name" placeholder="Ex: Anual Leave">
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Leave Entitle</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="number" class="form-control" name="txt_L_Entitle" id="txt_L_Entitle" placeholder="Ex: 14">
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Leave Balance Forward</label>
                                                                        <div class="col-sm-8 icheck-flat">
                                                                            <label class="checkbox green icheck col-sm-5">
                                                                                <input type="checkbox" name="chk_BF" id="chk_BF" >
                                                                            </label>
                                                                        </div>

                                                                    </div>


                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-sm-8 col-sm-offset-2">
                                                                            <button type="submit" id="submit"  class="btn-primary btn fa fa-check">&nbsp;&nbsp;Submit</button>
                                                                            <button type="button" id="Cancel" name="Cancel" class="btn btn-danger-alt fa fa-times-circle">&nbsp;&nbsp;Cancel</button>
                                                                        </div>
                                                                    </div>
                                                                </form>

                                                                <hr>
                                                                <div id="divmessage" class="">

                                                                    <div id="spnmessage"> </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                    <!--***************************-->
                                    <!-- Grid View -->
                                    <div class="tab-pane" id="tab2">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel panel-primary">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h2>DESIGNATION DETAILS</h2>
                                                                <div class="panel-ctrls">
                                                                </div>
                                                            </div>
                                                            <div class="panel-body panel-no-padding">
                                                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>LEAVE</th>
                                                                            <th>ENTITLE</th>
                                                                            <th>LEAVE BF</th>
                                                                            <th>IS ACTIVE</th>
                                                                            <th>EDIT</th>
                                                                            <th>DELETE</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data_set as $data) {


                                                                            echo "<tr class='odd gradeX'>";


                                                                            echo "<td width='100'>" . $data->Lv_T_ID . "</td>";
                                                                            echo "<td width='100'>" . $data->leave_name . "</td>";
                                                                            echo "<td width='100'>" . $data->leave_entitle . "</td>";
                                                                            echo "<td width='100'>" . $data->leave_BF . "</td>";
                                                                            echo "<td width='100'>" . $data->IsActive . "</td>";

                                                                            echo "<td width='15'>";
                                                                            echo "<button class='get_data btn btn-green'  data-toggle='modal' data-target='#myModal' title='EDIT' data-id='$data->Lv_T_ID' href='" . base_url() . "index.php/Master/Department/get_details" . $data->Lv_T_ID . "'><i class='fa fa-edit'></i></button>";
                                                                            echo "</td>";

                                                                            echo "<td width='15'>";

                                                                            echo "<button  class=' btn btn-danger' data-toggle='modal' href='javascript:void()' title='DELETE' onclick='delete_id($data->Lv_T_ID)'><i class='fa fa-times-circle'></i></a>";

                                                                            echo "</td>";

                                                                            echo "</tr>";
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                                <div class="panel-footer"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- End Grid View-->

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h2 class="modal-title">LEAVE TYPE</h2>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" action="<?php echo base_url(); ?>Master/Leave_Types/edit" method="post">
                                                        <div class="form-group col-sm-12">
                                                            <label for="focusedinput" class="col-sm-4 control-label">ID</label>
                                                            <div class="col-sm-8">
                                                                <input value="<?php echo $data->Lv_T_ID; ?>" type="text" class="form-control" readonly="readonly" name="id" id="id" class="m-wrap span3" >
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-sm-12">
                                                            <label for="focusedinput" class="col-sm-4 control-label">LEAVE NAME</label>
                                                            <div class="col-sm-8">
                                                                <input value="<?php echo $data->leave_name; ?>" type="text" name="L_Name" id="L_Name"  class="form-control m-wrap span6"><br>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-sm-12">
                                                            <label for="focusedinput" class="col-sm-4 control-label">LEAVE ENTITLE</label>
                                                            <div class="col-sm-8">
                                                                <input value="<?php echo $data->leave_entitle; ?>" type="text" name="L_Ent" id="L_Ent"  class="form-control m-wrap span6"><br>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-sm-12">

                                                            <label for="focusedinput" class="col-sm-4 icheck checkbox green control-label">LEAVE BF</label>
                                                            <div class="col-sm-8"><?php
                                                                $BF = $data->leave_BF;

                                                                var_dump($BF);

                                                                if ($BF == '1') {
                                                                    $BF1 = 'checked';
                                                                } elseif ($BF == 0) {
                                                                    $BF1 = '';
                                                                }
                                                                ?>
                                                                <input type="checkbox" value=""  id="L_BF" name="L_BF" <?php echo $BF1; ?>
                                                            </div>


                                                        </div>
                                                </div>
                                                <div class="form-group col-sm-12">

                                                    <label for="focusedinput" class="col-sm-4 icheck checkbox green control-label">IS ACTIVE</label>
                                                    <div class="col-sm-8">

                                                        <?php
                                                        $Active = $data->IsActive;

                                                        var_dump($Active);

                                                        if ($Active == '1') {
                                                            $Active_a = 'checked';
                                                        } elseif ($Active == 0) {
                                                            $Active_a = '';
                                                        }
                                                        ?>


                                                        <input type="checkbox"  value="" id="is_active" name="is_active" 
                                                    </div>


                                                    <!--                                                        <label class="checkbox green icheck col-sm-4">
                                                                                                                    <input type="checkbox" value="<?php echo $data->IsActive; ?>" id="is_active" name="is_active" 
                                                    
                                                                                                                </label>-->
                                                </div>


                                            </div>

                                            <br>
                                            <!--<input class="btn green" type="submit" value="submit" id="submit">-->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                            </form>
                                        </div>

                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->




                            </div> <!-- .container-fluid -->
                        </div>
                        <!--Footer-->
<?php $this->load->view('template/footer.php'); ?>	
                        <!--End Footer-->
                    </div>
                </div>
            </div>





            <!-- Load site level scripts -->

<?php $this->load->view('template/js.php'); ?>							<!-- Initialize scripts for this page-->

            <!-- End loading page level scripts-->

            <!--Ajax-->
            <script src="<?php echo base_url(); ?>system_js/Master/L_Types.js"></script>

    </body>


</html>