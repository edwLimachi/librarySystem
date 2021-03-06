<?php
//unset($_SESSION["cart"]);
$categories = CategoryData::getAll();
?>
 <style type="text/css">
		.searchGeneral{	    	
			margin-top: 99px;
			margin-left: -115px;
		}	
		@media (max-width: 990px) { 
		  .searchGeneral{	    	
		  	margin-top: 0px;
		  	margin-left: 0px;
		  }	   		     
		}	  
</style> 
<div class="row">
	<div class="col-md-10">
	<h1>Buscar libro para prestar</h1>
	<p><b>Buscar libro por título o por Código/ISBN:</b></p>
			<form id="searchp">
			<div class="row allSearch">
				<div class="col-md-5">
					<input type="hidden" name="view" value="sell">
					<input type="text" id="product_code" name="product" class="form-control">
				</div>
				<div class="col-md-4">			    
				    <div class="col-lg-15">
						<select name="category_id" id="category_id" class="form-control">
						<option value="">Seleccione el tema</option>
						  <?php foreach($categories as $p):?>
						    <option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
						  <?php endforeach; ?>
						</select>
				    </div>
				</div>
				<div class="col-md-3">
				<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
				</div>
			</div>
			</form>		
		</div>
	<div class="col-md-1">
		<form id="searchp2">
			<input type="hidden" name="all" value="all">
			<input type="hidden" name="product" >
			<input type="hidden" name="category_id" >
			<div class="col-md0 searchGeneral">
			<button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-eye-open"></i> Ver todos los libros</button>
			</div>				
		</form>		
	</div>
<div class="col-md-11" id="show_search_results" style="width: 100%;"></div>
<script>
//jQuery.noConflict();

$(document).ready(function(){
	$("#searchp").on("submit",function(e){
		e.preventDefault();
		
		$.get("./?action=searchbook",$("#searchp").serialize(),function(data){
			$("#show_search_results").html(data);
		});
		$("#product_code").val("");
		$("#category_id").val("");

	});
	$("#searchp2").on("submit",function(e){
		e.preventDefault();		
		$.get("./?action=searchbook",$("#searchp2").serialize(),function(data){
			$("#show_search_results").html(data);
		});		

	});
	});
</script>

<!--- Carrito de compras :) -->
<?php if(isset($_SESSION["cart"])):
$total = 0;
?>
<div class="col-md-11" id="clear">
<div class="row">
<div class="col-md-12">
<h2>Proceso para prestar</h2>

<form class="form-horizontal" role="form" method="post" action="./?action=process">
  <div class="form-group" style="width: 112%;">

    <div class="col-lg-3">
    <label class="control-label">Cliente</label>
<select name="client_id" id="client_id" required class="form-control">
<option value="">-- Seleccione --</option>
  <?php foreach(ClientData::getAll() as $p):?>
    <option value="<?php echo $p->id; ?>"><?php echo $p->name." ".$p->lastname; ?></option>
  <?php endforeach; ?>
</select>
    </div>

    <div class="col-lg-3">
    <label class="control-label">Inicio</label>
      <input type="date" name="start_at" id="start_at" required class="form-control" placeholder="Email">
    </div>
    <div class="col-lg-3">
    <label class="control-label">Fin</label>
      <input type="date" name="finish_at" id="finish_at" required class="form-control" placeholder="Email">
    </div>
    <div class="col-lg-2">
    <label class="control-label"><br></label>
      <input type="submit" value="Procesar" class="btn btn-primary btn-block" placeholder="Email">
    </div>
    <div class="col-lg-1">
    <label class="control-label"><br></label>
    <a href="./?action=clearCart" class="btn btn-danger btn-block"><i class="fa fa-trash"></i></a>
    
  </div>

</form>
<table class="table table-bordered table-hover" style="margin: auto;width: 97%;margin-top: 7%;">
<thead>
	<th style="width:40px;">Codigo</th>
	<th style="width:40px;">Ejemplar</th>
	<th>Titulo</th>
	<th></th>
</thead>
<?php foreach($_SESSION["cart"] as $p):
$book = BookData::getById($p["book_id"]);
$item = ItemData::getById($p["item_id"]);

?>
<tr >
	<td><?php echo $book->isbn; ?></td>
	<td ><?php echo $item->code; ?></td>
	<td ><?php echo $book->title; ?></td>
	<td style="width:30px;">
	<!-- <a href="./?view=home" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a> -->
	<a href="index.php?view=clearCart&book_id=<?php echo $book->id; ?>&item_id=<?php echo $item->id; ?>" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
	</td>
</tr>

<?php endforeach; ?>
</table>
</div>
</div>
</div>
<br><br><br><br><br>
<?php endif; ?>

<!-- <script type="text/javascript">
	function clear(){				
		document.getElementById("client_id").value = "";
		document.getElementById("start_at").value = "";
		document.getElementById("finish_at").value = "";		
	}	
</script> -->

























