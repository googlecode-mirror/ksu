<?

class zetro_slip{
	public $path;	
	function __construct($path='c:\\temp\\'){
		$this->path=$path;
	}
	function namafile($filename){
		$this->filename=$filename;
	}
	function colom($kolom){
		$this->colom=$colom;
	}
	
	function newline($jmlbaris=''){
		//$this->jmlbaris=1;
		for ($i=1;$i<=$jmlbaris;$i++){
			$this->jmlbaris .="\r\n";		
		}
		return $this->jmlbaris;
	}
	function modes($model="wb"){
		$this->model=$model;	
	}
	
	function create_file(){
		$newfile=fopen($this->path.'_slip.txt',$this->model);
		fwrite($newfile,$this->newline());
		foreach($this->isifile as $data){
		fwrite($newfile,$data);
		}
		fwrite($newfile,$this->newline());
		fclose($newfile);
	}
	function content($isifile=array()){
		$this->isifile=$isifile;
	}
}