<?php
session_start();
    $NomeArquivo = dirname(__FILE__);
    $posicao = strripos($NomeArquivo, "\Templates");
    if($posicao){
        $NomeArquivo = substr($NomeArquivo, 0, $posicao);
    }
    define ('WWW_ROOT', $NomeArquivo); 
    define ('DS', DIRECTORY_SEPARATOR);    
    require_once('../autoload.php');
    
    
    use Core\Usuario;
    
    try{
        
        $tipoUsuPermi = array('Prefeitura');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado         
        $usu = new Usuario();         
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;  
        $res = $usu->getDadosUsuByTipoUsu(array('Funcionario'),$_GET['pagina']);
        //var_dump($res);             
        
        $quantidadePaginas = $usu->getQuantidadePaginas();
        $pagina = $usu->getPaginaAtual();
        if(empty($res)){
            echo 'Não há nenhuma denuncia para verificar<br>';
        }
        
       
?>
<html>
    <head>
        <style>
            th{
                border: 1px solid red;
            }
            td{
                border: 1px solid green;
            }

             ul{
                text-align: center;
            }
            ul li{
                display: inline-block;
                margin-left: 10px;
                background-color: pink;
                width: 100px
            }
            ul li:hover{
                background-color: red;
            }
            ul li a{
                text-decoration: none;
                color: black;
                font-size: 20px;
            }
            .jaca {
                background-color:green;
            }
        </style>
        
    </head>
    <body>
        <table>
            <tr>
                <th>Usuario</th>                
                <th>Data</th>               
                <th>Email</th> 
                <th>Bloquear Usuario</th>
            <tr>
            <?php
                $contador = 0;
                $contador2 = 0;
                while($contador < count($res)){
                    echo '<tr>';  
                        echo '<td>'.$res[$contador]['nome_usu'].'</td>';                        
                        echo '<td>'.$res[$contador]['dataHora_cadastro_usu'].'</td>';        
                        echo '<td>'.$res[$contador]['email_usu'].'</td>';                
                        echo '<td> <a href="'.$res[$contador]['LinkApagarUsu'].'">Remover Funcao</td>'; 
                    echo '</tr>';
                    $contador++;
                    $contador2 = 0;
                }
            ?>
        </table>
        <ul>
        <?php
            if($quantidadePaginas != 1){
                $contador = 1;
                while($contador <= $quantidadePaginas){
                    if(isset($pagina) AND $pagina == $contador){
                        echo '<li class="jaca"><a href="VerFuncionariosTemplate.php">Pagina'.$contador.'</a></li>'  ;  
                    }else{
                        echo '<li><a href="VerFuncionariosTemplate.php?pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ;
                    }                    
                    $contador++;        
                }
            }            
        ?>
        </ul> 	
        
        <a href="cadastrarUserTemplate.php">Cadastrar Usuario</a>
    </body>


</html>

<?php

}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();  
    switch($erro){
        case 2://Nao esta logado    
            echo "<script> alert('$mensagem');javascript:window.location='./loginTemplate.php';</script>";
            break;
        case 6://Não é usuario prefeitura ou func  
            echo "<script> alert('$mensagem');javascript:window.location='./starter.php';</script>";
            break; 
        case 9://Não foi possivel achar a publicacao  
            echo "<script> alert('$mensagem');javascript:window.location='VisualizarPublicacoesTemplate.php';</script>";
            break; 
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='VisualizarPublicacoesTemplate.php';</script>";
    }   
}

?>