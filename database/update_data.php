<?php 

	function updateData($conn, $table_name, $id, $Naziv_auta, $Boja_auta, $Tip_auta, $Tip_motora, $Godina_proizvodnje, $Cena) {

			$sql = "UPDATE `vozila` SET `Id`='13',`Naziv_auta`='Passat',`Boja_auta`='Siva',`Tip_auta`='Karavan',`Tip_motora`='benzin',`Godina_proizvodnje`='2013',`Cena`='10000' WHERE Id='12')";
				
		return $conn->query($sql);
}

?>