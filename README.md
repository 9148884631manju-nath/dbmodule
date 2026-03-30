# dbmodule
Mysql Database Connect and manage data 

# create a table and manage
<pre>
  require_once "dbmodule.php";
  $dbmol=new DbMol("","dbcon.json","newdb");

  //CONFIGURE TABLE
  $membersdb=array(
   "table"=>"members",
   "coloums"=>array(
    "name"=>"varchar(100) Null",
    "mobile"=>"varchar(100) Null",
    "email"=>"varchar(100) Null",
    "address"=>"text Null",
   )
  );

  //CALL THE TABLE - CREATES TABLE AUTOMATICALLY (if you add new colum, it alter the table by itself)
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

  //Delete Data
  echo $members->deleteData(
   "Error",
   "Deleted",
   array(
    "mobile"=>"'45785'"
   )
  );

  //Update Data
  echo $members->updateData(
   "email,name",
   "'manjjk@gmail.com','Manjunath Nath K'",
   "Error",
   "Updated",
   array(
    "mobile"=>"'1524'"
   )
  );
  
  //Get All Data
  echo $members->getAllData(
   array(
    "fields"=>"name,mobile,email",
    "name"=>" like '%%'"
   ),
   "json", //it prints the json
   "error_theme.html",
   "success_theme.html",
   "name,mobile,email",
   "Xname,Xmobile,Xemail"
  );

  // FOR IN HTML FORMAT USE BELOWs
  echo $members->getAllData(
   array(
    "fields"=>"name,mobile,email",
    "name"=>" like '%%'"
   ),
   "html", //it prints the html format by calling the html theme
   "error_theme.html",
   "success_theme.html",
   "name,mobile,email",
   "Xname,Xmobile,Xemail"
  );
  
