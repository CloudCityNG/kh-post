<link type="text/css" rel="stylesheet" href="application/login/style.css" />
<link type="text/css" rel="stylesheet" href="application/login/log.css" />
     <table align="center" border="0">
			<tr>
                <td width="20%" valign="top" align="center">
                   <form action="db_upload_profile_pic.php" method="post">
                       <table border="0" width="100%" height="20%">
            		    <tr>
            				<td><input type="image" <img src="application/login/images/index.jpg" width="155" height="185" /></td>
                   		</tr>
                    	<td align="center" height="10px">
                         <button name="button" id="button" onClick="return check()"  style="white-space:pre"/><p class="text">Change Picture</p></button></td>
            		</table>
            		</form>           
                 </td>
             
            <td width="70%" valign="top">                               
			    <table border="0" align="center" height="100%">
            		<form action="#" method="post">
            	    	  <tr>
                     		 <td width="30%" height="30px">                     
                        		Name
                        	</td>                       
            				<td height="30px">                       
                        		<label for="name" id="lblname" name="lblname" ></label>                      
                        	</td>                         
           				</tr>
            
           			 	<tr>
                      		<td width="30%" height="35px" >                        
                         		Company
                         	</td>                         
           				 	<td height="35px" >                        
		                         <label for="company" id="lblcompany" name="lblcompany"></label>                      
	                        </td>
            			</tr>
               
            			<tr>
                    		<td width="30%" height="30px">
		                        Address
        	                </td>
            				<td height="35px">      
		                        <label for="address" id="lbladdress" name="lbladdress"></label>                     
		                     </td>
        	    		</tr>            
            			<tr>
                    		<td width="30%" height="30px">                       
		                        Mail Address
        	                </td>
            				<td height="35px" width="70%">                       
		                        <label for="email" id="lblemail" name="lblemail"> </label>                      
        	                </td>                                                                          
            			</tr>                                                     
	          
           </td>
            <td width="70%" valign="top">                               
			    <table border="0" align="center" height="50%">
            		<TR>
                            <td align="center" height="20%">
                            <button name="button" onClick="return check()" style="white-space:pre"/><p class="textedit">Edit</font></p></button></td>
           				</tr>
            
           			                                                     
	            </form>                   
            </table>
           </td>