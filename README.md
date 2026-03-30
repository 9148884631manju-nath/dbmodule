# dbmodule
Mysql Database Connect and manage data 

# create a table and manage
<pre>
  require_once "dbmodule.php";
  $dbmol=new DbMol("","dbcon.json","newdb");
  
  $membersdb=array(
   "table"=>"members",
   "coloums"=>array(
    "name"=>"varchar(100) Null",
    "mobile"=>"varchar(100) Null",
    "email"=>"varchar(100) Null",
    "address"=>"text Null",
   )
  );
  $members = $dbmol->table_module($membersdb);

  //CHECK AND INSERT DATA
  echo $members->checkAndInsert(
   array(
    "fields"=>"name,email",
    "name"=>"'User' and ",
    "mobile"=>"00000"
   ),
   "data exists",
   "Inserted",
   "name,email,mobile",[
   ["Manjunath","email@web.com","00000"]
  ]);

  //Insert Method One
  echo $members->insertData("name,mobile","'Manjunath','12345'");

  //Insert Method Two by Data Array
  echo $members->insertData("name,mobile",["Manjunath","12345"]);

  //Insert Multi Data
  echo $members->insertData("name,mobile",[ 
    ["Manjunath","12345"], 
    ["Another Name","45785"]
  ]);  
  
