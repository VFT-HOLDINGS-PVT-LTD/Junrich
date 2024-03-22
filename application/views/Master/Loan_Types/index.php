<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">

    <title><?php echo $title ?></title>

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
                                <li class="active"><a href="index.html">LOAN TYPES</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab1">LOAN TYPES</a></li>
                                    <li><a data-toggle="tab" href="#tab2">VIEW LOAN TYPES</a></li>

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
                                                            <div class="panel-heading"><h2>ADD LOAN TYPE</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_loan_types" name="frm_loan_types" action="<?php echo base_url(); ?>Master/Loan_Types/insert_Data" method="POST" enctype="multipart/form-data">
                                                                    
                                                                     <!--success Message-->
                                                                    <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') { ?>
                                                                        <div id="spnmessage" class="alert alert-dismissable alert-success success_redirect">
                                                                            <strong>Success !</strong> <?php echo $_SESSION['success_message'] ?>
                                                                        </div>
                                                                    <?php } ?>

                                                                    <!--Error Message-->
                                                                    <?php if (isset($_SESSION['error_message']) && $_SESSION['error_message'] != '') { ?>
                                                                        <div id="spnmessage" class="alert alert-dismissable alert-danger error_redirect">
                                                                            <strong>Error !</strong> <?php echo $_SESSION['error_message'] ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                    
                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img style="margin-left: 30%; width: 100px; height: 100px;" src="<?php echo base_url(); ?>assets/images/loan_types.png" >
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="focusedinput" class="col-sm-4 control-label">Loan Type Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="txt_loan_type" name="txt_loan_type" placeholder="Ex: Home">
                                                                        </div>

                                                                    </div>





                                                                    <!--submit button-->
                                                                    <?php $this->load->view('template/btn_submit.php'); ?>
                                                                    <!--end submit-->

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
                                    <!-- Grid View -->
                                    <div class="tab-pane" id="tab2">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel panel-primary">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h2>LOAN TYPE DETAILS</h2>
                                                                <div class="panel-ctrls">
                                                                </div>
                                                            </div>
                                                            <div class="panel-body panel-no-padding">
                                                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>HOLIDAY</th>
                                                                            
                                                                            

                                                                            <th>EDIT</th>
                                                                            <th>DELETE</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data_set as $data) {


                                                                            echo "<tr class='odd gradeX'>";


                                                                            echo "<td width='100'>" . $data->Loan_ID . "</td>";
                                                                            echo "<td width='100'>" . $data->loan_name . "</td>";
                                                                            
                                                                            

                                                                            echo "<td width='15'>";
                                                                            echo "<button class='get_data btn btn-green'  data-toggle='modal' data-target='#myModal' title='EDIT' data-id='$data->Loan_ID' href='" . base_url() . "index.php/Master/Department/get_details" . $data->Loan_ID . "'><i class='fa fa-edit'></i></button>";
                                                                            echo "</td>";

                                                                            echo "<td width='15'>";


                                                                            echo "<button  class=' btn btn-danger' data-toggle='modal' href='javascript:void()' title='DELETE' onclick='delete_id($data->Loan_ID)'><i class='fa fa-times-circle'></i></a>";


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

                                </div>

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
            <script src="<?php echo base_url(); ?>system_js/Master/Loan_types.js"></script>
            
            
             <!--JQuary Validation-->
                <script type="text/javascript">
                    $(document).ready(function () {
                        $("#frm_loan_types").validate();
                        $("#spnmessage").hide("shake", {times: 6}, 3500);
                    });
                </script>

    </body>


</html>