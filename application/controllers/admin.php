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
	function about(){
			$this->load->view('admin/header');
			$this->load->view('admin/about');
			$this->load->view('admin/footer');
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
		 $data=array();
		 $this->Admin_model->hps_data('users',"where userid='".$_POST['userid']."'");
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
		$data=array();
		$this->nama_file('add');
		$data['ac']=$this->Admin_model->is_oto('add','c');
		$data['ae']=$this->Admin_model->is_oto('add','e');
		$data['le']=$this->Admin_model->is_oto('list','e');
		$data['lv']=$this->Admin_model->is_oto('list','v');
		$data['lp']=$this->Admin_model->is_oto('list','p');
		$data['ld']=$this->Admin_model->is_oto('list','d');
		$data['hc']=$this->Admin_model->is_oto('hak','c');
		$data['hv']=$this->Admin_model->is_oto('hak','v');
		//$data=$this->cek_auth();
		$limit=100;
		$this->paginat('userlist','users',$limit);
		//(!$page)? $offset=0:$offset=$page;
		$offset=0;
		$data['userlst']=$this->Admin_model->userlist($limit,$offset);
				$this->load->view('admin/header');
				//$this->Admin_model->is_oto_all($this->menu,$this->load->view('admin/userlist',$data));
				$this->load->view('admin/userlist',$data);
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
		$create_db="CREATE DATABASE IF NOT EXISTS `".$this->zn->rContent("Server","dbname",$this->zc)."`";
		mysql_query($create_db);
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
				//$data['oto']=$this->Admin_model->cek_Auth();
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
		$cr=$this->Admin_model->is_oto('hak','c');
		$vh=$this->Admin_model->is_oto('hak','v');
		($cr=='Y' || $this->session->userdata("userid")=='Superuser')?$bisa='':$bisa='disabled';
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
					$sbmm=explode('|',$sbm[1]);
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
					$sub_sub=$this->zn->Count($sbm[0],$this->zm);
					echo($sub_sub >0)?
						 "<tr class='xx'>\n
						  <td class='kotak'>&nbsp;</td>\n
						  <td class='kotak' colspan='6'>".str_repeat('&nbsp;',7)."&bull;&nbsp;".$sbm[0]."</td>\n":
						 "<tr class='xx'>\n
						  <td class='kotak'>&nbsp;</td>\n
						  <td class='kotak'>".str_repeat('&nbsp;',7)."&bull;&nbsp;".$sbm[0]."</td>\n
						  <td class='kotak' align='center'><input type='checkbox' id='c-".$sbmm[$xx]."' $c_ck $bisa ></td>\n
						  <td class='kotak' align='center'><input type='checkbox' id='e-".$sbmm[$xx]."' $e_ck $bisa  ></td>\n
						  <td class='kotak' align='center'><input type='checkbox' id='v-".$sbmm[$xx]."' $v_ck $bisa  ></td>\n
						  <td class='kotak' align='center'><input type='checkbox' id='p-".$sbmm[$xx]."' $p_ck $bisa  ></td>\n
						  <td class='kotak' align='center'><input type='checkbox' id='d-".$sbmm[$xx]."' $d_ck $bisa  ></td>\n
						  </tr>\n";
						  for ($ss=1;$ss<=$sub_sub;$ss++){
							$ssmn=explode('|',$this->zn->rContent($sbm[0],"$ss",$this->zm));
							$sbmm_sub=explode('|',$ssmn[1]);
							(count($sbmm_sub)==1)?$xx=0:$xx=1;
							$c_sub=$this->Admin_model->cek_oto($sbmm_sub[$xx],'c',$userid);
							$e_sub=$this->Admin_model->cek_oto($sbmm_sub[$xx],'e',$userid);
							$v_sub=$this->Admin_model->cek_oto($sbmm_sub[$xx],'v',$userid);
							$p_sub=$this->Admin_model->cek_oto($sbmm_sub[$xx],'p',$userid);
							$d_sub=$this->Admin_model->cek_oto($sbmm_sub[$xx],'d',$userid);
							($c_sub=='Y')? $c_ck_sub="checked='checked'":$c_ck_sub='';
							($e_sub=='Y')? $e_ck_sub="checked='checked'":$e_ck_sub='';
							($v_sub=='Y')? $v_ck_sub="checked='checked'":$v_ck_sub='';
							($p_sub=='Y')? $p_ck_sub="checked='checked'":$p_ck_sub='';
							($d_sub=='Y')? $d_ck_sub="checked='checked'":$d_ck_sub='';
							echo "<tr class='xx'>\n
								  <td class='kotak'>&nbsp;</td>\n
								  <td class='kotak'>".str_repeat('&nbsp;',12)."&rArr;&nbsp;".$ssmn[0]."</td>\n
								  <td class='kotak' align='center'><input type='checkbox' id='c-".$ssmn[1]."' $c_ck_sub $bisa  ></td>\n
								  <td class='kotak' align='center'><input type='checkbox' id='e-".$ssmn[1]."' $e_ck_sub $bisa  ></td>\n
								  <td class='kotak' align='center'><input type='checkbox' id='v-".$ssmn[1]."' $v_ck_sub $bisa  ></td>\n
								  <td class='kotak' align='center'><input type='checkbox' id='p-".$ssmn[1]."' $p_ck_sub $bisa  ></td>\n
								  <td class='kotak' align='center'><input type='checkbox' id='d-".$ssmn[1]."' $d_ck_sub $bisa  ></td>\n
								  </tr>\n";
						  }
				  }
		}
	}
	function useroto_update(){
		$data=array();
		$field=$_POST['idfld'];
		$status=$_POST['stat'];
		($status=='true')?$sts='Y':$sts='N';
		//$idmenu=str_replace("__","/",$_POST['idmenu']);
		$idmenu=$_POST['idmenu'];
		$uid=$_POST['userid'];
		$data['userid']=$_POST['userid'];
		//$data['idmenu']=str_replace("__","/",$_POST['idmenu']);
		$data['idmenu']=$_POST['idmenu'];
		$data[$field]=$sts;
		$cekk=$this->Admin_model->field_exists('useroto',"where idmenu='$idmenu' and userid='$uid'","idmenu");
		($cekk!='')?
		$this->Admin_model->upd_data('useroto',"set $field='$sts'","where idmenu='$idmenu' and userid='$uid'"):
		$this->Admin_model->simpan_data('useroto',$data);
		echo $cekk."//".$_POST['idmenu'];	
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
	function dropdown_usr(){
		echo dropdown('users','userid','username',"where levelid<>'1' order by username",$this->session->userdata('userid'));
	}
}
?>
