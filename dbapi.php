<?php require_once "dbmodule.php";

$dbmol=new DbMol("","dbcon.json","newdb");

$membersdb=array(
 "table"=>"membersdb",
 "coloums"=>array(
  "name"=>"varchar(100) Null",
  "mobile"=>"varchar(100) Null",
  "email"=>"varchar(100) Null",
  "address"=>"text Null",
  "accessdate"=>"varchar(30) Null",
  "aa"=>"varchar(30) Null",
  "bb"=>"varchar(30) Null",
 )
);
$members = $dbmol->table_module($membersdb);

$categorydb=array(
 "table"=>"categories",
 "coloums"=>array(
  "catid"=>"varchar(100) Null",
  "catname"=>"varchar(100) Null",
 )
);
$categories = $dbmol->table_module($categorydb);

$productdb=array(
 "table"=>"products",
 "coloums"=>array(
  "categories_id"=>"varchar(100) Null",
  "product_name"=>"varchar(100) Null",
  "product_price"=>"varchar(100) Null",
 )
);
$products = $dbmol->table_module($productdb);

//Get All Data

echo $members->getAllData(
 array(
  "fields"=>"name,mobile,email",
  "name"=>" like '%%'"
 ),
 "json",
 "error_theme.html",
 "success_theme.html",
 "name,mobile,email",
 "Xname,Xmobile,Xemail"
);

//Delete Data
/*
echo $members->deleteData(
 "Error",
 "Deleted",
 array(
  "mobile"=>"'45785'"
 )
);
*/

//Update Data
/*
echo $members->updateData(
 "email,name",
 "'manjjk@gmail.com','Manjunath Nath K'",
 "Error",
 "Updated",
 array(
  "mobile"=>"'1524'"
 )
);
*/

//Check and Insert Data
/*
echo $members->checkAndInsert(
 array(
  "fields"=>"name,email",
  "name"=>"'Manjunath' and ",
  "mobile"=>"1524"
 ),
 "data exists",
 "Inserted",
 "name,email,mobile",[
 ["Manjunath","email","1524"]
]);
*/

//String Data
//echo $members->insertData("name,mobile","'Manjunath','12345'");
//echo "<hr/>";

//Single Data Array
//echo $members->insertData("name,mobile",["Manjunath","12345"]);
//echo "<hr/>";

//Multi Data Array
//echo $members->insertData("name,mobile",[ ["Manjunath","12345"], ["Omprakash","45785"]]);

?>