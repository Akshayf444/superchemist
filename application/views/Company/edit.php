<?php
$attribute = array('id' => 'valid');
echo form_open('User/editCompany/' . $rows->company_id, $attribute);
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="form-group">
            Name
            <input type="hidden" class="form-control" value="<?php echo $rows->company_id ?>" name="company_id"  />
            <input type="text" class="form-control" value="<?php echo $rows->company_name ?>" name="company_name" placeholder="Name" />
        </div>
        <div class="form-group">
            Contact Person
            <input type="text" class="form-control" value="<?php echo $rows->contact_person_name ?>" name="contact_person_name" placeholder="Contact Person" /> </div>
        <div class="form-group">
            Email
            <input type="text" class="form-control" value="<?php echo $rows->email ?>" name="email" placeholder="Email"/> </div>

        <div class="form-group">
            Mobile
            <input type="text" class="form-control" value="<?php echo $rows->mobile ?>" name="mobile" placeholder="Mobile"/> </div>
        <div class="form-group">
            Password
            <input type="text" class="form-control" value="<?php echo $rows->password ?>" name="password" placeholder="Password"/> </div>
        <div class="form-group">
            City
            <input type="text" class="form-control" value="<?php echo $rows->city ?>" name="city" placeholder="City"/> </div>
        <div class="form-group">
            Pincode
            <input type="text" class="form-control" value="<?php echo $rows->mobile ?>" name="pin_code" placeholder="Pincode"/> </div>
            <div class="form-group">
            Address
            <input type="text" class="form-control" value="<?php echo $rows->address ?>" name="address" placeholder="Address"/> </div>

        <div class="form-group">
            <button class="btn btn-block btn-success " type="submit">UPDATE</button>
        </div>
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

