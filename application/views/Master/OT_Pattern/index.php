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
                                <li class="active"><a href="index.html">OT PATTERN</a></li>

                            </ol>


                            <div class="page-tabs">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab1">OT PATTERN</a></li>
                                    <li><a data-toggle="tab" href="#tab2">OT PATTERN</a></li>
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
                                                            <div class="panel-heading"><h2>ADD OT PATTERN</h2></div>
                                                            <div class="panel-body">
                                                                <form class="form-horizontal" id="frm_OT_Pattern" name="frm_OT_Pattern" action="<?php echo base_url(); ?>Master/OT_Pattern/insert_Data" method="POST" onsubmit="createOTPatternArr()">

                                                                    <div class="form-group col-sm-12">
                                                                        <div class="col-sm-8">
                                                                            <img class="imagecss" src="<?php echo base_url(); ?>assets/images/OT.png" >
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <div class="form-group col-sm-6">
                                                                            <label for="focusedinput" class="col-sm-4 control-label">OT Pattern Name</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="txt_shift_name" name="txt_shift_name" placeholder="Ex: Office">
                                                                            </div>
                                                                        </div>

                                                                    </div>



                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold"></label>

                                                                            <div class="col-sm-1">
                                                                                <label for="#" class="col-sm-2 control-label" style="font-weight: bold">DAY</label>

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <label for="#" class="col-sm-2 control-label" style="font-weight: bold">DU/EX</label>

                                                                            </div>

                                                                            <div class="col-sm-1">
                                                                                <label for="#" class="col-sm-2 control-label" style="font-weight: bold">BEFORE_ SHIFT</label>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <label for="#" class="col-sm-2 control-label" style="font-weight: bold">MIN_TIME_TO_WORK</label>
                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <label for="#" class="col-sm-2 control-label" style="font-weight: bold">AFTER_SHIFT</label>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <label for="#" class="col-sm-2 control-label" style="font-weight: bold">MIN_TIME_TO_WORK</label>
                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <label for="#" class="col-sm-2 control-label" style="font-weight: bold">ROUNDUP</label>
                                                                            </div>



                                                                        </div>


                                                                    </div>  



                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">MONDAY</label>

                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Day0" id="Day0"  value="MON" readonly=""  placeholder="">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Type0"  id="Type0" value="DU"  readonly="" placeholder="">

                                                                            </div>

                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkBSH0" id="chkBSH0" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" name="MinTw0" id="MinTw0"  placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkASH0" id="chkASH0" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="ASH_MinTw0" name="ASH_MinTw0" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="RoundUp0" name="RoundUp0" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            
                                                                        </div>


                                                                    </div>

                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">TUESDAY</label>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Day1" id="Day1"  value="TUE" readonly=""  placeholder="">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Type1"  id="Type1" value="DU"  readonly="" placeholder="">

                                                                            </div>

                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkBSH1" id="chkBSH1" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" name="MinTw1" id="MinTw1"  placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkASH1" id="chkASH1" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="ASH_MinTw1" name="ASH_MinTw1" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="RoundUp1" name="RoundUp1" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            
                                                                        </div>


                                                                    </div>


                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">WEDNESDAY</label>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Day2" id="Day2"  value="WED" readonly=""  placeholder="">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Type2"  id="Type2" value="DU"  readonly="" placeholder="">

                                                                            </div>

                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkBSH2" id="chkBSH2" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" name="MinTw2" id="MinTw2"  placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkASH2" id="chkASH2" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="ASH_MinTw2" name="ASH_MinTw2" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="RoundUp2" name="RoundUp2" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            
                                                                            
                                                                        </div>


                                                                    </div>


                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">THURSDAY</label>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Day3" id="Day3"  value="THU" readonly=""  placeholder="">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Type3"  id="Type3" value="DU"  readonly="" placeholder="">

                                                                            </div>

                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkBSH3" id="chkBSH3" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" name="MinTw3" id="MinTw3"  placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkASH3" id="chkASH3" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="ASH_MinTw3" name="ASH_MinTw3" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="RoundUp3" name="RoundUp3" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            
                                                                        </div>


                                                                    </div>


                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">FRIDAY</label>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Day4" id="Day4"  value="FRI" readonly=""  placeholder="">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Type4"  id="Type4" value="DU"  readonly="" placeholder="">

                                                                            </div>

                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkBSH4" id="chkBSH4" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" name="MinTw4" id="MinTw4"  placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkASH4" id="chkASH4" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="ASH_MinTw4" name="ASH_MinTw4" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="RoundUp4" name="RoundUp4" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            
                                                                        </div>


                                                                    </div>


                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">SATURDAY</label>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Day5" id="Day5"  value="SAT" readonly=""  placeholder="">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Type5"  id="Type5" value="DU"  readonly="" placeholder="">

                                                                            </div>

                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkBSH5" id="chkBSH5" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" name="MinTw5" id="MinTw5"  placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkASH5" id="chkASH5" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="ASH_MinTw5" name="ASH_MinTw5" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="RoundUp5" name="RoundUp5" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            
                                                                        </div>


                                                                    </div>


                                                                    <div class="form-group col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="#" class="col-sm-2 control-label" style="font-weight: bold">SUNDAY</label>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Day6" id="Day6"  value="SUN" readonly=""  placeholder="">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" class="form-control" name="Type6"  id="Type6" value="DU"  readonly="" placeholder="">

                                                                            </div>

                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkBSH6" id="chkBSH6" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" name="MinTw6" id="MinTw6"  placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <label class="checkbox green icheck col-sm-5">
                                                                                    <input type="checkbox" name="chkASH6" id="chkASH6" >
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="ASH_MinTw6" name="ASH_MinTw6" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            <div class="col-sm-2">
                                                                                <input type="text" class="form-control" id="RoundUp6" name="RoundUp6" placeholder="Ex: 15(should in minutes)">

                                                                            </div>
                                                                            
                                                                            
                                                                            
                                                                        </div>


                                                                    </div>




                                                                    <!--Hidden Text-->
                                                                    <input type="text" name="hdntext" id="hdntext" class="">



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


                                    <!--***************************-->
                                    <!-- Grid View -->

                                    <div class="tab-pane" id="tab2">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel panel-primary">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h2>USER LEVEL DETAILS</h2>
                                                                <div class="panel-ctrls">
                                                                </div>
                                                            </div>
                                                            <div class="panel-body panel-no-padding">
                                                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>SHIFT CODE</th>
                                                                            <th>NAME</th>
                                                                            <th>FROM TIME</th>
                                                                            <th>TO TIME</th>
                                                                            <th>DAY TYPE</th>
                                                                            <th>SHIFT GAP</th>


                                                                            <th>EDIT</th>
                                                                            <th>DELETE</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($data_set as $data) {


                                                                            echo "<tr class='odd gradeX'>";


                                                                            echo "<td width='100'>" . $data->ShiftCode . "</td>";
                                                                            echo "<td width='100'>" . $data->ShiftName . "</td>";
                                                                            echo "<td width='100'>" . $data->FromTime . "</td>";
                                                                            echo "<td width='100'>" . $data->ToTime . "</td>";
                                                                            echo "<td width='100'>" . $data->DayType . "</td>";
                                                                            echo "<td width='100'>" . $data->ShiftGap . "</td>";


                                                                            echo "<td width='15'>";
                                                                            echo "<button class='get_data btn btn-green'  data-toggle='modal' data-target='#myModal' title='EDIT' data-id='$data->ShiftCode' href='" . base_url() . "index.php/Master/Department/get_details" . $data->ShiftCode . "'><i class='fa fa-edit'></i></button>";
                                                                            echo "</td>";

                                                                            echo "<td width='15'>";

                                                                            echo "<button  class='action_comp btn btn-danger' data-toggle='modal' href='javascript:void()' title='DELETE' onclick='delete_id($data->ShiftCode)'><i class='fa fa-times-circle'></i></a>";


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


                                    <!-- End Grid View -->
                                    <!--***************************-->

                                </div>


                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h2 class="modal-title">SHIFTS</h2>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url(); ?>Master/Shifts/edit" method="post">
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">SHIFT CODE</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->ShiftCode; ?>" type="text" class="form-control" readonly="readonly" name="ShiftCode" id="ShiftCode" class="m-wrap span3" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">NAME</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->ShiftName; ?>" type="text" name="ShiftName" id="ShiftName"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">FROM TIME</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->FromTime; ?>" type="time" name="FromTime" id="FromTime"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">TO TIME</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->ToTime; ?>" type="time" name="ToTime" id="ToTime"  class="form-control m-wrap span6"><br>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <label for="focusedinput" class="col-sm-4 control-label">SHIFT GAP</label>
                                                        <div class="col-sm-8">
                                                            <input value="<?php echo $data->ShiftGap; ?>" type="text" name="ShiftGap" id="ShiftGap"  class="form-control m-wrap span6"><br>
                                                        </div>
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
            <script src="<?php echo base_url(); ?>system_js/Master/OT_Pattern.js"></script>

    </body>


</html>