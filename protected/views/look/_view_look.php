        <tr>
            <td><input name="check" type="checkbox" value=""></td>
            <td width="20%"><strong> <span class="CAPS"><?php echo $data->title; ?></span></strong><br/>
                <strong>ID</strong>: <?php echo $data->id; ?><br/>
                <strong>Nro. Items</strong>: <?php echo $data->countItems(); ?></td>
            <td><strong>P.S.</strong>: <?php echo $data->user->profile->first_name; ?><br/>
                <strong>Marcas</strong>: Mango, Suite Blanco, Aldo, Accessorize y Desigual </td>
            <td>650,00</td>
            <td>10</td>
            <td>6500,00</td>
            <td>Por aprobar</td>
            <td><?php echo $data->created_on; ?></td>
            <td> Finaliza en: 17 Mayo 2013
                <div class="progress margin_top_small  progress-danger">
                    <div class="bar" style="width: 70%;"></div>
                </div></td>
            <td><a href="#myModal" role="button" class="btn btn-mini" data-toggle="modal"><i class="icon-eye-open"></i></a></td>
        </tr> 