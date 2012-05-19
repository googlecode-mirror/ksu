<?php
class Admin extends CI_Controller {
  public $tc;
  public $zn;
	public $zc;
	public $zm;
    function  __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
		$this->tc= new zetro_table_creator('asset/bin/zetro_table.cfg');
		$this->zn= new zetro_manager();
		$this->zc='asset/bin/zetro_config.dll';
		$this->zm='asset/bin/zetro_menu.dll';
	}
    function index() {
		$this->cek_db_user();
	}
	function addusersimpan(){
		$data=array();
		$data['userid']=str_replace(' ','',$this->input->post("userid"));
		$data['username']=str_replace("'","\'",$this->input->post("username"));
		$data['levelid']=$this->input->post("levelid");
		$data['password']=md5($this->input->post("password"));
		if($this->Admin_model->user_exists($this->input->post("userid"))==0){
			$this->Admin_model->simpan_data('users',$data);
			redirect('admin/userlist');
		}else{
		echo "<script language='javascript'>alert('UserId Sudah ada'); window.history.back();</script>";
		}
	}
	function adduserupdate(){
		$data=array();
		$data['username']=$this->input->post("username");
		$data['levelid']=$this->input->post("levelid");
		
			$this->Admin_model->update_table('users','userid',$this->input->post("userid"),$data);
			redirect('admin/userlist');
	
	}
	 public function delete_user(){
		 $user=trim($_POST['userid']);
		 $this->Admin_model->hapus_table('users','userid',$user);
		 echo $user;
	 }
	 public function delete_level(){
		 $user=trim($_POST['idlevel']);
		 $this->Admin_model->hapus_table('user_level','idlevel',$user);
		 echo $user;
	 }
	public function paginat($halaman,$tabel,$limit){
		    $data=array();$config=array();
			$page=$this->uri->segment(3);
		    $ttdata=$this->Admin_model->total_data($tabel);
			$config['base_url'] = base_url() . '/index.php/admin/$halaman/';
			$config['total_rows'] = $ttdata;
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Fist';
			$config['last_link'] = 'Last';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Prev';
			$this->pagination->initialize($config);
			$data["paginator"]=$this->pagination->create_links();
			$data["page"] = $page;
	}
	function userlist(){
		$this->nama_file('userlist');
		//$data=$this->cek_auth();
		$limit=100;
		$this->paginat('userlist','users',$limit);
		//(!$page)? $offset=0:$offset=$page;
		$offset=0;
		$data['userlst']=$this->Admin_model->userlist($limit,$offset);
				$this->load->view('admin/header');
				($this->auth_all($this->menu)==true)?
				$this->load->view('admin/userlist',$data):
				$this->load->view("admin/no_authorisation");
				$this->load->view('admin/footer');
	}
	//fungsi setup master pendapatan
	//fungsi proses login
	function process_login() {

        $this->form_validation->set_rules('username', 'username', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'required|xss_clean');
        $this->form_validation->set_error_delimiters('', '<br/>');

        if ($this->form_validation->run() == TRUE) 
		{
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $login_data = $this->Admin_model->cek_user_login($username, $password);
			if ($login_data == TRUE)
				{$session_data = array
				(
					'userid' => $login_data['userid'],
					'username' => $login_data['username'],
					'levelid' => $login_data['levelid'],
					'login' => TRUE,
				);
				$this->session->set_userdata($session_data);
				redirect('admin/index');
			}else{
				redirect('admin/process_login');
			}
        }
        
		$this->load->view('admin/header');
		$this->load->view('admin/login');
		$this->load->view('admin/footer');
    }
	//fungsi ganti password
	function change_password(){
		$data=array();
		$data['user_id']=$this->session->userdata('userid');
			$this->load->view('admin/header');
			$this->load->view('admin/change_password',$data);
			$this->load->view('admin/footer');
	}
	function pwdupdate(){
	  $data=array();
	  $data['password']=md5($this->input->post("new_pass"));
	  $pwd_old=$this->Admin_model->cek_pwd();
	  if($pwd_old==md5($this->input->post("old_pass"))){
			$this->Admin_model->update_table('users','userid',$this->session->userdata("userid"),$data);
			echo "<script language='javascript'>alert('Password berhasil di ganti.\n Silahkan Login kembali');</script>";
			redirect('admin/logout');
		}else{
			echo "Password\n";
			echo "<script language='javascript'> alert('Password lama tidak cocok); window.history.back();</script>";
		}
	  	
	}
    function dashboard() {
        $this->check_logged_in();
        $this->load->view('dashboard');
    }

    function logout() {
        $data = array
            (
            'user_id' => 0,
            'username' => 0,
            'type' => 0,
            'login' => FALSE
        );
        $this->session->sess_destroy();
        $this->session->unset_userdata($data);
        redirect('admin/process_login');
    }

    public function check_logged_in() {
        if ($this->session->userdata('login') != TRUE) {
            redirect('admin/login', 'refresh');
            exit();
        }
    }

    public function is_logged_in() {
        if ($this->session->userdata('logged_in') == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	public function cek_auth($idmenu=''){
		$data=array();
		$data_auth=array();
			$data_auth=$this->Admin_model->cek_Auth($idmenu);
			//print_r( $data_auth);
			if($data_auth['userid']!=''){
			$data['idmenu']=$data_auth['idmenu'];
			$data['create']=$data_auth['c'];
			$data['edit']=$data_auth['e'];
			$data['view']=$data_auth['v'];
			$data['print']=$data_auth['p'];
			$data['full']=$data_auth['d'];
			}
	}
	public function auth_all($section){
		$data['oto']=$this->Admin_model->cek_Auth($section);
		print_r($data);
		if(count($data['oto'])>0 ){
			if($this->session->userdata('userid')!='Superuser'){
				if($data['oto']['c']=='Y' ||
					$data['oto']['e']=='Y'||
					$data['oto']['v']=='Y'||
					$data['oto']['p']=='Y'){ return true;}else{return false;}
				}
			}else{ return true;}
	}
	public function penomoran(){
	//$data=array();
	$datak=$this->Admin_model->penomoran();
	if(count($datak)>0){$nomor=$datak['nomor'];}else{$nomor='';}
	($nomor=='')?$nomor=1:$nomor=(int)$nomor+1;
		if(strlen($nomor)==1){
		$nomo='00'.$nomor;
		}else if(strlen($nomor)==2){
			$nomo='00'.$nomor;
		}else{
			$nomo=$nomor;
		}
		$nom=date('Ymd').'-'.$nomo;
		return $nom;
	}
	public function hapus($section='setup_kredit',$key='id_dapat'){
		$id='';
		($this->uri->segment(4)==false)?$id=$this->uri->segment(3):$id=$this->uri->segment(4);
		$data=array();
			$this->Admin_model->hapus_table($section,$key,$id);	
	}
	
	public function transaksi($limit=5){
		$data=array();
		//create table setup_kredit and jenis_trans
		$this->tc->table_name($this->content);
		$this->tc->section($this->content);
		$this->tc->table_created();
		($this->menu=='uang_masuk')?$jn='setup_kredit':$jn='setup_debit';
			$data['oto']=$this->Admin_model->cek_Auth($this->content);
			($this->grid==true)?$data['prs']='list':$data['prs']='';
			$data['urutan']=$this->penomoran();
			$data['asal']=$this->Admin_model->isi_list($jn);
			$data['kasbank']=$this->Admin_model->isi_list('setup_bank');
			$data['bln']=$this->Admin_model->isi_list($this->content,"order by month(tgl_trans)","distinct(month(tgl_trans))as bulan");
			$data['thn']=$this->Admin_model->isi_list($this->content,"order by year(tgl_trans)","distinct(year(tgl_trans))as thn");
			//pagination/*
			$page=$this->uri->segment(3);
			//$limit=5;
			(!$page)? $offset=0:$offset=$page;
		    $ttdata=$this->Admin_model->total_data($this->content,$this->jn_trans,$this->field);
			$config['base_url'] = base_url() . "/index.php/admin/lap_".$this->menu."/";
			$config['total_rows'] = $ttdata;
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Fist';
			$config['last_link'] = 'Last';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Prev';
			$this->pagination->initialize($config);
			$data["paginator"]=$this->pagination->create_links();
			$data["page"] = $page;
			$data['blnselect']=$this->bulan;
			$data['thnselect']=$this->tahun;
			($this->jn_trans!='')?$jn="jn_trans='".$this->jn_trans."' and":$jn=""; 
				$data['list']=$this->Admin_model->show_list($this->content,"where $jn month(tgl_trans)='".$this->bulan."' and year(tgl_trans)='".$this->tahun."' order by tgl_trans limit $offset,$limit");
				$this->load->view('admin/header');
				$this->load->view('support');
				($this->auth_all($this->menu)==true)?
                $this->load->view("admin/".$this->menu,$data):
				$this->load->view("admin/no_authorisation");
				$this->load->view('admin/footer');
	}
	function nama_file($menu){
		$this->menu=$menu;
	}
	
	function nama_tabel($content){
		$this->content=$content;	
	}
	function nbulan($bulan){
		$this->bulan=nBulan(round($bulan));
	}
	function ntahun($thn){
		$this->tahun=$thn;
	}
	function ngrid($list,$jn_trans='',$field=''){
		$this->grid=$list;
		$this->jn_trans=$jn_trans;
		$this->field=$field;
	}
	function cek_db_user(){
		//$this->db->select('*');
		$query="show tables in ".$this->zn->rContent("Server","dbname",$this->zc)." like 'users'";
		$rs=mysql_query($query)or die(mysql_error());
		if (!mysql_num_rows($rs)){
			$sql="Create table if not exists `users` (
				 `userid` VARCHAR(50) NULL DEFAULT NULL,
				 `username` VARCHAR(200) NULL DEFAULT NULL,
				 `password` VARCHAR(200) NULL DEFAULT NULL,
				 `levelid` VARCHAR(50) NULL DEFAULT NULL,
				 `active` ENUM('Y','N') NULL DEFAULT 'Y',
				 `createdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
				 PRIMARY KEY (`userid`)
				 )
				 COLLATE='latin1_swedish_ci'
				 ENGINE=MyISAM";
			mysql_query($sql);
				  
		}
		$sql="select * from users";
		$r=mysql_query($sql) or die(mysql_error());
		if(!mysql_num_rows($r)){
			$this->load->view('admin/header');
			$this->load->view('admin/admin_user');
			$this->load->view('admin/footer');
		}else{
		$data=array();
		if($this->session->userdata('login')==true){
			$this->Admin_model->create_useroto();
			if ($this->session->userdata('levelid')!='1'){
				$data['oto']=$this->Admin_model->cek_Auth();
				/*print_r($data['oto']);
				if($data_auth['userid']!=''){
				$data['idmenu']=$data_auth['idmenu'];
				$data['create']=$data_auth['c'];
				$data['edit']=$data_auth['e'];
				$data['view']=$data_auth['v'];
				$data['print']=$data_auth['p'];
				$data['full']=$data_auth['d'];
				}*/
			}
			$this->load->view('admin/header');
			$this->load->view('admin/home');//$data);
			$this->load->view('admin/footer');
		}else{
			$this->load->view('admin/header');
			$this->load->view('admin/login');
			$this->load->view('admin/footer');
		}
		}
	}
	function process_userfirst(){
        $this->form_validation->set_rules('username', 'username', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'required|xss_clean');
        $this->form_validation->set_error_delimiters('', '<br/>');
		$data=array();$lvl=array();
        if ($this->form_validation->run() == TRUE) 
		{
            $data['userid'] = $this->input->post('username');
			$data['username']=$this->input->post('username');
            $data['password'] = md5( $this->input->post('password'));
			$data['levelid']='1';
			$this->Admin_model->simpan_data('users',$data);
			$this->Admin_model->user_level();
			//$lvl["idlevel"]="1";
			$lvl["nmlevel"]="Super User";
			$this->Admin_model->simpan_data('user_level',$lvl);
			redirect ('Admin/index');
		}else{
			redirect ('Admin/index');
		}
	}
	function useroto(){
		$userid=$_POST['oto_usernm'];
		$jml_menu=$this->zn->Count("Menu Utama",$this->zm);
		for ($i=1;$i<=$jml_menu;$i++){
			$mnu=explode('|',$this->zn->rContent("Menu Utama","$i",$this->zm));
			echo "<tr class='xx list_genap' id='".$mnu[0]."'>\n
				  <td class='kotak' align='center'>$i</td>\n
				  <td class='kotak' colspan='6'>".str_repeat('&nbsp;',3).$mnu[0]."</td>\n
				  </tr>\n";
				  $sub_menu=$this->zn->Count($mnu[0],$this->zm);
				  for ($sm=1;$sm<=$sub_menu;$sm++){
					$sbm=explode('|',$this->zn->rContent($mnu[0],"$sm",$this->zm));
					$sbmm=explode('/',$sbm[1]);
					(count($sbmm)==1)?$xx=0:$xx=1;
					$c=$this->Admin_model->cek_oto($sbmm[$xx],'c',$userid);
					$e=$this->Admin_model->cek_oto($sbmm[$xx],'e',$userid);
					$v=$this->Admin_model->cek_oto($sbmm[$xx],'v',$userid);
					$p=$this->Admin_model->cek_oto($sbmm[$xx],'p',$userid);
					$d=$this->Admin_model->cek_oto($sbmm[$xx],'d',$userid);
					($c=='Y')? $c_ck="checked='checked'":$c_ck='';
					($e=='Y')? $e_ck="checked='checked'":$e_ck='';
					($v=='Y')? $v_ck="checked='checked'":$v_ck='';
					($p=='Y')? $p_ck="checked='checked'":$p_ck='';
					($d=='Y')? $d_ck="checked='checked'":$d_ck='';
					echo "<tr class='xx'>\n
						  <td class='kotak'>&nbsp;</td>\n
						  <td class='kotak'>".str_repeat('&nbsp;',7).$sbm[0]."</td>\n
						  <td class='kotak' align='center'><input type='checkbox' id='c-".$sbmm[$xx]."' $c_ck ></td>\n
						  <td class='kotak' align='center'><input type='checkbox' id='e-".$sbmm[$xx]."' $e_ck ></td>\n
						  <td class='kotak' align='center'><input type='checkbox' id='v-".$sbmm[$xx]."' $v_ck ></td>\n
						  <td class='kotak' align='center'><input type='checkbox' id='p-".$sbmm[$xx]."' $p_ck ></td>\n
						  <td class='kotak' align='center'><input type='checkbox' id='d-".$sbmm[$xx]."' $d_ck ></td>\n
						  </tr>\n";
				  }
		}
	}
	function useroto_update(){
		$data=array();
		$field=$_POST['idfld'];
		$status=$_POST['stat'];
		($status=='true')?$sts='Y':$sts='N';
		$idmenu=$_POST['idmenu'];
		$uid=$_POST['userid'];
		$data['userid']=$_POST['userid'];
		$data['idmenu']=$_POST['idmenu'];
		$data[$field]=$sts;
		$cekk=$this->Admin_model->field_exists('useroto',"where idmenu='$idmenu' and userid='$uid'","idmenu");
		($cekk!='')?
		$this->Admin_model->upd_data('useroto',"set $field='$sts'","where idmenu='$idmenu' and userid='$uid'"):
		$this->Admin_model->simpan_data('useroto',$data);	
	}
	
	function showlevel(){
		$data=array();$datax=array();$n=1;
		$hasil=$this->Admin_model->show_list('user_level',"where idlevel!='1'");
		foreach ($hasil->result_array() as $rw){
		echo "<tr class='xx' id='".$rw['idlevel']."'>\n
				<td class='kotak' align='center' >$n</td>\n
				<td class='kotak' title='Click for select' id='pilih' abbr='a-".$rw['idlevel']."'>".$rw['nmlevel']."</td>\n
				<td class='kotak xy' align='center' abbr='".$rw['idlevel']."' id='hps' title='click for delete'><b>X</b></td>\n
				</tr>\n";
			$n++;
		}
	}

	function userlevel(){
		$data=array();$datax=array();$n=0;
		$datax['nmlevel']=ucwords($_POST['nmlevel']);
		$this->Admin_model->simpan_data('user_level',$datax);
		$hasil=$this->Admin_model->show_list('user_level',"where idlevel!='1'");
		foreach ($hasil->result_array() as $rw){
			$n++;
		echo "<tr class='xx' id='".$rw['idlevel']."'>\n
				<td class='kotak' align='center' >$n</td>\n
				<td class='kotak' title='Click for select' id='pilih' abbr='a-".$rw['idlevel']."'>".$rw['nmlevel']."</td>\n
				<td class='kotak xy' align='center' abbr='".$rw['idlevel']."' id='hps' title='click for delete'><b>X</b></td>\n
				</tr>\n";
		}
	}
}
?>
