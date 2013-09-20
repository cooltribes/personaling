 <form id="form_ocasiones">
 <nav class="  ">
        <ul class="nav">
<?php foreach($categorias as $categoria){ ?>
	<?php if ($categoria->hasLooks()){ ?>
          <li>
            <label>
              <input type="checkbox" name="check_ocasiones[]" value="<?php echo $categoria->id; ?>" id="check_ocasion<?php echo $categoria->id;?>" onclick="js:refresh()" class="check_ocasiones">
              <?php echo $categoria->nombre; ?>
              </label>
          </li>	
<?php } ?>
<?php } ?>
        </ul>
      </nav>
</form>      