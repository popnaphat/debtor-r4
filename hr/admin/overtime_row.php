<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT empID,dept_cover,emp_prename,emp_name,emp_surname,emp_position,DEPT_SHORT,appointdate
		 FROM emplist em JOIN pea_office po ON po.unit_code = em.DEPT_CHANGE_CODE WHERE em.empID = $id";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>