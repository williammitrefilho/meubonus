<?php echo Renderer::renderBloco('index/header');?>
<div class="main">
  <!--<div class="nome-pagina">
    <h3>Index</h3>
  </div>-->
  <div class="middle">
    <span class="subtitulo">Novo pagamento</span>
    <div class="c-form">
      <span class="t-label">Data</span>
      <span id="c-in-data"><input type="hidden" name="data" id="in-data"></span>
    </div>
    <div class="c-form">
      <span class="t-label">Usuário</span>
      <span id="c-in-usuario"><input type="hidden" name="usuario" id="in-usuario"></span>
    </div>
    <div id="detspagto">
      <div id="c-dets">
      </div>
      <div class="c-form">
        <span class="subtitulo2">Valor total: <span id="ph-valor-total">0,00</span></span>
        <span class="subtitulo1">Incluir item</span>
         <table>
          <tr>
            <td><span class="t-label">Descrição</span></td>
            <td><input id="in-desc" type="text" class="t-input"></td>
          </tr>
          <tr>
            <td><span class="t-label">Valor</span></td>
            <td id="c-in-valor"></td>
          </tr>
          <tr>
            <td>Arquivo (opcional)</td>
            <td>
              <button id="btn-escolher-arq" class="btn-form">Buscar arquivo</button>
              <input type="file" id="in-arq">
              <span id="erro-arq">formato não suportado</span>
              <span id="ok-arq">OK</span>
            </td>
          </tr>
          <tr>
            <td colspan="2"><button class="btn-enviar" id="incluir-item">Incluir</td>
          </tr>
         </table>
      </div>
    </div>
    <div id="c-btn-final">
      <button class="btn-enviar" id="cadastrar-pagto">Cadastrar Pagamento</button>
    </div>
  </div>    
</div>
<?php echo Renderer::renderBloco('index/footer');?>