<style>
    .content-wrapper{
        min-height: 775px;
    }    
</style>
<?php
$attribute = array('id' => 'valid');
echo form_open('api/reg', $attribute);
?>
<div class="row" >
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="form-group">
            Name
            <input type="text" class="form-control" value="" name="full_name" placeholder="Doctor Name" />
        </div>
        <div class="form-group">
            MSL Code
            <input type="text" class="form-control" value="" name="address" placeholder="MSL Code" /> </div>
        
        <div class="form-group">
            Mobile Number
            <input type="text" class="form-control" value="" name="city" placeholder="Mobile "/> </div>
        <div class="form-group">
            Email
            <input type="text" class="form-control" value="" name="state" placeholder="Email"/> </div>
        <div class="form-group">
            Degree
            <input type="text"  class="form-control" name="mobile" placeholder="Degree" >
        </div>	    
        <div class="form-group">
            Passout College
            <input type="text"  class="form-control" name="business_name" required="" placeholder=" Passout College" >
        </div>	
        <div class="form-group">
            Region
            <input type="text"  class="form-control" name="pincode" placeholder="Region" >
        </div>	
        <div class="form-group">
            State
            <input type="text"  class="form-control" name="password" placeholder="State" >
        </div>	
       
        <div class="form-group">
            Date Of Birth
            <input type="text" class="form-control" value="" id="date" name="email" placeholder="Date Of Birth"/></div>
        <div class="form-group">
            Clinic Anniversary
            <input type="text" class="form-control" value="" id="date1" name="device_id" placeholder="Clinic Anniversary"/></div>
        <div class="form-group">
            Name Of Clipa Services
            <input type="text" class="form-control" value="" name="user_type" placeholder=" Name Of Clipa Services"/> </div>
        
        <button class="btn btn-block btn-success " type="submit">SAVE</button>
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
                            message: 'The Address is required'
                        }
                    }
                },
                Mobile_Number: {
                    validators: {
                        notEmpty: {
                            message: 'Moblie Number is required'
                        },
                        integer: {
                            message: 'Please Enter Digits'
                        }
                    },
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
                            message: 'The Years Of Practice is required'
                        }
                    }
                },
                DOB: {
                    validators: {
                        notEmpty: {
                            message: 'Date Of Birth is required'
                        }
                    }
                },
                ANNIVERSARY: {
                    validators: {
                        notEmpty: {
                            message: 'Date Of Anniversary is required'
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

