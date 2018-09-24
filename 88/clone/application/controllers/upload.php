
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends User_Access_Controller 
{
	private $limit=30;
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','csv'));
		$this->load->helper('form');
		$this->load->model('setting_model','setting_model',TRUE);
		$this->load->model('customer_model','customer_model',TRUE);
		$this->load->model('file_upload_model','file_upload_model',TRUE);
	}
	 
	function index()
	{	
		$data['title']=$this->access->get_site_name();
		$data['site_name']=$this->access->get_sys_name();	
		$data['quote']=$this->access->get_sys_motto();
		$this->load->view('template/header',$data);
		$data['is_admin']=$this->access->get_admin();
		$this->load->view('template/sidelink',$data);
		$this->load->view('upload/index',$data);
		$this->load->view('template/footer');
	}

	public function uploadtoserver()
    {
		// 5 minutes execution time
		@set_time_limit(5 * 60);
		// Uncomment this one to fake upload time
		// usleep(5000);

		// Settings

		$targetDir = FCPATH . "uploads";
		//$targetDir = 'uploads';
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds


		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

		// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		$fileSize=filesize($filePath);

		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


		// Remove old temp files	
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}

			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}.part") {
					continue;
				}

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}	


		// Open temp file
		if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {	
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off 
			rename("{$filePath}.part", $filePath);	 
		}

		$file=array(
				'name'=>$fileName,
				'size'=>$fileSize,
				'createdate'=>date('Y-m-d H:i:s',now()),
				'createby'=>$this->access->get_user_id()
		);

		$file_id=$this->file_upload_model->insert($file);

		$result = $this->csv->parse_file($fileName);

		$i=0;
		foreach ($result as $result_row){
			$i++;
			$data=array(
				'username'=>$result_row['username'],
				'first_name'=>$result_row['first_name'],
				'last_name'=>$result_row['last_name'],
				'level'=>$result_row['level'],
				'phone'=>$result_row['phone'],
				'email'=>$result_row['email'],
				'call_status'=>$result_row['call_status'],
				'wechat_qq'=>$result_row['wechat_qq'],
				'wechat_id'=>$result_row['wechat_id'],
				'qq_id'=>$result_row['qq_id'],
				'remark'=>$result_row['remark'],
				'notification'=>$result_row['notification'],
				'promoter'=>$result_row['promoter'],
				'date'=>$result_row['date'],
				'sign_up_deposit'=>$result_row['sign_up_deposit'],
				'category'=>$result_row['category'],
				'file_id'=>$file_id
			);
				
			$this->customer_model->insert($data);
		}

		$file=array(
			'total_row'=>$i
		);

		$file_id=$this->file_upload_model->update($file_id,$file);
		// Return Success JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }
}

/* End of file announcement.php */
/* Location: ./application/controllers/announcement.php */