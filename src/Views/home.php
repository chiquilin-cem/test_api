<?php view('header', $data); ?>
<section class="hero">
    <div class="hero-body">
        <div class="container">
        <?php
            if ( 'post' === strtolower($_SERVER['REQUEST_METHOD'])) {
        ?>
            <h2>
                <?php 
                    $data = file_get_contents('https://almacen3.lndo.site/api.php');
                    $data2 = json_decode($data);
                    echo '<table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Sku</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Costo</th>
                        <th scope="col">Categoria Nombre</th>
                        <th scope="col">Categoria Atributo</th>
                        <th scope="col">Precio</th>                       
                      </tr>
                    <thead><tbody>';
                    foreach ($data2 as $datadet) {
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo '<tr>
                          <th scope="row">'.$datadet->id.'</th>
                          <td>'.$datadet->nombre.'</td>
                          <td>'.$datadet->sku.'</td>
                          <td>'.$datadet->marca.'</td>
                          <td>$'.money_format('%.2n', $datadet->costo).'</td>
                          <td>'.$datadet->categoria_nombre.'</td>
                          <td>'.$datadet->categoria_atributo.'</td>
                          <td>$'.money_format('%.2n', $datadet->precio).'</td>
                        </tr>';
                    }
                    echo "</tbody> </thead>";
                    echo "</table>";
                ?>
            </h2>
            <?php
            } else {
            ?>
            <form method="post">
                <input type="submit" value="Obtener todos los productos via POST">
            </form>
            <?php
            }?>
        </div>
    </div>
</section>
<?php view('footer'); ?>