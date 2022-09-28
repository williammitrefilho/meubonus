<div class="main">
  <div class='nome-pagina'>
    <h3>Acesso</h3>
  </div>
  <div class="conteudo">
    <?php if($erro != ""){?>
    <div class="msg-erro"><?php echo $erro?></div>
    <?php }?>
    <div class="formulario">
      <form method="post">
        <table class="form-login">
          <tr>
            <td>Usuário</td><td><input class="in-login" type="text" class="in-usuario" name="usuario"></td>
          </tr>
          <tr>
            <td>Senha</td><td><input class="in-login" type="password" class="in senha" name="senha"></td>
          </tr>
          <tr>
            <td colspan="2"><button type="submit" class="btn acesso">Acessar</button></td>
          </tr>          
        </table>
      </form>
    </div>
  </div>
</div>