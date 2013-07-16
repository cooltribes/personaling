 
 <nav class="  ">
        <ul class="nav">
<?php foreach($categorias as $categoria){ ?>
          <li>
            <label>
              <input type="checkbox" value="<?php echo $categoria->id; ?>" id="pcasion<?php echo $categoria->id;?>" onclick="js:refresh()">
              <?php echo $categoria->nombre; ?>
              </label>
          </li>	
<?php } ?>
        </ul>
      </nav>