<?php
class BookData {
	public static $tablename = "book";


	public function BookData(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function getCategory(){ return $this->category_id!=null? CategoryData::getById($this->category_id) : null ; }
	public function getEditorial(){ return $this->editorial_id!=null? EditorialData::getById($this->editorial_id) : null ; }
	public function getAuthor(){ return $this->author_id!=null? AuthorData::getById($this->author_id) : null ; }

	public function add(){
		$sql = "insert into book (isbn,title,subtitle,institucion,description,image,locationShelf,keywords,n_pag,year,category_id,editorial_id,author_id) ";
		$sql .= "value (\"$this->isbn\",\"$this->title\",\"$this->subtitle\",\"$this->institucion\",\"$this->description\",\"$this->image\",\"$this->locationShelf\",\"$this->keywords\",\"$this->n_pag\",\"$this->year\",$this->category_id,$this->editorial_id,$this->author_id)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto BookData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set title=\"$this->title\",subtitle=\"$this->subtitle\",institucion=\"$this->institucion\",isbn=\"$this->isbn\",description=\"$this->description\",image=\"$this->image\",locationShelf=\"$this->locationShelf\",keywords=\"$this->keywords\",n_pag=\"$this->n_pag\",year=\"$this->year\",category_id=$this->category_id,editorial_id=$this->editorial_id,author_id=$this->author_id where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new BookData());
	}

	public static function getByMail($mail){
		$sql = "select * from ".self::$tablename." where mail=\"$mail\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new BookData());
	}

	public static function getEvery(){
		$sql = "select *,date_add( concat(concat(date_at,\"T\"), time_at),interval duration minute) as time_end  from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new BookData());
	}


	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new BookData());
	}

	public static function getLike($q){
		//$sql = "select * from ".self::$tablename." where isbn like '%$q%' or title like '$q%'";
		//busqueda del libro segun la condicion: por la primera letra || este vacio || busque por titulo o isbn
		if (is_int($q)) {
			$sql = "SELECT book.id,isbn,title,subtitle,institucion,name,lastname FROM `book` inner join `author` on book.author_id=author.id where category_id=$q order by title asc";
		}
		elseif (strlen($q)==1) {
			$sql = "SELECT book.id,isbn,title,subtitle,institucion,name,lastname FROM `book` inner join `author` on book.author_id=author.id where isbn like '%$q%' or title like '$q%'";
		}elseif ($q=="allTheBooks") {
			$sql = "SELECT book.id,isbn,title,subtitle,institucion,description,file,image,year,n_pag,author_id,editorial_id,category_id,name,lastname FROM `book` inner join `author` on book.author_id=author.id order by title asc";
		}elseif ($q) {
			$sql = "SELECT book.id,isbn,title,subtitle,institucion,name,lastname FROM `book` inner join `author` on book.author_id=author.id where isbn like '%$q%' or title like '%$q%' or keywords like '%$q%' order by title asc";
		}

		$query = Executor::doit($sql);
		return Model::many($query[0],new BookData());
	}


}

?>