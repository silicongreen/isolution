<?php if(!class_exists('raintpl')){exit;}?><div class="container-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="contact-form">
                    <h3>Enter Product Details</h3>
                    <form id="product-upload-form" name="product-upload-form" method="post" action="index.php?c=product&a=product_upload_post">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input name="title" class="form-control" placeholder="Title" required="" type="text">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" class="form-control" rows="8" placeholder="Description" required=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="rprice">Regular Price:</label>
                            <input name="rprice" class="form-control" placeholder="Regular Price" required="" type="number">
                        </div>
                        <div class="form-group">
                            <label for="sprice">Sale Price:</label>
                            <input name="sprice" class="form-control" placeholder="Sale Price" required="" type="number">
                        </div>
                        <div class="form-group">
                            <label for="price-unit">Price Unit:</label>
                            <select name="price-unit" id="price-unit">
                                <option value="Dollar">$</option>
                                <option value="Euro">@</option>
                                <option value="Taka">tk</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Category">Category:</label>
                            <select name="category" id="category">
                                <?php $counter1=-1; if( isset($category) && is_array($category) && sizeof($category) ) foreach( $category as $key1 => $value1 ){ $counter1++; ?>
                                    <option value="<?php echo $value1;?>"><?php echo $value1;?>
                                    
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Sub-Category">Sub-Category:</label>
                            <select name="Sub-Category" id="Sub-Category">
                                <option value="Logo">Logo</option>
                                <option value="Wordpress">Wordpress</option>
                                <option value="html">html</option>
                                <option value="mobile-apps">Mobile Apps</option>
                                <option value="software">software</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    af("product-upload-form","main-container");
</script>