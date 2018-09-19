<li><a href="perfil_reclamacao.php"><i class="icone-user"></i>Meu perfil</a></li>
<li><a href="salvos.php"><i class="icone-salvar"></i>Salvos</a></li>
    <hr>
<?php
switch($resultado[0]['descri_tipo_usu']){
    case 'Adm':
            echo '<li><a href="admin-moderador.php"><i class="icone-adm"></i>Area de administrador</a></li>';
            echo '<li><a href="admin-denuncia.php"><i class="icone-adm"></i>Denuncias não verificadas</a></li>';
            echo '<hr>';
        break;
    case 'Moderador':
            echo '<li><a href="admin-denuncia.php"><i class="icone-adm"></i>Denuncias não verificadas</a></li>';
            echo '<hr>';
        break;
    case 'Prefeitura':
            echo '<li><a href="prefeitura-admin.php"><i class="icone-salvar"></i>Area da prefeitura </a></li>';
            echo '<li><a href="prefeitura-reclamacao.php"><i class="icone-salvar"></i>Reclamações nao respondidas</a></li>';
            echo '<hr>';
        break;
    case 'Funcionario':
            echo '<li><a href="prefeitura-reclamacao.php"><i class="icone-salvar"></i>Reclamações nao respondidas</a></li>';
            echo '<hr>';
        break;
}
?>
<li><a href="configuracoes.php"><i class="icone-config"></i>Configurações</a></li>
<li><a href="../sair.php"><i class="icone-logout"></i>Log out</a></li>
   