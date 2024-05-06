<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
   $update_age = mysqli_real_escape_string($conn, $_POST['update_age']);
   $update_bio = mysqli_real_escape_string($conn, $_POST['update_bio']);
   $update_telephone = mysqli_real_escape_string($conn, $_POST['update_telephone']);
   $update_cep = mysqli_real_escape_string($conn, $_POST['update_cep']);
   $update_street = mysqli_real_escape_string($conn, $_POST['update_street']);
   $update_district = mysqli_real_escape_string($conn, $_POST['update_district']);
   $update_city = mysqli_real_escape_string($conn, $_POST['update_city']);
   $update_state = mysqli_real_escape_string($conn, $_POST['update_state']);

   mysqli_query($conn, "UPDATE `usuario` SET nome = '$update_name', email = '$update_email', idade = '$update_age', biografia = '$update_bio', telefone = '$update_telephone', cep = '$update_cep', rua = '$update_street', bairro = '$update_district', cidade = '$update_city', uf = '$update_state' WHERE id_usuario = '$user_id'") or die('query failed');


   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/' . $update_image;

   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $message[] = 'Imagem muito grande';
      } else {
         $image_update_query = mysqli_query($conn, "UPDATE `usuario` SET ft_perfil = '$update_image' WHERE id_usuario = '$user_id'") or die('query failed');
         if ($image_update_query) {
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'Imagem atualizada com sucesso!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
   <title>Atualizar o perfil</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <div class="update-profile">

      <?php
      $select = mysqli_query($conn, "SELECT * FROM `usuario` WHERE id_usuario = '$user_id'") or die('query failed');
      if (mysqli_num_rows($select) > 0) {
         $fetch = mysqli_fetch_assoc($select);
      }
      ?>

      <form action="" method="post" enctype="multipart/form-data">
         <?php
         if ($fetch['ft_perfil'] == '') {
            echo '<img src="images/default-avatar.png">';
         } else {
            echo '<img src="uploaded_img/' . $fetch['ft_perfil'] . '">';
         }
         if (isset($message)) {
            foreach ($message as $message) {
               echo '<div class="message">' . $message . '</div>';
            }
         }
         ?>
         <div class="flex">
            <div class="inputBox">

               <span>Seu nome :</span>
               <input type="text" name="update_name" value="<?php echo $fetch['nome']; ?>" class="box" required>
               <span>Seu email :</span>
               <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box" required>
               <span>Seu telefone :</span>
               <input type="tel" name="update_telephone" value="<?php echo $fetch['telefone']; ?>" class="box">
               <span>Sua idade :</span>
               <input type="number" name="update_age" value="<?php echo $fetch['idade']; ?>" class="box">

               <div class="info-cep">
                  <span>Digite o CEP :</span>
                  <div class="btn-primary tooltip">
                     <i class="fa fa-question-circle" aria-hidden="true"></i>
                     <div class="bottom">
                        <p><span><i class="fa-solid fa-circle-info"></i></span>Preenchendo o campo de CEP, os campos de endereço serão automaticamente preenchidos!</p>
                     </div>
                  </div>
               </div>
               <input type="text" name="update_cep" id="cep" value="<?php echo $fetch['cep']; ?>"
                  onblur="pesquisacep(this.value);" class="box">
               <span>Sua rua :</span>
               <input type="text" name="update_street" id="rua" value="<?php echo $fetch['rua']; ?>" class="box">
               <span>Seu bairro :</span>
               <input type="text" name="update_district" id="bairro" value="<?php echo $fetch['bairro']; ?>" class="box">
               <span>Sua cidade :</span>
               <input type="text" name="update_city" id="cidade" value="<?php echo $fetch['cidade']; ?>" class="box">
               <span>Seu estado :</span>
               <input type="text" name="update_state" id="uf" value="<?php echo $fetch['uf']; ?>" class="box">
               <span>Sua biografia :</span>
               <textarea name="update_bio" class="box"><?php echo $fetch['biografia']; ?></textarea>
               <span>Atualizar foto perfil :</span>
               <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">

            </div>
         </div>
         <input type="submit" value="Atualizar perfil" name="update_profile" class="btn">
         <a href="home.php" class="delete-btn">Voltar</a>
      </form>

   </div>

   <!-- Adicionando Javascript para preenchimento automático do endereço -->
   <script>
      function limpa_formulario_cep() {
         //Limpa valores do formulário de cep.
         document.getElementById('rua').value = "";
         document.getElementById('bairro').value = "";
         document.getElementById('cidade').value = "";
         document.getElementById('uf').value = "";
         //document.getElementById('ibge').value = "";
      }

      function meu_callback(conteudo) {
         if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value = (conteudo.logradouro);
            document.getElementById('bairro').value = (conteudo.bairro);
            document.getElementById('cidade').value = (conteudo.localidade);
            document.getElementById('uf').value = (conteudo.uf);
            //document.getElementById('ibge').value = (conteudo.ibge);
         } //end if.
         else {
            //CEP não Encontrado.
            limpa_formulario_cep();
            alert("CEP não encontrado.");
         }
      }

      function pesquisacep(valor) {
         // Nova variável "cep" somente com dígitos.
         var cep = valor.replace(/\D/g, '');

         // Verifica se campo cep possui valor informado.
         if (cep != "") {

            // Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            // Valida o formato do CEP.
            if (validacep.test(cep)) {

               // Preenche os campos com "..." enquanto consulta webservice.
               var ruaElement = document.getElementById('rua');
               var bairroElement = document.getElementById('bairro');
               var cidadeElement = document.getElementById('cidade');
               var ufElement = document.getElementById('uf');

               if (ruaElement && bairroElement && cidadeElement && ufElement) {
                  ruaElement.value = "...";
                  bairroElement.value = "...";
                  cidadeElement.value = "...";
                  ufElement.value = "...";

                  // Cria um elemento javascript.
                  var script = document.createElement('script');

                  // Sincroniza com o callback.
                  script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                  // Insere script no documento e carrega o conteúdo.
                  document.body.appendChild(script);
               } else {
                  console.error("Elementos de endereço não encontrados no DOM.");
               }

            } else {
               // CEP é inválido.
               limpa_formulario_cep();
               alert("Formato de CEP inválido.");
            }
         } else {
            // CEP sem valor, limpa formulário.
            limpa_formulario_cep();
         }
      }
   </script>

</body>

</html>
