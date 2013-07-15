 <nav class="  ">
        <ul class="nav">
<?php foreach($categorias as $categoria){ ?>
          <li>
            <label>
              <input type="checkbox">
              <?php echo $categoria->nombre; ?>
              </label>
          </li>	
<?php } ?>
        </ul>
      </nav>