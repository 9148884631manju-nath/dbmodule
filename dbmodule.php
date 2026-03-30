<?php
/*
DbMol v1
Manage Mysql DB tables and data
PHP ver 7.4 above
code designed and developed by Manjunath K, 9343945143
2026 March
*/
class DbMol{
 public $type;
 public $dbfile;
 public $database;
 public function __construct($type,$dbfile,$database){
   $this->type = $type;
   $this->dbfile = $dbfile;
   $this->database = $database;   
 }
 public function con(){
  $t = $this->type;
   $f = $this->dbfile;
   $db = $this->database;
  if(file_exists($f)){
  $read_file = file_get_contents($f); 
  $rf = json_decode($read_file);
   if(isset($rf->$db)){
     $server = $rf->$db->server;
     $username = $rf->$db->username;
     $password = $rf->$db->password;
     $database = $rf->$db->database;
     switch($t){
      default:     
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      try{
       $con=mysqli_connect($server,$username,$password);  
       try{
        $res = mysqli_select_db($con,$database);
        $res=mysqli_connect($server,$username,$password,$database); 
       }
       catch(\Exception $err){
        $res=$err->getMessage();  echo $res; exit();
       }
      }
      catch (\Exception $err)
      {
       $res=$err->getMessage(); echo $res; exit();
      }
      break;
     }
   }
   else{
    $res="InvalidDbNameValueSetInDbJsonConfig";
   }
  }
  else{
   $res="DbFileNotFound";
  }
  return $res;
 }
 public function table_module($table){
  $res=new class($this, $table){
   private $parent;
   private $table;
   private $err;
    public function __construct($parent, $table) {
        $this->parent = $parent;
        $this->table = $table;
        $cehckTasble = $this->parent->checktable($table['table'],$table['coloums']);
        if($cehckTasble===true){  } else{
         if(isset($cehckTasble->num_rows) > 0 ){ } 
         else{ $this->err=$cehckTasble; }
        }
    }
   public function getAllData($checks,$type,$err,$suc,$fields,$afields){
    $table=$this->table;$cxs="";$ccks="";$rdat=array();
    foreach($checks as $kk=>$vv){ if($kk=="fields"){$ccks=$vv;} else{$cxs.=$kk." ".$vv."";}}
    if($cxs==""){$cxs="";}else{$cxs=" WHERE ".$cxs;}
    $qry = "SELECT ".$ccks." FROM ".$table['table']." ".$cxs;
    try{
     $dat = mysqli_query($this->parent->con(),$qry);
     while($dax = mysqli_fetch_assoc($dat)){
      $rdat[]=$dax;
     }
    }
    catch(\Exception $ex){
     $rdat = array("error"=>$ex->getMessage(),"query"=>$qry);
    }
     switch($type)
     {
      case "json":
       return json_encode($rdat);
       break;
      case "html":
       if(isset($rdat['error'])){
        $etheme = file_get_contents($err);
        return str_replace("Xerror",$rdat['error'],$etheme);
       }else{
        $nvals=array();$ncon="";
        $stheme = file_get_contents($suc); 
        $fldx = explode(",",$fields); $vldx = explode(",",$afields);
        for($i=0;$i<count($rdat);$i+=1)
         {
          foreach($rdat[$i] as $kk=>$vv){
           if(in_array($kk,$fldx)){
            $nvals[$i][]=$vv;
           }else{
            $nvals[$i][]="";
           }
          }
          $ncon.=str_replace($vldx,$nvals[$i],$stheme);
         }
         return $ncon;
       }
      break;
      default;
       if(isset($rdat['error'])){
        return $rdat;
       }else{
         return $rdat;
       }
      break;
     }
   }
   public function checkAndInsert($checks,$err,$suc,$cols,$data){
     $rex="";
      $table=$this->table;  $cxs="";$ccks="";
      foreach($checks as $kk=>$vv){ if($kk=="fields"){$ccks=$vv;} else{$cxs.=$kk."=".$vv."";}}
     $checks = "SELECT ".$ccks." FROM ".$table['table']." WHERE ".$cxs;
     //var_dump($checks);
     try{
       $runq = mysqli_query($this->parent->con(),$checks);
       $runf = mysqli_fetch_assoc($runq);
       if(is_array($runf)){
         return $err;
       }else{
         if($checks==$err){
          return $checks;
         }else{
           return $this->insertData($cols,$data);
         }
       }
       //return var_dump($runf);

     }catch(\Exception $ex){
      return $ex->getMessage();
     }    
   }
   public function deleteData($err,$suc,$where){
     $rex="";
      $table=$this->table;  $cxs="";$datx="";      
      foreach($where as $kk=>$vv){$cxs.=$kk."=".$vv."";}
     $checks = "DELETE FROM ".$table['table']." WHERE ".$cxs;
     //var_dump($checks);
     try{
       $runq = mysqli_query($this->parent->con(),$checks);
       if(is_array($runq)){
         return $err;
       }else{
         return $suc;
       }
       //return var_dump($runf);

     }catch(\Exception $ex){
      return $ex->getMessage();
     }    
   }
   public function updateData($fields,$data,$err,$suc,$where){
     $rex="";
      $table=$this->table;  $cxs="";$datx="";
      $fieldx = explode(',',$fields);$datax = explode(',',$data);
      for($i=0;$i<count($fieldx);$i+=1){
       $datx.=$fieldx[$i]."=".$datax[$i].", ";
      }
      foreach($where as $kk=>$vv){$cxs.=$kk."=".$vv."";}
     $checks = "UPDATE ".$table['table']." SET ".substr($datx,0,-2)."  WHERE ".$cxs;
     //var_dump($checks);
     try{
       $runq = mysqli_query($this->parent->con(),$checks);
       if(is_array($runq)){
         return $err;
       }else{
         return $suc;
       }
       //return var_dump($runf);

     }catch(\Exception $ex){
      return $ex->getMessage();
     }    
   }
   public function insertData($cols,$data){
    $rex="";$dxa="";$vls="";
    $table=$this->table;
    if(is_array($data)){
      for($i=0;$i<count($data);$i+=1){
       if(is_array($data[$i])){
        $dva[$i]="";
        for($u=0;$u<count($data[$i]);$u+=1){
         $dva[$i].="'".$data[$i][$u]."', ";
        }
        $vls.="(".substr($dva[$i],0,-2)."),";
       }else{
        $dxa.="'".$data[$i]."', ";
        $vls="(".substr($dxa,0,-2)."),";
       }
       
      }
      $vals="VALUES".substr($vls,0,-1);
    }else
    {
     $vals="VALUES(".$data.")";
    }
    $rex="INSERT INTO ".$table['table']."(".$cols.") ".$vals;
    try{
     $rex = mysqli_query($this->parent->con(),$rex);
     return "Inserted";
    }catch(\Exception $ex){
     return $ex.getMessage();
    }
    return $rex;
   }
  };
  return $res;
 }

 public function checktable($table,$cols){
   $con=$this->con();
   $query = "SHOW TABLES FROM ".$this->database;
   try{
     $res=mysqli_query($con,$query); 
     $nrs=$res->num_rows;
     $allt = array(); $alltx = array();
     while($altx = mysqli_fetch_array($res)){ $allt[]=$altx;} for($x=0;$x<count($allt);$x+=1){$alltx[$x]=$allt[$x][0];}
     if(in_array($table,$alltx)){      
      $tcols=array();$tkcols=array();
       if(is_array($cols)){
        $i=0;
         foreach($cols as $kk=>$vv){
          $tkcols[$i]=$kk;
          $tcols[$i]['Field']=$kk;
          $exp=explode(" ",$vv); 
          $tcols[$i]['Type'] = $exp[0];
          $tcols[$i]['Null'] = isset($exp[1]) ? $exp[1] : "";
          $tcols[$i]['Key'] = isset($exp[2]) ? $exp[2] : "";;
          $tcols[$i]['Default'] = isset($exp[3]) ? $exp[3] : "";;
          $tcols[$i]['Extra'] = isset($exp[4]) ? $exp[4] : "";;
          $i+=1;
         }
       }
       $c_query = "DESCRIBE ".$table;
       try{
        $cres = mysqli_query($con,$c_query);
        if(isset($cres->num_rows)>0){
           $ecol=array();
           while($row = mysqli_fetch_assoc($cres)){
            if($row['Field']=="id"){}else{
            $ecol[]=$row;
            }
           }
           //var_dump($ecol);
           //var_dump($tcols);
           for($i=0;$i<count($tcols);$i+=1)
           {
            if(isset($ecol[$i]['Field']) and in_array($ecol[$i]['Field'],$tkcols)){
              $altq="";
            }
            else{
             $altq.="Add ".$tcols[$i]['Field']." ".$tcols[$i]['Type']." ".$tcols[$i]['Null']." ".$tcols[$i]['Key']." ".$tcols[$i]['Default']." ".$tcols[$i]['Extra']." After ".$tcols[$i-1]['Field'].", ";
            }
           }
           $altqs =  "Alter Table ".$table." ".substr($altq,0,-2);
           try{
             $res = mysqli_query($con,$altqs);
           }
           catch(\Exception $ex)
           {
            $res = $ex->getMessage()." ".$altqs;
           }
        }else{
         
        }
       }
       catch(\Exception $ex){
        $res = $ex->getMessage();
       }
      //$res=$tcols;
     }else{
      
      try{
       $tcols="";
       if(is_array($cols)){
         foreach($cols as $kk=>$vv){
          $tcols.=$kk." ".$vv.", ";
         }
       }else{
         $tcols="";
       }
       $res = mysqli_query($con,"CREATE TABLE IF NOT EXISTS ".$table." ( id  bigint(20) NOT NULL AUTO_INCREMENT, ".$tcols." PRIMARY KEY(id) )");
      }
      catch(\Exception $ex)
      {
       $res = $ex->getMessage();
      }
     }
   }
   catch(\Exception $ex){
    $res = $ex->getMessage();
   }
   return $res;
 }
 
 public function __destruct(){
   //echo "<hr/>end";
 }
}

?>