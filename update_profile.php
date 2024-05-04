<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
   $update_age = mysqli_real_escape_string($conn, $_POST['update_age']);
   $update_address = mysqli_real_escape_string($conn, $_POST['update_address']);
   $update_bio = mysqli_real_escape_string($conn, $_POST['update_bio']);
   $update_telephone = mysqli_real_escape_string($conn, $_POST['update_telephone']);

   mysqli_query($conn, "UPDATE `usuario` SET nome = '$update_name', email = '$update_email', idade = '$update_age', endereco = '$update_address', biografia = '$update_bio', telefone = $update_telephone WHERE id_usuario = '$user_id'") or die('query failed');

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
   <link rel="shortcut icon" href="./images/favicon.svg" type="image/x-icon">
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
               <input type="text" name="update_name" value="<?php echo $fetch['nome']; ?>" class="box">
               <span>Seu email :</span>
               <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
               <span>Seu telefone :</span>
               <input type="tel" name="update_telephone" value="<?php echo $fetch['telefone']; ?>" class="box">
               <span>Sua idade :</span>
               <input type="number" name="update_age" value="<?php echo $fetch['idade']; ?>" class="box">
               <span>Seu endereço :</span>
               <input type="text" name="update_address" value="<?php echo $fetch['endereco']; ?>" class="box">
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

</body>

</html>