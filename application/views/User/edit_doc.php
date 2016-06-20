<?php
$attribute = array('id' => 'valid');
echo form_open('User/update_doc?id=' . $rows->DoctorId, $attribute);
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="form-group">
            Doctor Name
            <input type="hidden" class="form-control" value="<?php echo $rows->DoctorId ?>" name="DoctorId"  />
            <input type="text" class="form-control" value="<?php echo $rows->Doctor_Name ?>" name="Doctor_Name" placeholder="Doctor Name" />
        </div>
        <div class="form-group">
            MSL Code
            <input type="text" class="form-control" value="<?php echo $rows->MSL_Code; ?>" name="MSL_Code" placeholder="MSL Code" /> </div>
        <div class="form-group">
            Clinic Address
            <input type="text" class="form-control" value="<?php echo $rows->address; ?>" name="address" placeholder="Clinic Address"/> </div>
        <div class="form-group">
            Mobile Number
            <input type="text" class="form-control" value="<?php echo $rows->Mobile_Number; ?>" name="Mobile_Number" placeholder="Mobile "/> </div>
        <div class="form-group">
            Email
            <input type="text" class="form-control" value="<?php echo $rows->email; ?>" name="email" placeholder="Email"/> </div>
        <div class="form-group">
            Degree
            <input type="text" value="<?php echo $rows->Degree; ?>" class="form-control" name="Degree" placeholder="Degree" >
        </div>	    
        <div class="form-group">
            Passout College
            <input type="text"  class="form-control" value="<?php echo $rows->Passoutcollege; ?>" name="Passoutcollege " placeholder=" Passout College" >

        </div>	
        <div class="form-group">
            Region
            <input type="text"  value="<?php echo $rows->Region; ?>" class="form-control" name="Region" placeholder="Region" >

        </div>	
        <div class="form-group">
            State
            <input type="text" value="<?php echo $rows->State; ?>" class="form-control" name="State" placeholder="State" >
        </div>	

        <div class="form-group">
            Years Of Practice
            <select  class="form-control" name="Years_Practice" >
                <option value="">Select Years Of Practice</option>

                <option value="0" <?php
                if ($rows->Years_Practice == '0') {
                    echo 'selected';
                }
                ?>>0</option>
                <option value="1" <?php
                if ($rows->Years_Practice == '1') {
                    echo 'selected';
                }
                ?>>1</option>
                <option value="2" <?php
                if ($rows->Years_Practice == '2') {
                    echo 'selected';
                }
                ?>>2</option>
                <option value="3" <?php
                if ($rows->Years_Practice == '3') {
                    echo 'selected';
                }
                ?>>3</option>
                <option value="4" <?php
                if ($rows->Years_Practice == '4') {
                    echo 'selected';
                }
                ?>>4</option>
                <option value="5" <?php
                if ($rows->Years_Practice == '5') {
                    echo 'selected';
                }
                ?>>5</option>
            </select>
        </div>


        <div class="form-group">
            Date Of Birth
            <input type="text" class="form-control" value="<?php echo $rows->DOB; ?>" id="date" name="DOB" placeholder="Date Of Birth"/></div>
        <div class="form-group">
            Clinic Anniversary
            <input type="text" class="form-control" value="<?php echo $rows->ANNIVERSARY; ?>" id="date1" name="ANNIVERSARY" placeholder="Clinic Anniversary"/></div>
        <div class="form-group">
            Name Of Clipa Services
            <input type="text" class="form-control" value="<?php echo $rows->CiplaSerice; ?>" name="ClipaSerice" placeholder=" Name Of Clipa Services"/> </div>
        <div class="form-group">

            FITB DONE &nbsp; 

            <input name="FITB" type="radio" value="Yes" <?php
            if ($rows->FITB == 'Yes') {
                echo "checked";
            }
            ?> > YES
            <input name="FITB" type="radio"  value="No" <?php
            if ($rows->FITB == 'No') {
                echo "checked";
            }
            ?> > No

        </div>


        <button class="btn btn-block btn-success " type="submit">UPDATE</button>
    </div>
</div>
</form>
<script>
    $(function () {
        $("#date1").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

        $("#date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    });</script>

<script src="<?php echo asset_url() ?>js/formValidation.min.js" type="text/javascript"></script>
<script src="<?php echo asset_url() ?>js/bootstrap.min.js" type="text/javascript"></script>
<script>
    $('document').ready(function () {
        $('#valid').formValidation({
            icon: {
            },
            fields: {
                Doctor_Name: {
                    validators: {
                        notEmpty: {
                            message: 'The Doctor_Name  is required'
                        }
                    }
                },
                MSL_Code: {
                    validators: {
                        notEmpty: {
                            message: 'The MSL_Code is required'
                        }
                    }
                },
                address: {
                    validators: {
                        notEmpty: {
                            message: 'The  Address is required'
                        }
                    }
                },
                Mobile_Number: {
                    validators: {
                        notEmpty: {
                            message: 'Moblie_Number is required'
                        },
                        integer: {
                            message: 'Please Enter Digits'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'The Email is required '
                        }
                    }
                },
                Years_Practice: {
                    validators: {
                        notEmpty: {
                            message: 'The Years_Practice is required'
                        }
                    }
                },
                DOB: {
                    validators: {
                        notEmpty: {
                            message: 'The DOB is required'
                        }
                    }
                },
                ANNIVERSARY: {
                    validators: {
                        notEmpty: {
                            message: 'The ANNIVERSARY is required'
                        }
                    }
                },
                ClipaSerice: {
                    validators: {
                        notEmpty: {
                            message: 'ClipaService is required'
                        }
                    }
                },
                State: {
                    validators: {
                        notEmpty: {
                            message: 'State is required'
                        }
                    }
                },
                Region: {
                    validators: {
                        notEmpty: {
                            message: 'Region is required'
                        }
                    }
                },
                Degree: {
                    validators: {
                        notEmpty: {
                            message: 'Degree is required'
                        }
                    }
                },
                Passoutcollege: {
                    validators: {
                        notEmpty: {
                            message: 'Passoutcollege is required'
                        }
                    }
                },
                FITB: {
                    validators: {
                        notEmpty: {
                            message: 'FITB is required'
                        }
                    }
                },
            }

        });
    });
</script>

