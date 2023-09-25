<?php
    class ControllerToolReset extends Controller {
        // public function index(){
        //     $this->load->model('tool/backup');
        //     try{
        //         $this->restoreDatabase();
        //         $this->restoreImage();
        //     }catch(Exception $e){
        //         error_log($e);
        //     }
        // }
        
        // public function restoreDatabase(){
        //     $content = false;
        //     $path = '../';
        //     $path_files = scandir($path);
        //     $sql_backup_file_name = 'fcs_retail_template.sql';
            
        //     if(in_array($sql_backup_file_name,$path_files)){
        //         $content = file_get_contents($path.$sql_backup_file_name);
        //         $this->model_tool_backup->restore($content);
        //         echo "Reset Done!<br>";
        //     }
        // }
        
        // public function restoreImage(){
        //     $path = '../image_ori';
        //     $destination = '../image';
            
        //     $this->removeDir($destination);
        //     $this->copy_directory($path,$destination,1);
        // }
        
        // function removeDir($dirname) {
        //     if (is_dir($dirname)) {
        //         $dir = new RecursiveDirectoryIterator($dirname, RecursiveDirectoryIterator::SKIP_DOTS);
        //         foreach (new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST) as $object) {
        //             if ($object->isFile()) {
        //                 unlink($object);
        //             } elseif($object->isDir()) {
        //                 rmdir($object);
        //             } else {
        //                 throw new Exception('Unknown object type: '. $object->getFileName());
        //             }
        //         }
        //         rmdir($dirname); // Now remove myfolder
        //     } else {
        //         throw new Exception('This is not a directory');
        //     }
        // }
        
        //  public function copy_directory($directory, $destination,$first_level = 0) {
        //      if($first_level == 0){
        //         $destination = $destination . basename($directory);
        //      }
             
        //         # The directory will be created
        //         if (!file_exists($destination)) {
        //          if (!mkdir($destination)) {
        //              return false;
        //          }
        //         }
                
            
        //      $directory_list = @scandir($directory);
             
        //      # Directory scanning
        //      if (!$directory_list) {
        //          return false;
        //      }
        //      foreach ($directory_list as $item_name) {
        //          $item = $directory . DIRECTORY_SEPARATOR . $item_name;
                 
        //          if ($item_name == '.' || $item_name == '..') {
        //              continue;
        //          }
        //          if (filetype($item) == 'dir') {
        //              $this->copy_directory($item, $destination . DIRECTORY_SEPARATOR,0);
        //          } else {
        //              if (!copy($item, $destination . DIRECTORY_SEPARATOR . $item_name)) {
        //                  return false;
        //              }
        //          }
        //      }
        //      return true;
        //  }
    }
?>