<?php
/** 
 * Template du formulaire d'update/creation d'un article. 
 */

$id = $article->getId();
$modeTitle = $id == -1 ? "Création d'un article" : "Modification de l'article";
$title = $article->getTitle();
$content = $article->getContent();
$modeButton = $id == -1 ? "Ajouter" : "Modifier";

// HereDoc pour afficher les variables récupérés
$form = <<<FORM
    <form action="index.php" method="post" class="foldedCorner">
        <h2>$modeTitle</h2>
        <div class="formGrid">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" value="$title" required>
            <label for="content">Contenu</label>
            <textarea name="content" id="content" cols="30" rows="10" required>$content</textarea>
            <input type="hidden" name="action" value="updateArticle">
            <input type="hidden" name="id" value="$id">
            <button class="submit">$modeButton</button>
        </div>
    </form>
FORM;
echo $form;
?>