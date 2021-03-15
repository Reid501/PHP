<?php 

    include('config/db_connect.php');


    $email = $title = $ingredients = "";

    $errors = ["email" => "", "title" => "", "ingredients" => ""];
    

    if(isset($_POST['submit'])){

        // Check Email
        if(empty($_POST['email'])){
            $errors['email'] = 'An email is required <br />';
        } else {
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = "email must be a valid email address.";
            }
        }

        // Check Title
        if(empty($_POST['title'])){
            $errors['title'] = 'An title is required <br />';
        } else {
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                $errors['title'] = "Title must be letters and spaces only.";
            }
        }

        // Check Ingredients
        if(empty($_POST['ingredients'])){
            $errors['ingredients'] = 'At lease one ingredient is required <br />';
        } else {
            $ingredients = $_POST['ingredients'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
                $errors['ingredients'] = "Ingrediants must be a comma seperated list";
        }
    } 

    if(array_filter($errors)){
        
    } else {
        
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $title = mysqli_real_escape_string($conn, $_POST['title']);

        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

        // create sql
        $sql = "INSERT INTO pizzas(title, email, ingredients) VALUES('$title', '$email', '$ingredients')";

        //  Save to DB then check
        if(mysqli_query($conn, $sql)){
            // succese
            header('Location: index.php');
        } else {
            // Error
            echo 'query error: ' . mysqli_error($conn);
        }
        
    }

}// End of post check.

?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php'); ?>

    <section class="container grey-text">
        <h4 class="center">Add A Pizza</h4>
        <form class="white" action="add.php" method="POST">
            <label>Your Email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
            <div class="red-text"><?php echo $errors['email']; ?></div>
            <label>Pizza:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
            <div class="red-text"><?php echo $errors['title']; ?></div>
            <label>Ingredients (comma separated):</label>
            <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
            <div class="red-text"><?php echo $errors['ingredients']; ?></div>
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
        </form>
    </section>

    <?php include('templates/footer.php'); ?>
</html>