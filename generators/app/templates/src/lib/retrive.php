<?php

class Retrive{

	static private function select_data($key_words, $table_name, $condition){
		return "SELECT ".implode(",", array_values($key_words))." FROM {$table_name} {$condition}";
	}

	static function get_specific_data($connection, $table_name, $id){
		return mysqli_query($connection, "SELECT * FROM {$table_name} WHERE JobNewsID='{$id}'");
	}

	static function get_specific_data2($connection, $table_name, $target_field, $input_field_name, $input_data){
		return mysqli_query($connection, "SELECT `{$target_field}` FROM {$table_name} WHERE {$input_field_name}='{$input_data}'");
	}

	static function create_view($connection, $table_name, $condition){
		return mysqli_query($connection, "CREATE VIEW JobSearch AS SELECT * FROM {$table_name} {$condition}");
	}

	static function drop_view($connection){
		return mysqli_query($connection, "DROP VIEW JobSearch");
	}

	static function one_specific_data($connection, $table_name, $field_name, $email){
		$result = mysqli_query($connection, "SELECT * FROM {$table_name} WHERE email='{$email}'");
		while($row = mysqli_fetch_array($result))
		  {
		  return $row[$field_name];
		  }
	}

	static function target_specific_data($connection, $table_name, $field_name, $input_field_name, $input_data){
		$result = mysqli_query($connection, "SELECT * FROM {$table_name} WHERE {$input_field_name}='{$input_data}'");
		while($row = mysqli_fetch_array($result))
		  {
		  return $row[$field_name];
		  }
	}

	static function get_all_data($connection, $table_name, $data_field_name){
		return mysqli_query($connection, "SELECT DISTINCT * FROM {$table_name} ORDER BY {$data_field_name}");
	}

	static function get_data($connection, $key_words, $table_name, $condition){
		return mysqli_query($connection, Retrive::select_data($key_words, $table_name, $condition));
	}

	static function record_count($connection, $key_words, $table_name, $condition){
		return mysqli_num_rows(Retrive::get_data($connection, $key_words, $table_name, $condition));
	}

	static function page_count($connection, $key_words, $table_name, $condition, $record_per_page){
		return ceil(Retrive::record_count($connection, $key_words, $table_name, $condition) / $record_per_page);
	}

	static function page_number(){
		$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
		return $page;
	}

	static function start_page($record_per_page){
		return (Retrive::page_number() - 1) * $record_per_page;
	}

	static function process_data($key_words, $table_name, $condition, $record_per_page){
		$start = Retrive::start_page($record_per_page);
		return "SELECT ".implode(",", array_values($key_words)).
			" FROM {$table_name} {$condition} LIMIT {$start}, {$record_per_page}";
	}

	static function process_data2($key_words, $table_name, $condition, $start, $record_per_page){
		return "SELECT ".implode(",", array_values($key_words)).
			" FROM {$table_name} {$condition} LIMIT {$start}, {$record_per_page}";
	}

#**********************************************************
# Required Functions to Retrive Data from a Database Tabe #
#**********************************************************


	static function display_data($connection, $key_words, $table_name, $condition, $record_per_page){
		return mysqli_query($connection, Retrive::process_data($key_words, $table_name, $condition, $record_per_page));
	}

	static function display_data2($connection, $key_words, $table_name, $condition, $start, $record_per_page){
		return mysqli_query($connection, Retrive::process_data2($key_words, $table_name, $condition, $start, $record_per_page));
	}

	static function get_pages($connection, $module_name, $key_words, $table_name, $condition, $record_per_page){
		$page = Retrive::page_number();
		$pages = Retrive::page_count($connection, $key_words, $table_name, $condition, $record_per_page);
		$prev = $page - 1;
		$next = $page + 1;
		if($page>1){
			echo "<a href='{$module_name}?page=$prev'>Prev</a> ";
		}
		if($pages >= 1){
			for($x=1;$x<=$pages;$x++){
				echo ($x == $page) ? '<b>'.$x.'</b> ' :'<a href="?page='.$x.'">'.$x.'</a> ';
			}
		}
		if($page<$pages){
			echo "<a href='{$module_name}?page=$next'>Next</a>";
		}
	}

	static function extension_link($name, $link_ref){
		return "<a href='{$name}.php?detail={$link_ref}'>Detail</a>";
	}

	static function extention_data($ref, $connection, $table_name){
		if(isset($_GET[$ref])){
			$id = $_GET[$ref];
			$result = Retrive::get_specific_data($connection, $table_name, $id);
			return mysqli_fetch_array($result);
		}
	}

	# $input_field_name = must be unique field
	# $input_data = corresponding session value
	static function array_data($connection, $table_name, $input_field_name, $input_data){
		$result = mysqli_query($connection, "SELECT * FROM {$table_name} WHERE {$input_field_name}='{$input_data}'");
		return mysqli_fetch_array($result);
	}

	static function condition_array_data($connection, $table_name, $condition){
		$result = mysqli_query($connection, "SELECT * FROM {$table_name} WHERE {$condition}");
		return mysqli_fetch_array($result);
	}

}
