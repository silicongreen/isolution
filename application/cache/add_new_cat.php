<?php if(!class_exists('raintpl')){exit;}?><div id="add_and_del_cat"></div><form id="add_cat"method="POST" action="<?php echo $base_url;?>index.php?c=admin&a=insert_new_cat">  <label>Add Category:</label>   <input type="text" name="ncategory"><br>  <input type="submit" value="Add">  </form><script>	af("add_cat","main-container");</script><form id="del_cat"method="POST" action="<?php echo $base_url;?>index.php?c=admin&a=del_cat">  <label>Delete Category:</label> 	<select name="ncategory">		<?php $counter1=-1; if( isset($cat) && is_array($cat) && sizeof($cat) ) foreach( $cat as $key1 => $value1 ){ $counter1++; ?>			<option value="<?php echo $value1;?>"><?php echo $value1;?>						</option>		<?php } ?>	</select>  <input type="submit" value="Delete">  </form><script>	af("del_cat","main-container");</script>