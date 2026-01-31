<?php
require_once("db.php");


if(!empty($_POST["keyword"])) {


$query ="SELECT * FROM cliente WHERE nombreComercial like '" . $_POST["keyword"] . "%' ORDER BY nombreComercial LIMIT 0,6";
$result = mysqli_query($connection,$query);


if(!empty($result)) {
?>
<?php
foreach($result as $cliente) {
?>
<option value="<?php echo $cliente["idCliente"]; ?>" onClick="selectCliente('<?php echo $cliente["nombreComercial"]; ?>');">
	<?php echo $cliente["nombreComercial"]; ?>
	<?php echo $cliente["idCliente"]; ?>
</option>
<?php } ?>

<?php } } ?>