<?php
class COD
{
	public function CODuploadReceivables($handle)
	{
		while(($data = fgetcsv($handle, 1000, ',')) != FALSE) {
				echo "Value from csv:" . $data[0];
				// try {
					/* $bind = array($data[4], $data[12], "Not Approved", $data[10], "NI", $data[1]);
			        $connection->query($sql, $bind);
			        $connection->commit(); */
		    	// } catch(Exception $e) {
					// echo "Exception" . $e->getMessage();
			    // }
			}
	}
}