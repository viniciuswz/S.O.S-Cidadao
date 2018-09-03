<?php
if($resultado[0]['descri_tipo_usu'] == 'Adm' OR $resultado[0]['descri_tipo_usu'] == 'Moderador'){
    echo '<li><a href="admin-moderador.php"><i class="icone-adm"></i>Area de administrador</a></li>';
    echo '<hr>';
}else if($resultado[0]['descri_tipo_usu'] =='Prefeitura'){
    echo '<li><a href="prefeitura-admin.php"><i class="icone-salvar"></i>Area da prefeitura </a></li>';
    echo '<li><a href="prefeitura-reclamacao.php"><i class="icone-salvar"></i>Reclamações nao respondidas</a></li>';
    echo '<hr>';
}else if($resultado[0]['descri_tipo_usu'] == 'Funcionario'){
    echo '<li><a href="prefeitura-reclamacao.php"><i class="icone-salvar"></i>Reclamações nao respondidas</a></li>';
    echo '<hr>';
}             