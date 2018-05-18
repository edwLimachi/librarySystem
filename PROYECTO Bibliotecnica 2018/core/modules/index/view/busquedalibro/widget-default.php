<?php
//unset($_SESSION["cart"]);
$categories = CategoryData::getAll();
?>
<div class="row">
	<div class="col-md-12">
	<h1>Buscar Libro</h1>
	<p><b>Buscar libro por título o por Código/ISBN:</b></p>
		<form id="searchp">
		<div class="row">
			<div class="col-md-6">
				<input type="hidden" name="view" value="sell">
				<input type="text" id="product_code" name="product" placeholder="Ver todos los libros" class="form-control">
			</div>
<!-- 
			<div class="col-md-1">
				<h1>ó</h1>
			</div>
 -->
			<div class="col-md-3">			    
			    <div class="col-lg-15">
					<select name="category_id" class="form-control">
					<option value="">SELECCIONE EL TEMA</option>
					  <?php foreach($categories as $p):?>
					    <option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
					  <?php endforeach; ?>
					</select>
			    </div>
			</div>	

			<div class="col-md-1">
			<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
			</div>		
					
		</div>
		</form>
	</div>
<div id="show_search_results"></div>
<script>
//jQuery.noConflict();

$(document).ready(function(){
	$("#searchp").on("submit",function(e){
		e.preventDefault();
		
		$.get("./?action=buscarlibro",$("#searchp").serialize(),function(data){
			$("#show_search_results").html(data);
		});
		$("#product_code").val("");

	});
	});
</script>
