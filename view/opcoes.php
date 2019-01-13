<?php
    if(!isset($voltar)){
        $voltar = '';
    }
?>
<li><a id="idPerfilUsu" href="<?php echo $voltar ?>perfil_reclamacao/<?php echo $_SESSION['id_user']?>"><i class="icone-user"></i>Meu perfil</a></li>
<li><a href="<?php echo $voltar ?>salvos"><i class="icone-salvar"></i>Salvos</a></li>
    <hr>
<?php
switch($resultado[0]['descri_tipo_usu']){
    case 'Adm':
            echo '<li><a href="'.$voltar.'admin-moderador?tipo[]=Moderador&tipo[]=Prefeitura"><i class="icone-adm"></i>Área de administrador</a></li>';
            echo '<li><a href="'.$voltar.'admin-denuncia?tipo[]=Comen&tipo[]=Debate&tipo[]=Publi"><i class="icone-adm"></i>Denúncias não verificadas</a></li>';
            echo '<hr>';
        break;
    case 'Moderador':
            echo '<li><a href="'.$voltar.'admin-denuncia?tipo[]=Comen&tipo[]=Debate&tipo[]=Publi"><i class="icone-adm"></i>Denúncias não verificadas</a></li>';
            echo '<hr>';
        break;
    case 'Prefeitura':
            echo '<li><a href="'.$voltar.'prefeitura-admin"><i class="icone-prefeitura"></i>Área da prefeitura </a></li>';
            echo '<li><a href="'.$voltar.'prefeitura-reclamacao"><i class="icone-prefeitura"></i>Reclamações não respondidas</a></li>';
            echo '<hr>';
        break;
    case 'Funcionario':
            echo '<li><a href="'.$voltar.'prefeitura-reclamacao"><i class="icone-prefeitura"></i>Reclamações não respondidas</a></li>';
            echo '<hr>';
        break;
}
?>
<li><a href="<?php echo $voltar ?>configuracoes"><i class="icone-config"></i>Configurações</a></li>
<li><a href="<?php echo $voltar ?>Sair.php"><i class="icone-logout"></i>Log out</a></li>
   