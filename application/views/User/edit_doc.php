<?php
$attribute = array('id' => 'valid');
echo form_open('User/update_brand?id=' . $rows['id'], $attribute);
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="form-group">
            Name
            <input type="hidden" class="form-control" value="<?php echo $rows['id'] ?>" name="id"  />
            <input type="text" class="form-control" value="<?php echo $rows['name'] ?>" name="name" placeholder="Name" />
        </div>
        <div class="form-group">
            Form
            <input type="text" class="form-control" value="<?php echo $rows['form']; ?>" name="form" placeholder="Form" /> </div>
        <div class="form-group">
            MRP
            <input type="text" class="form-control" value="<?php echo $rows['mrp']; ?>" name="mrp" placeholder="MRP"/> </div>
        <div class="form-group">
            Company
            <select name="company_id" class="form-control">
                <option value="">Select Company</option>

                <?php echo $company; ?>
            </select>
        </div>
        <div class="form-group">
            Packing
            <input type="text" class="form-control" value="<?php echo $rows['packing']; ?>" name="packing"placeholder="Packing "/> </div>
            <div class="form-group">
            Division
            <select name="division[]" class="form-control">
                <option value="">Select Division</option>
                <?php echo $division; ?>
            </select>
         </div>
        <div class="form-group">
           
            Strength
            <input type="text" class="form-control" value="<?php echo $rows['strength']; ?>" name="strength" placeholder="Strength"/>
           &nbsp
           
          <select name="unit[]" class="btn btn-default">
              <option>Select Option</option>
              
               
                    <option value="mg"<?php if($rows['unit']== 'mg'){  echo 'selected' ;}?>> mg </option>
                    <option value="g"<?php if($rows['unit']== 'g'){  echo 'selected' ;}?>> g </option>
                    <option value="%"<?php if($rows['unit']== '%'){  echo 'selected' ;}?>> % </option>
                </select>
            </div>
        
         
        
        <div class="form-group">
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

