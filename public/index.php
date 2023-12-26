<?php

//Chamando o arquivo de conexão do banco de dados.
require_once('../banco/conexao_bd.php');

if (isset($_GET['excluir']))
{
    $id = filter_input(INPUT_GET, 'excluir', FILTER_SANITIZE_NUMBER_INT);

    if($id)
        $conexao->exec('DELETE FROM meta WHERE id ='.$id);
    
    header('Location: index.php');
    exit;
}

//Estabelecendo a conexão com o banco de dados.
$resultado = $conexao->query('SELECT * FROM  meta ORDER BY situacao DESC')->fetchAll();

$arraySituacao = [1 => 'Aberta', 2 => 'Em Andamento', 3 => 'Realizada'];

//Incluindo o cabeçalho na página.
include_once('../layout/cabecalho.php');
?>

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Minhas Metas | 2026</h5>

        <a class="btn btn-success" href="cadastrar.php">Adicionar</a>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Situação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($resultado as $item): ?>
                    <tr>
                        <td><?= $item['descricao']?></td>
                        <td><?= $arraySituacao[$item['situacao']]?></td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="cadastrar.php?id=<?= $item['id']?>">Editar</a>
                            <button Class="btn btn-sm btn-danger" onclick="excluir(<?= $item['id']?>)">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    function excluir(id)
    {
        if (confirm("Deseja Excluir esta meta?")){
            window.location.href="index.php?excluir="+id;
        }
    }
</script>






<?php
//Incluindo o rodapé na página.
 include_once('../layout/rodape.php'); 
 ?>