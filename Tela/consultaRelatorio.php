<?php
include_once '../Base/requerLogin.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <?php
        include_once '../Controle/relatorio_mensalPDO.php';
        include_once '../Modelo/Relatorio_mensal.php';
        include_once '../Modelo/Movimento.php';
        include_once '../Controle/movimentoPDO.php';
        $relatorioPDO = new Relatorio_mensalPDO();
        $movimentoPDO = new MovimentoPDO();
        include_once '../Base/header.php';
        ?>
    <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <main>
            <div class="row">
                <div class=" col s10  offset-l1">
                    <h4 class="textoCorPadrao2 center">Ralatórios Mensais</h4>
                    <div class="row">
                        <form action="./consultaRelatorio.php" method="post" name="relatorio" id="relatorio" class="col s12">
                            <div class="row">
                                <div class="input-field col s6">
                                    <select name="id_relatorio" >
                                        <?php
                                        $relatorioPDO = new Relatorio_mensalPDO();
                                        $stmt = $relatorioPDO->selectRelatorio_mensal();
                                        while ($linha = $stmt->fetch()) {
                                            $relatorio = new relatorio_mensal($linha);
                                            if ($relatorio->getMes() != "Primeiro") {
                                                echo "<option value='" . $relatorio->getId() . "'>" . $relatorio->getMes() . " " . $relatorio->getAno() . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    <label for="id_relatorio">Mês</label>
                                </div>
                                <div class="col s4 input-field offset-s2">
                                    <button class="btn green lighten-1 right" type="submit">Pesquisar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <?php
                        if (isset($_POST['id_relatorio'])) {
                            $movimentoPDO = new MovimentoPDO();
                            $stmt = $movimentoPDO->selectMovimentoId_mes($_POST['id_relatorio']);
                            if ($stmt) {
                                ?>
                                <table class="bordered striped col s12"><?php
                                    $atual = $relatorioPDO->selectRelatorio_mensalId($_POST['id_relatorio']);
                                    $atual = new relatorio_mensal($atual->fetch());
                                    echo "<h5>Relatorio: " . $atual->getMes() . " " . $atual->getAno() . "</h5>"
                                    ?>
                                    <div class="row">
                                        <h5>Saldo inicial: <?php
                                            $anterior = $relatorioPDO->selectRelatorio_mensalId($atual->getAnterior());
                                            $anterior = new relatorio_mensal($anterior->fetch());
                                            echo'R$ ' . $anterior->getSaldofinal();
                                            ?></h5>
                                    </div>
                                    <thead>
                                        <tr>
                                            <th>Dia</th>
                                            <th>Entrada</th>
                                            <th>Saida</th>
                                            <th>Saldo</th>
                                            <th>Descrição</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $valor = $anterior->getSaldofinal();
                                        while ($linha = $stmt->fetch()) {
                                            $movimento = new movimento($linha);
                                            ?>

                                            <tr>
                                                <td><?php echo $movimento->getData() ?></td>
                                                <?php
                                                if ($movimento->getOperacao() == 'entrada') {
                                                    echo "<td>" . 'R$ ' . $movimento->getValor() . "</td><td></td>";
                                                    $valor = $valor + $movimento->getValor();
                                                } else {
                                                    echo "<td></td><td>" . 'R$ ' . ($movimento->getValor()) . "</td>";
                                                    $valor = $valor - $movimento->getValor();
                                                }
                                                ?>
                                                <td><?php echo 'R$ ' . number_format($valor, 2, '.', ''); ?></td>
                                                <td><?php echo $movimento->getDescricao(); ?></td>
                                            </tr>



                                            <?php
                                        }
                                        ?> </tbody></table>
                                <h5>Saldo final: <?php echo 'R$ ' . number_format($valor, 2, '.', ''); ?></h5><?php
                            } else {
                                echo 'Nenhum movimento';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <?php
    include_once '../Base/footer.php';
    ?>
    <script>
        $('select').formSelect();
    </script>
</body>
</html>

