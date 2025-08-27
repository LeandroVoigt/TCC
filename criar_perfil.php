<?php 
$conn = new mysqli('localhost', 'root', 'OLESCSUB16', 'sporthub');
if ($conn->connect_error) {
    die('Erro na conexão: ' . $conn->connect_error);
}

if (isset($_POST['salvar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $biografia = $_POST['biografia'];
    $foto = $_FILES['foto'];

    if ($foto['error'] === UPLOAD_ERR_OK) {
        $foto_nome = time() . '_' . basename($foto['name']);
        $foto_caminho = 'imagemperfilclube/' . $foto_nome;
        move_uploaded_file($foto['tmp_name'], $foto_caminho);
    } else {
        $foto_caminho = $_POST['foto_atual'];
    }

    if ($id) {
        $sql = "UPDATE clubes SET nome='$nome', biografia='$biografia', foto_perfil='$foto_caminho' WHERE id=$id";
    } else {
        $sql = "INSERT INTO clubes (nome, foto_perfil, biografia) VALUES ('$nome', '$foto_caminho', '$biografia')";
    }
    $conn->query($sql);
}

$perfil = $conn->query("SELECT * FROM clubes ORDER BY id DESC LIMIT 1")->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil do Clube</title>
  <link rel="stylesheet" href="criar_perfil.css">
  <style>
    /* estilo dos blocos de ligas */
    .ligas-container {
      margin: 20px 0;
    }
    .ligas-container h3 {
      margin-bottom: 10px;
      font-size: 18px;
      font-weight: bold;
    }
    .ligas-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 15px;
    }
    .liga-card {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px;
      border-radius: 10px;
      background: #f5fbff;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      cursor: pointer;
      transition: 0.2s;
    }
    .liga-card:hover {
      background: #eaf6ff;
    }
    .liga-card img {
      width: 35px;
      height: 35px;
      object-fit: contain;
    }
    .liga-card span {
      font-weight: 600;
      color: #002855;
      font-size: 15px;
    }
  </style>
</head>
<body>
  <div class="perfil-container">

    <header class="header">
      <div class="title">Sport HUB</div>
      <div class="buttons">
        <input type="text" id="searchInput" placeholder="Buscar clube..." class="search-input">
        <button id="notificacoes-btn">🔔 Notificações</button>
        <a href="ClubesPeneiras.html" class="profile-btn">👤 Principal</a>
      </div>
    </header>

    <form action="criar_perfil.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo isset($perfil) ? $perfil['id'] : ''; ?>">
      <input type="hidden" name="foto_atual" value="<?php echo isset($perfil) ? $perfil['foto_perfil'] : 'default-profile.png'; ?>">

      <div class="perfil-layout">  
        <div class="foto-perfil-container">
          <img src="<?php echo isset($perfil) ? $perfil['foto_perfil'] : 'imagemperfilclube/default-profile.png'; ?>" alt="Foto de Perfil" class="foto-perfil">
          <input type="file" name="foto" id="upload-foto" accept="image/*">
        </div>

        <div class="info-perfil-container">
          <input type="text" name="nome" class="nome-usuario" placeholder="Digite seu nome" value="<?php echo isset($perfil) ? $perfil['nome'] : ''; ?>"/>
          <textarea name="biografia" class="bio-usuario" placeholder="Digite sua biografia"><?php echo isset($perfil) ? $perfil['biografia'] : ''; ?></textarea>
        </div>
      </div>

      <button type="submit" name="salvar" class="botao-salvar">Salvar Perfil</button>
    </form>

    <!-- BLOCO DE LIGAS NO PERFIL -->
    <div class="ligas-container">
      <h3>Competições</h3>
      <div class="ligas-grid">
        <div class="liga-card" data-liga="Brasileirão Série D"><img src="logos/brasileirao_d.png"><span>Brasileirão Série D</span></div>
        <div class="liga-card" data-liga="Catarinense Série A"><img src="logos/catarinense_a.png"><span>C.Catarinense Série A</span></div>
        <div class="liga-card" data-liga="Catarinense Série A - Sub17"><img src="logos/catarinense_a.png"><span>C.Catarinense Série A - Sub17</span></div>
        <div class="liga-card" data-liga="Catarinense Série A - Sub15"><img src="logos/catarinense_a.png"><span>C.Catarinense Série A - Sub15</span></div>
        <div class="liga-card" data-liga="Copa Santa Catarina"><img src="logos/copa_sc.png"><span>Copa Santa Catarina</span></div>
        <div class="liga-card" data-liga="Copa Santa Catarina Sub-17"><img src="logos/copa_sc.png"><span>Copa Santa Catarina Sub-17</span></div>
        <div class="liga-card" data-liga="Joguinhos Abertos Sub-18"><img src="logos/jogos_abertos.png"><span>Joguinhos Abertos Sub-18</span></div>
      </div>
    </div>

    <!-- Botão para adicionar liga -->
    <button class="botao-adicionar-liga">Adicionar Liga</button>

    <!-- Tabela de ligas -->
    <div class="tabela-ligas" style="display: none;">
      <form action="criar_perfil.php" method="POST">
        <table>
          <thead>
            <tr>
              <th>Ligas Sugeridas</th>
              <th>Competição</th>
              <th>Categoria</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <select name="liga_sugerida" class="liga-select">
                  <option value="">Selecione uma Liga</option>
                  <option value="Campeonato Catarinense Série A" data-img="logos/catarinense_a.png">Campeonato Catarinense Série A</option>
                  <option value="Campeonato Catarinense Série B" data-img="logos/catarinense_b.png">Campeonato Catarinense Série B</option>
                  <option value="Campeonato Brasileiro Série D" data-img="logos/brasileirao_d.png">Brasileirão Série D</option>
                  <option value="Copa Santa Catarina" data-img="logos/copa_sc.png">Copa Santa Catarina</option>
                </select>
              </td>
              <td><input type="text" name="competicao" id="competicao" placeholder="Digite a Competição"/></td>
              <td><input type="text" name="categoria" placeholder="Digite a Categoria"/></td>
            </tr>
          </tbody>
        </table>
        <button type="submit" name="finalizar" id="finalizar-liga">Finalizar</button>


        
      </form>
    

    </div>
    <h3>Peneiras</h3>
  <div class="tryouts-grid">
    <!-- Card Sub-17 -->
    <div class="tryout-card sub17">
      <h4>⚽ Peneira Sub-17</h4>
      <p><strong>Data:</strong> 13/02/2025 9:30 </p>
      <p><strong>Anos:</strong>2008/2009</p>
      <p><strong>Local:</strong> Campo ACPNC (Itajaí)</p>
      <p><strong>Informações:</strong> Traga documento com foto, roupa de treino e chuteira. Chegar com 30 minutos de antecedência.</p>
      <button class="inscrever-btn">📋 Inscrever</button>
    </div>

    <!-- Card Sub-14 -->
    <div class="tryout-card sub14">
      <h4>⚽ Peneira Sub-15</h4>
      <p><strong>Data:</strong> 14/02/2025 11:30 </p>
      <p><strong>Anos:</strong> 2010/2011</p>
      <p><strong>Local:</strong>  Campo ACPNC (Itajaí)</p>
      <p><strong>Informações:</strong> Traga documento com foto, roupa de treino e chuteira. Chegar com 30 minutos de antecedência.</p>
          <button class="inscrever-btn">📋 Inscrever</button>
                   </div>
                 </div>
                </section>

                <!--Estádios-->
                <section class="stadiums">
                <h3>Estádios</h3>

                <div class="stadium-card">
                  <img src="MarcilioEstadio.webp" alt="Dr. Hercílio Luz" class="stadium-image" />
                  <p class="stadium-name">Dr. Hercílio Luz Itajaí - SC</p>
                  <a href="https://www.google.com.br/maps/place/Estadio+Dr.+Hercilio+Luz+-+Rua+Gil+Stein+Ferreira,+261+-+Centro,+Itajaí+-+SC,+88301-210/@-26.9095056,-48.6624102,17.5z/data=!4m14!1m7!3m6!1s0x94e70d0011984d57:0x2215e4d234e38672!2sEstádio+Dr.+Hercílio+Luz!8m2!3d-26.9084026!4d-48.6597802!16s%2Fg%2F12295w1v!3m5!1s0x94d8cc7338d03ab5:0x571c0ead9bb00ce2!8m2!3d-26.9080898!4d-48.6598808!16s%2Fg%2F11bvthtq8g?hl=pt-BR&entry=ttu&g_ep=EgoyMDI1MDcwOS4wIKXMDSoASAFQAw%3D%3D" 
                     target="_blank" 
                     class="map-link">📍 Ver no Mapa</a>
                </div>

                </section>

                <!-- Fotos -->
                <div class="fotos-section">
                  <h3>Fotos</h3>
                  <div class="fotos-grid">
                    <img src="MarcilioImagem1.jpg" alt="Foto 1" class="foto-post">
                    <img src="MarcilioImagem2.jpg" alt="Foto 2" class="foto-post">
                    <img src="MarcilioImagem3.jpg" alt="Foto 3" class="foto-post">
                    <img src="MarcilioImagem4.jpg" alt="Foto 3" class="foto-post">
                    <img src="MarcilioImagem5.jpg" alt="Foto 3" class="foto-post">
                    <img src="MarcilioImagem6.jpg" alt="Foto 3" class="foto-post">
                    <img src="MarcilioImagem7.jpg" alt="Foto 3" class="foto-post">
                    <img src="MarcilioImagem8.jpg" alt="Foto 3" class="foto-post">
                    <img src="MarcilioImagem9.jpg" alt="Foto 3" class="foto-post">
                    <img src="MarcilioImagem10.jpg" alt="Foto 3" class="foto-post">
                    
                  </div>
                </div>


                <section class="contatos">
                  <h2>Contatos</h2>
                  <p>Email: <a href="https://mail.google.com/">futeboljaci@gmail.com</a></p>
                  <p>Site oficial: <a href="https://marciliodias.com.br/" target="_blank" rel="noopener">
                    Marciliodias.com.br
                  </a></p>
                  <p>Instagram: <a href="https://www.instagram.com/marciliodiasoficial/" target="_blank" rel="noopener">
                    @marciliodiasoficial
                  </a></p>
    <footer class="footer">
      <div class="footer-content">
        <div class="footer-left">
          <h4>Sport HUB</h4>
          <p>Conectando atletas, clubes e oportunidades pelo Brasil.</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 Sport HUB. Todos os direitos reservados.</p>
      </div>

  
      
    </footer>
  </div>

  <script>
    // botão de adicionar liga
    document.querySelector('.botao-adicionar-liga').addEventListener('click', function() {
      document.querySelector('.tabela-ligas').style.display = 'block';
    });

    // bloquear o campo "competição" quando escolher liga
    const selectLiga = document.querySelector('.liga-select');
    const campoCompeticao = document.getElementById('competicao');

    selectLiga.addEventListener('change', function () {
      if (selectLiga.value !== "") {
        campoCompeticao.value = selectLiga.value;
        campoCompeticao.readOnly = true; // trava digitação
      } else {
        campoCompeticao.value = "";
        campoCompeticao.readOnly = false; // libera caso não selecione
      }
    });
  </script>
</body>
</html>