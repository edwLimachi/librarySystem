<?php 
?>
<div class="row">
	<div class="col-md-12">
          <a href="index.php?view=newbook" class="btn btn-default pull-right"><i class="fa fa-book"></i> Añadir Libro</a>

		<h1>Centro de Stock de Libros</h1>


		<?php
$books = BookData::getAll();
		if(count($books)>0){
			// Si hay usuarios
			?>
			<table class="table table-bordered table-hover">
			<thead>
			<th>ISBN</th>
			<th>Titulo</th>
			<th>Subtitulo</th>
			<th>Institucion</th>
			<th>Ejemplares</th>
			<th>Disponibles</th>
			<th>Categoria</th>
			<th></th>
			</thead>
			<?php
			foreach($books as $user){
				$category  = $user->getCategory();
				?>
				<?php $u=null; if(Session::getUID()!=""): $u = UserData::getById(Session::getUID()); ?>
				<tr>
				<td><?php echo $user->isbn; ?></td>
				<td><?php echo $user->title; ?></td>
				<td><?php echo $user->subtitle; ?></td>
				<td><?php echo $user->institucion; ?></td>
				<td><?php echo ItemData::countByBookId($user->id)->c; ?></td>
				<td><?php echo ItemData::countAvaiableByBookId($user->id)->c; ?></td>
				<td><?php if($category!=null){ echo $category->name; }  ?></td>
				<td style="width:210px;">
				<a href="index.php?view=items&id=<?php echo $user->id;?>" class="btn btn-default btn-xs">Ejemplares</a>
				<?php if($u->is_admin): ?>
				<a href="index.php?view=editbook&id=<?php echo $user->id;?>" class="btn btn-warning btn-xs">Editar</a>
				<a href="index.php?action=delbook&id=<?php echo $user->id;?>" class="btn btn-danger btn-xs">Eliminar</a>
				<?php endif; ?>
				</td>
				</tr> <?php endif; ?>
				<?php
			}


				?>
				</table>
				<?php

		}else{
			echo "<p class='alert alert-danger'>No hay libros disponibles</p>";
		}


		?>


	</div>
</div>