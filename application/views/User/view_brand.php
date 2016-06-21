<div class="row">
    <div class="col-lg-12 table-responsive" >
        <table class="table table-bordered table-hover panel" id="datatable">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Brand Name</th>
                    <th>Form</th>
                    <th>MRP</th>
                    <th>Packing</th>
                    <th>Strength</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                if (!empty($response)) {
                    foreach ($response as $row) :
                        ?><tr>  
                            <td data-title="Sr"><?php echo $count++; ?></td>
                            <td data-title="State"><?php echo $row['name']; ?></td>
                            <td data-title="Region"><?php echo $row['form']; ?></td>
                            <td data-title="Doctor Name"><?php echo $row['mrp']; ?></td>  
                            <td data-title="MSL Code"><?php echo $row['packing']; ?> </td> 
                            <td data-title="Address"><?php echo $row['strength']; ?></td>  
                        </tr>
                        <?php
                    endforeach;
                }
                ?>
            </tbody>
        </table>
    </div>



</div>
<script>
    function deletedoc(url) {
        var r = confirm("Are you sure you want to delete");
        if (r == true)
        {
            window.location = url;

        }
        else
        {
            return false;
        }
    }

</script>