<?php
$connect = mysqli_connect("localhost", "root", "", "raia_media_db");
$output = '';
if (isset($_POST['Report'])) {
    $output .= '
          <table class="table table-striped table-hover">
           <thead>
           <tr>
           <th>#</th>
           <th>location name </th>
            <th>Cost name </th>
            <th>Invoice Value</th>
            <th>Invoice entry date</th>
            <th>Invoice date</th>
            <th>Reference Number</th>

            </tr>
            </thead>';
    $sql = "SELECT * from cost_details ";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 0;
    foreach ($results as $result20) {
        $sql = "SELECT * from cost where cost_id = ($result20->cost_id)";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $count = 0;
        $cnt+=1;
        

            foreach ($results as $result1) {
                $cost_name = ($result1->cost_name);
                $sql = "SELECT * from location where location_ide = ($result1->location_ide)";
                $query = $dbh->prepare($sql);
                $query->execute();

                $results = $query->fetchAll(PDO::FETCH_OBJ);
                foreach ($results as $result2) {
                    $unit = ($result2->location_unit);
                }
            }
            $cost_value = ($result20->cost_value);
            $ref_number = ($result20->ref_number);
            $invoice_date = ($result20->invoice_date);
            $cost_date = ($result20->cost_date);
            $output .= '
			<tr>
				<td>' . $cnt . '</td>  
                <td>' . $unit . '</td> 
				<td>' . $cost_name . '</td>  
				 
                <td>' . $cost_value . '</td>  
				<td>' . $cost_date . '</td>  
				<td>' . $invoice_date . '</td>  
				<td>' . $ref_number . '</td>  
			</tr>
		   ';

        }
            header('Content-Type: application/xls');
            header('Content-Disposition: attachment; filename=download.xls');
            echo $output;
        exit;
    
}
