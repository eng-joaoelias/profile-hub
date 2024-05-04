<?php

include 'config.php';

if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/' . $image;

   $select = mysqli_query($conn, "SELECT * FROM `usuario` WHERE email = '$email' AND senha = '$pass'") or die('query failed');

   if (mysqli_num_rows($select) > 0) {
      $message[] = 'Usuário já existe';
   } else {
      if ($pass != $cpass) {
         $message[] = 'As senhas não são iguais!';
      } elseif ($image_size > 2000000) {
         $message[] = 'Imagem muito grande!';
      } else {
         $insert = mysqli_query($conn, "INSERT INTO `usuario`(nome, email, senha, ft_perfil) VALUES('$name', '$email', '$pass', '$image')") or die('query failed');

         if ($insert) {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Conta criada com sucesso!';
            header('location:login.php');
         } else {
            $message[] = 'Falha ao criar conta!';
         }
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
   <title>Criar conta</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <div class="form-container">

      <form action="" method="post" enctype="multipart/form-data">
         <h3>Criar conta</h3>
         <?php
         if (isset($message)) {
            foreach ($message as $message) {
               echo '<div class="message">' . $message . '</div>';
            }
         }
         ?>
         <input type="text" name="name" placeholder="Seu nome" class="box" required>
         <input type="email" name="email" placeholder="Seu email" class="box" required>
         <input type="password" name="password" placeholder="Crie uma senha" class="box" required>
         <input type="password" name="cpassword" placeholder="Confirme a senha" class="box" required>
         <div class="btn-primary tooltip">
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
            <div class="bottom">
               <p>Escolha sua foto de perfil.</p>
            </div>
         </div>

         <input type="submit" name="submit" value="Criar conta!" class="btn">
         <p>Já tem uma conta? <a href="login.php">Fazer login</a></p>
      </form>

   </div>

</body>

</html>