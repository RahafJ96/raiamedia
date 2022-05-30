<?php  
$connect = mysqli_connect("localhost", "root", "", "raia_media_db");
$output = '';
if(isset($_POST["export"]))
{
	$output .= '
   <table >  
                    <tr>  
                         <th>Location Unit</th>  
                         <th>Start Date</th>  
                         <th>End Date</th>  
       					 <th>Price</th>
      					 <th>Discount</th>
						 <th>Net Price</th>
                    </tr>
  ';

	$ide = $_GET['location'];
	$location = $_POST['location'];
	$start = $_POST['start_date'];
	$end = $_POST['end_date'];
	$cnt1 = 1;
	$count=0;
	if ($location != -1) {
		echo $ide;
		$query = "SELECT * from location_offers where location_id=$location";
		 $result = mysqli_query($connect, $query);
		 if(mysqli_num_rows($result) > 0)
		 {
		  
		  while ($row = mysqli_fetch_array($result)) {
			  $y = $row["start_date"];
			  $y1 = $row["end_date"];
			  $z=$row["location_id"];
			  $name="a";
			   $sql = "SELECT * from location where location_ide= $z";
			   $count += $row["net_price"];

																	$query = $dbh->prepare($sql);
																	$query->execute();
																	$results = $query->fetchAll(PDO::FETCH_OBJ);
																	foreach ($results as $result1) {
																		$name=$result1->location_unit;
																	} 
			  if ((($start < $y) && ($end > $y1)) || ($start == $y) && ($end > $y1) || ($start < $y) && ($end == $y1) || ($start == $y) && ($end == $y1)) {
				  $output .= '
			<tr>
				<td> '. $name .'</td>  
				<td>'.$row["start_date"].'</td>  
				<td>'.$row["end_date"].'</td>  
				<td>'.$row["price"].'</td>  
				<td>'.$row["discount"].'</td>
				<td>'.$row["net_price"].'</td>
			</tr>
		   ';
			  }
		  }
		  $output .= '
		  <tr>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td><b>Total: '. $count .' JD</b></td>
</tr>  
		  </table>';
		  header('Content-Type: application/xls');
		  header('Content-Disposition: attachment; filename=download.xls');
		  echo $output;
		 }
	}else{
		echo $ide;
		$count=0;

		$query = "SELECT * from location_offers";
		 $result = mysqli_query($connect, $query);
		 if(mysqli_num_rows($result) > 0)
		 {
		  
		  while ($row = mysqli_fetch_array($result)) {
			  $y = $row["start_date"];
			  $y1 = $row["end_date"];
			  $z=$row["location_id"];
			  $name="a";
			   $sql = "SELECT * from location where location_ide= $z ";
			   $count += $row["net_price"];
																	$query = $dbh->prepare($sql);
																	$query->execute();
																	$results = $query->fetchAll(PDO::FETCH_OBJ);
																	foreach ($results as $result1) {
																		$name=$result1->location_unit;
																	} 
			  if ((($start < $y) && ($end > $y1)) || ($start == $y) && ($end > $y1) || ($start < $y) && ($end == $y1) || ($start == $y) && ($end == $y1)) {
				  $output .= '
			<tr>
				<td> '. $name .'</td>  
				<td>'.$row["start_date"].'</td>  
				<td>'.$row["end_date"].'</td>  
				<td>'.$row["price"].' JD</td>  
				<td>'.$row["discount"].' JD</td>
				<td>'.$row["net_price"].' JD</td>
			</tr>

		   ';
			  }
		  }
		  $output .= '
		  <tr>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td><b>Total: '. $count .' JD</b></td>
</tr> 
		  </table>';
		  header('Content-Type: application/xls');
		  header('Content-Disposition: attachment; filename=download.xls');
		  echo $output;
		 }
	}

 exit;
}
