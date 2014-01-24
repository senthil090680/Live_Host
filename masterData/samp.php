<script type="text/javascript">
$(document).ready(function(){
$(function(){
    $('input[type=checkbox]').each(function(){

        if($(this).attr('checked') && $(this).attr('checked')=='checked'){
        $(this).attr('checked', true);
        }else{
        $(this).attr('checked', false);
        }

    })

})	
	
   $('input.check').click(function(){
     if($(this).is(':checked'))
     {
         $id = $(this).attr("id");
         $.post("handle.php",{action:"checked",id:$id},function(data){
          alert("Peoduct is set to display...");
         });
     }
     else
     {
       alert("unchecked");
        $id = $(this).attr("id");
         $.post("handle.php",{action:"unchecked",id:$id},function(data){
          alert("Peoduct is un-set to display...");
         });
     }

       });

    });
</script>
    <?php
	
	
	
	 include('../include/config.php');
        $dbqry = mysql_query("select * from  product");
		?>
        <form method="post" action=""> 
        
        <table>
        <tr>
		<td width="50">KD Category*
	<!-- For Multiple Effective Date -->
	<input type="hidden" name="update_date" value="" autocomplete="off" id="hdnData" readonly></td>
    <td width="121">
    <select name="Kd_Category" class="Kd_Category" id="Kd_Category"  autocomplete="off"  value="" onChange="ajaxcategory();">
			<option value="">--- Select ---</option>
			<?php 
			$list=mysql_query("select * from  kd_category"); 
			while($row=mysql_fetch_assoc($list)){
			?>
			<option value='<?php echo $row['kd_category']; ?>'<?php if($row['kd_category']==$_GET['data']){ echo 'selected' ; }?>
			><?php echo $row['kd_category']; ?></option>
			<?php 
			// End while loop. 
			} 
			?>
			</select>
    </td>
		</tr>
        </table>
		<?php

        echo "<table width='50%', border='2'>  
        <tr>
        <th>Product</th>
		<th>UOM</th>
        <th>Select</th>
       
        </tr>";
           
        if($dbqry)
        {
            while($row = mysql_fetch_array($dbqry))
            {
                echo "<tr>";
                echo "<td>" . $row['Product_description1'] ."</td>";
				echo "<td>" . $row['UOM1'] ."</td>";
                ?>
                <td align="center">

                     <!--  <input type='checkbox' name='approval' value='approval'   id ="<? echo $cid; ?>" class="check"/>-->
                       <input type='checkbox' name='checkbox' value='checkbox' <?php echo $row["checkbox"]?"checked=\"checked\"":'';?>  id ="<? echo $cid; ?>" class="check"/>

                </td>
                </tr>
                <?

            }
			 echo "<td colspan='10'><input type='submit' name='submit' value='save' /></td>";
            echo "</table>";
			echo "</form>";
		
            echo '<br/>';
         

        }
        else
        {
            die(mysql_error());
        }

    ?>


  <?php
      include('../include/config.php');
      $action = $_POST['action'];
      $id = $_POST['id'];
      //echo $action;
      if($action == "checked")
      {
         $query = "update job_category set approval=1 where c_id=$id";
     $result = mysql_query($query);
     if(!$result)
     {
       echo die(mysql_error());
     }
      }
      else if($action == "unchecked")
       {
         $query = "update job_category set approval=0 where c_id=$id";
     $result = mysql_query($query);
     if(!$result)
     {
        echo die(mysql_error());
      }
    }
 ?>