<?php

//Chamando o arquivo de conexão do banco de dados.
require_once('../banco/conexao_bd.php');

$id = 0;
$descricao = '';
$situacao = 1;

if(isset($_POST['id']))
{
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
    $descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $situacao = filter_input(INPUT_POST, "situacao", FILTER_SANITIZE_NUMBER_INT);

    if (!$id)
    {
        $stm = $conexao->prepare("INSERT INTO meta (descricao,situacao) VALUES (:descricao, :situacao)");
    } else {
        $stm = $conexao->prepare("UPDATE meta SET descricao = :descricao, situacao = :situacao WHERE id = :id");
        $stm->bindValue(':id', $id);
    }

    $stm->bindValue(':descricao', $descricao);
    $stm->bindValue(':situacao', $situacao);
    $stm->execute();

    header('Location: index.php');
    exit;
}

if(isset($_GET['id']))
{
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    if(!$id){
        header('Location: index.php');
        exit;
    }

    $stm = $conexao->prepare('SELECT * FROM meta WHERE id = :id');
    $stm->bindValue('id', $id);
    $stm->execute();
    $resultado = $stm->fetch();

    if (!$resultado){
        header('Location: index.php');
        exit;
    }

    $descricao = $resultado['descricao'];
    $situacao = $resultado['situacao'];

}

//Incluindo o cabeçalho na página.
include_once('../layout/cabecalho.php');
?>

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5><?= $id?'Editar Meta Cod: ' . $id:'Adicionar Meta'?></h5>
        <a class="btn btn-success" href="cadastrar.php">Adicionar</a>
    </div>
    <form method="post" autocomplete="off">
        <div class="card-body">
           <input type="hidden" name="id" value="<?= $id ?>"/>
           <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao" value="<?= $descricao ?>" required/>
           </div>
           <div class="form-group">
                <label for="situacao">Situação</label>
                <select class="form-select" id="situacao" name="situacao" required>
                    <option value="1" <?= $situacao == 1 ? 'selected' : '' ?> >Aberta</option>
                    <option value="2" <?= $situacao == 2 ? 'selected' : '' ?> >Em andamento</option>
                    <option value="3" <?= $situacao == 3 ? 'selected' : '' ?> >Concluída</option>
                </select>
           </div>
        </div>
        <div class="card-footer">
           <button type="submit" class="btn btn-success">Salvar</button>
           <a class="btn btn-primary" href="index.php">Voltar</a>
        </div>
    </form>
</div>



<?php
//Incluindo o rodapé na página.
 include_once('../layout/rodape.php'); 
 ?>