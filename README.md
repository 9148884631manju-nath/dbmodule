<h1>
DbMol  Mysql Database Connect and CURD
</h1>

<h2>Create new Table and Manage </h2>
<pre>
 $membersdb=array(
  "table"=>"membersdb",
  "coloums"=>array(
   "name"=>"varchar(100) Null",
   "mobile"=>"varchar(100) Null",
   "email"=>"varchar(100) Null",
   "address"=>"text Null",
  )
 );
</pre>

<h2>if you add any new colum, it modufies or alter the table automatically </h2>
<pre>
 $membersdb=array(
  "table"=>"membersdb",
  "coloums"=>array(
   "name"=>"varchar(100) Null",
   "mobile"=>"varchar(100) Null",
   "email"=>"varchar(100) Null",
   "address"=>"text Null",
   "createdat"=>"varchar(50) null"
  )
 );
</pre>

<h2>By Creating this object Table Creates automatically</h2>
<pre>
 $members = $dbmol->table_module($membersdb);
</pre>

<h2>By Creating this object Table Creates automatically</h2>
<pre>
 $members = $dbmol->table_module($membersdb);
</pre>

<h2>Insert multi data or single data by checking the record </h2>
<pre>
echo $members->checkAndInsert(
 array(
   "fields"=>"name,email",
   "name"=>"'Manju' and ",
   "mobile"=>"1524"
  ),
  "data exists",
  "Inserted",
  "name,email,mobile",[
  ["Manjunath","email","1524"]
 ]);
</pre>

<h2>To Update Data</h2>
<pre>
echo $members->updateData(
 "email,name",
 "'manjjk@gmail.com','Manjunath'",
 "Error",
 "Updated",
 array(
  "mobile"=>"'1524'"
 )
);
</pre>

<h2>To Delete Data</h2>
<pre>
echo $members->deleteData(
 "Error",
 "Deleted",
 array(
  "mobile"=>"'1524'"
 )
);
</pre>


<h2>View Data in JSON</h2>
<pre>
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
</pre>

<h2>View Data in HTML Format</h2>
<pre>
echo $members->getAllData(
  array(
   "fields"=>"name,mobile,email",
   "name"=>" like '%%'"
  ),
  "html",
  "error_theme.html",
  "success_theme.html",
  "name,mobile,email",
  "Xname,Xmobile,Xemail"
 );
</pre>
